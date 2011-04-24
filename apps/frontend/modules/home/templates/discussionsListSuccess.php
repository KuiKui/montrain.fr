<a href="<?php echo url_for('@homepage') ?>">retour</a><br />
<ul>
<?php foreach ($discussions as $discussion): ?>
  <li><?php echo link_to($discussion->getNom(), url_for('home/messagesList?discussion='.$discussion->getId())) ?></li>
<?php endforeach; ?>
</ul>
