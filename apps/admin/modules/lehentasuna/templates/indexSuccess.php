<h1>Lehentasunak</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Izena</th>
      <th>Kolorea</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lehentasunas as $lehentasuna): ?>
    <tr>
      <td><?php echo $lehentasuna->getId() ?></td>
      <td><?php echo $lehentasuna->getIzena() ?></td>
      <td <?php echo "bgcolor='".$lehentasuna->getKolorea()."'"; ?>><?php echo $lehentasuna->getKolorea() ?></td>


    </tr>
    <?php endforeach; ?>
<!--
    <tr><td colspan=3 align=right><a href="<?php //echo url_for('lehentasuna/new') ?>">Berria</a></td></tr>
-->
  </tbody>
</table>

