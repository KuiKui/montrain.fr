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
    if($request->isXmlHttpRequest())
    {
      $results = array();
      $gareId = $request->getParameter('gareId');
      if($gareId > 0) {
        $c = new Criteria();
	$c->addJoin(LigneGarePeer::LIGNE_ID, LignePeer::ID, Criteria::LEFT_JOIN);
        $c->add(LigneGarePeer::GARE_ID, $gareId);
        $c->add(LigneGarePeer::VALIDE, 1);
        $c->add(LignePeer::VALIDE, 1);
        $c->addAscendingOrderByColumn(LigneGarePeer::GARE_ID);
        $lignes = LigneGarePeer::doSelect($c);

        foreach($lignes as $ligne)
        {
          $results[$ligne->getLigne()->getId()] = sprintf('%s - %s', $ligne->getLigne()->getId(), $ligne->getLigne()->getNom());
        }      
      }

      return $this->renderText(json_encode($results));
    }
  }

  public function executeDiscussionsList(sfWebRequest $request)
  {
    $ligneId = $request->getParameter('ligne');

    $c = new Criteria();
    $c->add(DiscussionPeer::LIGNE_ID, $ligneId);
    $c->addDescendingOrderByColumn(DiscussionPeer::IMPORTANTE);
    $c->addDescendingOrderByColumn(DiscussionPeer::UPDATED_AT);
    $this->discussions = DiscussionPeer::doSelect($c);
  }

  public function executeMessagesList(sfWebRequest $request)
  {
    $discussionId = $request->getParameter('discussion');

    $this->discussion = DiscussionPeer::retrieveByPK($discussionId);

    $c = new Criteria();
    $c->add(MessagePeer::DISCUSSION_ID, $discussionId);
    $c->add(MessagePeer::VALIDE, 1);
    $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
    $this->messages = MessagePeer::doSelect($c);

    $this->lastMessageId = (count($this->messages) > 0) ? $this->messages[0]->getId() : 0;
  }

  public function executeAddMessage(sfWebRequest $request)
  {
    $returnCode = 1;
    $discussionId = $request->getParameter('discussionId');
    $contenu = $request->getParameter('contenu');

    if($discussionId > 0 && strlen($contenu) > 0 && strlen($contenu) < 140)
    {
      $con = Propel::getConnection();
      try
      {
        $con->beginTransaction();
        $message = new Message();
        $message->setDiscussionId($discussionId);
        $message->setContenu($contenu);
        $message->save();

	$discussion = DiscussionPeer::retrieveByPK($discussionId);
	$discussion->setUpdatedAt('now');
	$discussion->save();

        $returnCode = 0;
        $con->commit();
      }
      catch (Exception $e)
      {
        $con->rollback();
        throw $e;
      }
    }

    if($request->isXmlHttpRequest()) {
      return $this->renderText(json_encode('({returnCode:'.$returnCode.'})'));
    } else {
      $this->redirect(url_for('home/messagesList?discussionId='.$discussionId));
    }
  }

  public function executeGetMessages(sfWebRequest $request)
  {
    //if(!$request->isXmlHttpRequest()) return;

    $discussionId = $request->getParameter('discussionId');
    $lastMessageId = ($request->hasParameter('lastMessageId')) ? $request->getParameter('lastMessageId') : 0;
    $results = array();

    if($discussionId > 0)
    {
        // TODO: mettre dans le modèle et factoriser (appel initial, appel intermédiaire et appel pour voir plus)
      $c = new Criteria();
      $c->add(MessagePeer::DISCUSSION_ID, $discussionId);
      $c->add(MessagePeer::VALIDE, 1);
      $c->add(MessagePeer::ID, $lastMessageId, Criteria::GREATER_THAN);
      $c->addAscendingOrderByColumn(MessagePeer::CREATED_AT);
      $messages = MessagePeer::doSelect($c);
      
      foreach($messages as $message) {
        $results [] = array(
        'id' => $message->getId(),
        'heure' => $message->getCreatedAt('\L\e m/d/Y \à H\hi:s'),
        'contenu' => $message->getContenu()
        );
      }
    }
    return $this->renderText(json_encode($results));
  }

}


