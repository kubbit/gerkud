<h1>Geos List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Gertakaria</th>
      <th>Longitudea</th>
      <th>Latitudea</th>
      <th>Testua</th>
      <th>Geometria</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($geos as $geo): ?>
    <tr>
      <td><a href="<?php echo url_for('geo/show?id='.$geo->getId()) ?>"><?php echo $geo->getId() ?></a></td>
      <td><?php echo $geo->getGertakariaId() ?></td>
      <td><?php echo $geo->getLongitudea() ?></td>
      <td><?php echo $geo->getLatitudea() ?></td>
      <td><?php echo $geo->getTestua() ?></td>
      <td><?php echo $geo->getGeometriaId() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('geo/new') ?>">New</a>
