<h1><a href="<?php echo url_for('@homepage') ?>">mon-TER.com</a></h1>
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
<div id="newGare">Pour ajouter une nouvelle gare</div>
<div id="newLigne" style="display:none;">Pour ajouter une nouvelle ligne</div>
