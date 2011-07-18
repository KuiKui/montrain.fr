<h1><a href="<?php echo url_for('@homepage') ?>">montrain.fr</a></h1>
<a href="<?php echo url_for('@homepage') ?>">Choix de la ligne</a><br />
<h2>Liste des discussions de la ligne <?php echo $ligne->getNom() ?></h2>
<ul id="discussionsList"></ul>
<a id="moreDiscussions" href="#" title="Voir plus de discussions" style="display:none;">Voir plus de discussions</a>
<form name="discussionForm" id="discussionForm" action="<?php echo url_for('home/addDiscussion') ?>" method="post">
  <input type="hidden" id="ligneId" name="ligneId" value="<?php echo $ligne->getId() ?>"/>
  <input type="text" id="titre" name="titre" maxlength="<?php echo $discussionMaxLength ?>"/>
  <input type="submit" value="Créer" id="creer"/>
</form>
<div id="informations"></div>
