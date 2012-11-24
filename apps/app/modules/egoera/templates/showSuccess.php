<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $egoera->getId() ?></td>
    </tr>
    <tr>
      <th>Izena:</th>
      <td><?php echo $egoera->getIzena() ?></td>
    </tr>
    <tr>
      <th>Kolorea:</th>
      <td><?php echo $egoera->getKolorea() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('egoera/edit?id='.$egoera->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('egoera/index') ?>">List</a>
