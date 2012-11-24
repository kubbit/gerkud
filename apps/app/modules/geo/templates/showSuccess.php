<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $geo->getId() ?></td>
    </tr>
    <tr>
      <th>Gertakaria:</th>
      <td><?php echo $geo->getGertakariaId() ?></td>
    </tr>
    <tr>
      <th>Longitudea:</th>
      <td><?php echo $geo->getLongitudea() ?></td>
    </tr>
    <tr>
      <th>Latitudea:</th>
      <td><?php echo $geo->getLatitudea() ?></td>
    </tr>
    <tr>
      <th>Testua:</th>
      <td><?php echo $geo->getTestua() ?></td>
    </tr>
    <tr>
      <th>Geometria:</th>
      <td><?php echo $geo->getGeometriaId() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('geo/edit?id='.$geo->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('geo/index') ?>">List</a>
