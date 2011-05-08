<h1><a href="<?php echo url_for('@homepage') ?>">montrain.fr</a></h1>
<a href="<?php echo url_for('home/discussionsList?ligne='.$discussion->getLigneId()) ?>">Liste des discussions</a><br />
<h2><?php echo $discussion->getNom() ?></h2>

<form name="messageForm" id="messageForm" action="<?php echo url_for('home/addMessage') ?>" method="post">
  <input type="hidden" id="discussionId" name="discussionId" value="<?php echo $discussion->getId() ?>" />
  <input type="text" id="contenu" name="contenu" maxlength="140" />
  <input type="submit" value="Ecrire" id="ecrire" />
</form>
<div id="informations"></div>

<ul id="messagesList" data-last-message-id="<?php echo $lastMessageId ?>" data-displayed-messages-amount="<?php echo $displayedMessagesAmount ?>">
    <?php foreach ($messages as $message): ?>
        <li><span class="contenu"><?php echo $message->getContenu() ?></span><span class="timing"><?php echo $message->getCreatedAt('\L\e m/d/Y \à H\hi:s') ?></span></li>
    <?php endforeach; ?>
</ul>
