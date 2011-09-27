<form name="trainForm" id="trainForm" action="<?php echo url_for('home/discussionsList') ?>" method="get">
  <h2 class="title">Sélectionnez une gare</h2>
  <select id="gare">
    <option value="0">Sélectionnez une gare</option>
      <?php foreach ($gares as $gare): ?>
        <option value="<?php echo $gare->getId() ?>"><?php echo $gare->getNom() ?></option>
      <?php endforeach; ?>
  </select>
  <div id="ligneBloc" style="display:none;">
    <h2 class="title">Puis une ligne</h2>
    <select id="ligne" name="ligne"></select>
  </div>
  <div id="discuterBloc" style="display:none;">
    <button type="submit" id="discuter">Discuter</button>
  </div>
</form>
<a id="newGare" href="#">Votre gare n'est pas disponible ?</a>
<a id="newLigne" href="#" style="display:none;">Votre ligne n'est pas disponible ?</a>
