<h2 class="title mainTitle">Ligne <?php echo $ligne->getNom() ?></h2>
<h2 class="title">Liste des discussions</h2>

<ul id="discussionsList"></ul>
  
<a id="moreDiscussions" href="#" title="Voir plus de discussions" style="display:none;">Voir plus de discussions</a>
<form name="discussionForm" id="discussionForm" action="<?php echo url_for('home/addDiscussion') ?>" method="post">
  <h2 class="title">Créer une nouvelle discussion</h2>
  <input type="hidden" id="ligneId" name="ligneId" value="<?php echo $ligne->getId() ?>"/>
  <input type="text" id="titre" name="titre" maxlength="<?php echo $discussionMaxLength ?>"/>
  <button type="submit" id="creer">Créer</button>
  <div id="informations"></div>
</form>
<a href="<?php echo url_for('@homepage') ?>"><< Choix de la ligne</a>