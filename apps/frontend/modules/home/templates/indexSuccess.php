<h1><a href="<?php echo url_for('@homepage') ?>">montrain.fr</a></h1>
<form name="trainForm" id="trainForm" action="<?php echo url_for('home/discussionsList') ?>" method="get">
  <select id="gare">
    <option value="0">Sélectionnez une gare</option>
      <?php foreach ($gares as $gare): ?>
        <option value="<?php echo $gare->getId() ?>"><?php echo $gare->getNom() ?></option>
      <?php endforeach; ?>
  </select>
  <select id="ligne" name="ligne" style="display:none;"></select>
  <input type="submit" value="Discuter" id="discuter" style="display:none;" />
</form>
<a id="newGare" href="#">Votre gare n'est pas disponible ?</a>
<a id="newLigne" href="#" style="display:none;">Votre ligne n'est pas disponible ?</a>
