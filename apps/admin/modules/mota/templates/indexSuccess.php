<h1>Motak</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Izena</th>
<!--      <th></th> -->
    </tr>
  </thead>
  <tbody>
    <?php foreach ($motas as $mota): ?>
    <tr>
      <td><?php echo $mota->getId() ?></td>
      <td><?php echo $mota->getIzena() ?></td>
<!--
      <td>
	<?php //echo link_to('Ezabatu', 'mota/delete?id='.$mota->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>
      </td>
-->
    </tr>
    <?php endforeach; ?>

<!--
    <tr><td colspan=3 align=right><a href="<?php //echo url_for('mota/new') ?>">Berria</a></td></tr>
-->
  </tbody>
</table>

