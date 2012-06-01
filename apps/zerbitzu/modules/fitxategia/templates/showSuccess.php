<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $fitxategia->getId() ?></td>
    </tr>
    <tr>
      <th>Gertakaria:</th>
      <td><?php echo $fitxategia->getGertakariaId() ?></td>
    </tr>
    <tr>
      <th>Langilea:</th>
      <td><?php echo $fitxategia->getLangileaId() ?></td>
    </tr>
    <tr>
      <th>Fitxategia:</th>
      <td><?php echo $fitxategia->getFitxategia() ?></td>
    </tr>
    <tr>
      <th>Deskribapena:</th>
      <td><?php echo $fitxategia->getDeskribapena() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $fitxategia->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $fitxategia->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('fitxategia/edit?id='.$fitxategia->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('fitxategia/index') ?>">List</a>
