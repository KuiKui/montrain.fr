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
    $this->discussionMaxLength = sfConfig::get('app_discussion_max_length');
    $this->displayedDiscussionsAmount = sfConfig::get('app_displayed_discussions_amount');
    $this->ligne = LignePeer::retrieveByPK($ligneId);
    $this->totalAmountOfDiscussions = DiscussionPeer::getTotalAmountFromLigne($ligneId);
  }

  public function executeGetDiscussions(sfWebRequest $request)
  {
    $ligneId = $request->getParameter('ligneId');
    $amount = ($request->hasParameter('amount')) ? $request->getParameter('amount') : sfConfig::get('app_displayed_discussions_amount');
    $lowerBoundId = ($request->hasParameter('lowerBoundId')) ? $request->getParameter('lowerBoundId') : null;
    $upperBoundId = ($request->hasParameter('upperBoundId')) ? $request->getParameter('upperBoundId') : null;
    $reverseResults = ($request->hasParameter('reverseResults')) ? $request->getParameter('reverseResults') : false;
    $this->forward404Unless(is_numeric($ligneId) && $ligneId > 0 && $request->isXmlHttpRequest());

    $discussions = DiscussionPeer::getLastDiscussionsFromLigne($ligneId, $amount, $lowerBoundId, $upperBoundId);
    if($reverseResults)
    {
      $discussions = array_reverse($discussions, true);
    }

    $results = array(
      'discussions' => $this->formatDiscussions($discussions),
      'total'       => DiscussionPeer::getTotalAmountFromLigne($ligneId)
    );
    
    return $this->renderText(json_encode($results));
  }
  
  public function formatDiscussions($discussions)
  {
    $results = array();
    foreach($discussions as $discussion)
    {
      $results [] = array(
        'id' => $discussion->getId(),
        'heure' => $discussion->getUpdatedAt('\L\e m/d/Y \à H\hi:s'),
        'titre' => $discussion->getNom(),
        'lien'  => $this->getController()->genUrl('home/messagesList?discussion='.$discussion->getId())
      );
    }
    return $results;
  }
  
  public function executeAddDiscussion(sfWebRequest $request)
  {
    $returnCode = 1;
    $newDiscussionId = 0;
    
    $ligneId = $request->getParameter('ligneId');
    $this->forward404Unless($ligneId);
    $titre = $request->getParameter('titre');

    if(strlen($titre) > 0 && strlen($titre) <= sfConfig::get('app_discussion_max_length'))
    {
      $con = Propel::getConnection();
      try
      {
        $con->beginTransaction();
        $discussion = new Discussion();
        $discussion->setLigneId($ligneId);
        $discussion->setNom($titre);
        $discussion->save();
        $newDiscussionId = $discussion->getId();

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
      $this->redirect(url_for('home/messagesList?discussionId=' . $newDiscussionId));
    }
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
        $message->setCouleur(kGraph::sha1ToColor(sha1($_SERVER['REMOTE_ADDR'])));
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

  public function executeGetMessages(sfWebRequest $request)
  {
    $discussionId = $request->getParameter('discussionId');
    $amount = ($request->hasParameter('amount')) ? $request->getParameter('amount') : sfConfig::get('app_displayed_messages_amount');
    $lowerBoundId = ($request->hasParameter('lowerBoundId')) ? $request->getParameter('lowerBoundId') : null;
    $upperBoundId = ($request->hasParameter('upperBoundId')) ? $request->getParameter('upperBoundId') : null;
    $reverseResults = ($request->hasParameter('reverseResults')) ? $request->getParameter('reverseResults') : false;
    $this->forward404Unless(is_numeric($discussionId) && $discussionId > 0 && $request->isXmlHttpRequest());

    $messages = MessagePeer::getLastMessagesFromDiscussion($discussionId, $amount, $lowerBoundId, $upperBoundId);
    if($reverseResults)
    {
      $messages = array_reverse($messages, true);
    }

    $results = array(
      'messages'  => $this->formatMessages($messages),
      'total'     => MessagePeer::getTotalAmountFromDiscussion($discussionId)
    );
    
    return $this->renderText(json_encode($results));
  }
  
  public function formatMessages($messages)
  {
    $results = array();
    foreach($messages as $message)
    {
      $results [] = array(
        'id' => $message->getId(),
        'heure' => $message->getCreatedAt('\L\e m/d/Y \à H\hi:s'),
        'contenu' => $message->getContenu(),
        'couleur' => $message->getCouleur()
      );
    }
    return $results;
  }
}


