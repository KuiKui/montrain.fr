<h1><a href="<?php echo url_for('@homepage') ?>">montrain.fr</a></h1>
<a href="<?php echo url_for('home/discussionsList?ligne=' . $discussion->getLigneId()) ?>">Liste des discussions</a>
<br/>
<h2><?php echo $discussion->getNom() ?></h2>

<form name="messageForm" id="messageForm" action="<?php echo url_for('home/addMessage') ?>" method="post">
  <input type="hidden" id="discussionId" name="discussionId" value="<?php echo $discussion->getId() ?>"/>
  <input type="text" id="contenu" name="contenu" maxlength="<?php echo $messageMaxLength ?>"/>
  <input type="submit" value="Ecrire" id="ecrire"/>
</form>
<div id="informations"></div>

<ul id="messagesList" data-last-message-id="0">
</ul>

<?php if($totalAmountOfMessages > $displayedMessagesAmount): ?>
  <a href="#" title="Voir plus de messages">Voir plus de message</a>
<?php endif;
