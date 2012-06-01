<h1>Barrutiak</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Izena</th>
<!--      <th></th> -->
    </tr>
  </thead>
  <tbody>
    <?php foreach ($barrutias as $barrutia): ?>
    <tr>
      <td><?php echo $barrutia->getId() ?></td>
      <td><?php echo $barrutia->getIzena() ?></td>
<!--      <td>
	<?php //echo link_to('Ezabatu', 'barrutia/delete?id='.$barrutia->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>
      </td>-->
    </tr>
    <?php endforeach; ?>
      <tr><td colspan=4 align=right>
          <a href="<?php echo url_for('barrutia/new') ?>">Berria</a>
      </td></tr>
  </tbody>
</table>

