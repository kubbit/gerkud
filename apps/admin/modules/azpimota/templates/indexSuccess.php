<h1>Azpimota zerrenda</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Mota</th>
      <th>Izena</th>
<!--      <th></th> -->
    </tr>
  </thead>
  <tbody>
    <?php foreach ($azpimotas as $azpimota): ?>
    <tr>
<!--      <td><a href="<?php //echo url_for('azpimota/show?id='.$azpimota->getId()) ?>"><?php //echo $azpimota->getId() ?></a></td>-->
      <td><?php echo $azpimota->getId() ?></td>
      <td><?php echo $azpimota->getMota() ?></td>
      <td><?php echo $azpimota->getIzena() ?></td>
<!--      <td><?php //echo link_to('Ezabatu', 'azpimota/delete?id='.$azpimota->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>-->
    </tr>
    <?php endforeach; ?>

<tr><td colspan=4 align=right>
  <a href="<?php echo url_for('azpimota/new') ?>">Berria</a>
</td></tr>

  </tbody>
</table>

