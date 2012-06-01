<br><br>
<center>
<table class="zerrenda">
  <thead>
	<tr><th><h1>Kaleak</h1><th></tr>
  </thead>
  <tbody>
    <tr>
      <th class=ezker>Id</th>
      <th class=ezker>Barrutia</th>
      <th class=ezker>Izena</th>
    </tr>
    <?php foreach ($kaleas as $kalea): ?>
    <tr>
      <td><?php echo $kalea->getId() ?></td>
      <td><?php echo $kalea->getBarrutia() ?></td>
      <td><?php echo $kalea->getIzena() ?></td>
    </tr>
    <?php endforeach; ?>
<!--
    <tr><td colspan=3 align=right>
	  <a href="<?php echo url_for('kalea/new') ?>">Berria</a>
    </td></tr>
-->
  </tbody>
</table>
</center>
