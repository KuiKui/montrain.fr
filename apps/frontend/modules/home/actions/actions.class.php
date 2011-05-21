<?php

class homeActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(GarePeer::NOM);
    $this->gares = GarePeer::doSelect($c);
  }

  public function executeGetLignesFromGare(sfWebRequest $request)
  {
    $gareId = $request->getParameter('gareId');
    $this->forward404Unless($gareId);

    $c = new Criteria();
    $c->addJoin(LigneGarePeer::LIGNE_ID, LignePeer::ID, Criteria::LEFT_JOIN);
    $c->add(LigneGarePeer::GARE_ID, $gareId);
    $c->add(LigneGarePeer::VALIDE, 1);
    $c->add(LignePeer::VALIDE, 1);
    $c->addAscendingOrderByColumn(LigneGarePeer::GARE_ID);
    $lignes = LigneGarePeer::doSelect($c);

    $results = array();

    foreach($lignes as $ligne)
    {
      $results[$ligne->getLigne()->getId()] = sprintf('%s - %s', $ligne->getLigne()->getId(), $ligne->getLigne()->getNom());
    }

    if($request->isXmlHttpRequest())
    {
      return $this->renderText(json_encode($results));
    }
    else
    {
      return $results;
    }
  }

  public function executeDiscussionsList(sfWebRequest $request)
  {
    $ligneId = $request->getParameter('ligne');
    $this->forward404Unless($ligneId);

    $c = new Criteria();
    $c->add(DiscussionPeer::LIGNE_ID, $ligneId);
    $c->addDescendingOrderByColumn(DiscussionPeer::IMPORTANTE);
    $c->addDescendingOrderByColumn(DiscussionPeer::UPDATED_AT);
    $this->discussions = DiscussionPeer::doSelect($c);
  }

  public function executeMessagesList(sfWebRequest $request)
  {
    $discussionId = $request->getParameter('discussion');
    $this->forward404Unless($discussionId);

    $this->messageMaxLength = sfConfig::get('app_message_max_length');
    $this->displayedMessagesAmount = sfConfig::get('app_displayed_messages_amount');
    $this->discussion = DiscussionPeer::retrieveByPK($discussionId);
    $this->totalAmountOfMessages = MessagePeer::getTotalAmountFromDiscussion($discussionId);
  }

  public function executeAddMessage(sfWebRequest $request)
  {
    $returnCode = 1;
    $discussionId = $request->getParameter('discussionId');
    $this->forward404Unless($discussionId);

    $content = $request->getParameter('contenu');

    if($discussionId > 0 && strlen($content) > 0 && strlen($content) <= sfConfig::get('app_message_max_length'))
    {
      $con = Propel::getConnection();
      try
      {
        $con->beginTransaction();
        $message = new Message();
        $message->setDiscussionId($discussionId);
        $message->setContenu($content);
        $message->save();

        $discussion = DiscussionPeer::retrieveByPK($discussionId);
        $discussion->setUpdatedAt('now');
        $discussion->save();

        $returnCode = 0;
        $con->commit();
      }
      catch(Exception $e)
      {
        $con->rollback();
        throw $e;
      }
    }

    if($request->isXmlHttpRequest())
    {
      return $this->renderText(json_encode('({returnCode:' . $returnCode . '})'));
    }
    else
    {
      $this->redirect(url_for('home/messagesList?discussionId=' . $discussionId));
    }
  }

  public function executeGetLastMessages(sfWebRequest $request)
  {
    $discussionId = $request->getParameter('discussionId');
    $amount = ($request->hasParameter('amount')) ? $request->getParameter('amount') : sfConfig::get('app_displayed_messages_amount');
    $startMessagesId = ($request->hasParameter('startMessagesId')) ? $request->getParameter('startMessagesId') : null;
    $this->forward404Unless(is_numeric($discussionId) && $discussionId > 0 && $request->isXmlHttpRequest());

    $messages = MessagePeer::getLastMessagesFromDiscussion($discussionId, $amount, $startMessagesId);
    $results = array();

    foreach($messages as $message)
    {
      $results [] = array(
        'id' => $message->getId(),
        'heure' => $message->getCreatedAt('\L\e m/d/Y \à H\hi:s'),
        'contenu' => $message->getContenu()
      );
    }

    return $this->renderText(json_encode($results));
  }
}


