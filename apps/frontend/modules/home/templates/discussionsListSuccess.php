<h1><a href="<?php echo url_for('@homepage') ?>">montrain.fr</a></h1>
<a href="<?php echo url_for('@homepage') ?>">Choix de la ligne</a><br />
<h2>Liste des discussions</h2>
<ul>
<?php foreach ($discussions as $discussion): ?>
  <li><?php echo link_to($discussion->getNom(), url_for('home/messagesList?discussion='.$discussion->getId())) ?></li>
<?php endforeach; ?>
</ul>
