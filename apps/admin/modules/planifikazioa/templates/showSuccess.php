<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $planifikazioa->getId() ?></td>
    </tr>
    <tr>
      <th>Gertakaria:</th>
      <td><?php echo $planifikazioa->getGertakariaId() ?></td>
    </tr>
    <tr>
      <th>Langile:</th>
      <td><?php echo $planifikazioa->getLangileId() ?></td>
    </tr>
    <tr>
      <th>Hasiera data:</th>
      <td><?php echo $planifikazioa->getHasieraData() ?></td>
    </tr>
    <tr>
      <th>Hasiera ordua noiztik:</th>
      <td><?php echo $planifikazioa->getHasieraOrduaNoiztik() ?></td>
    </tr>
    <tr>
      <th>Hasiera ordua noizarte:</th>
      <td><?php echo $planifikazioa->getHasieraOrduaNoizarte() ?></td>
    </tr>
    <tr>
      <th>Amaiera data:</th>
      <td><?php echo $planifikazioa->getAmaieraData() ?></td>
    </tr>
    <tr>
      <th>Amaiera ordua noiztik:</th>
      <td><?php echo $planifikazioa->getAmaieraOrduaNoiztik() ?></td>
    </tr>
    <tr>
      <th>Amaiera ordua noizarte:</th>
      <td><?php echo $planifikazioa->getAmaieraOrduaNoizarte() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('planifikazioa/edit?id='.$planifikazioa->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('planifikazioa/index') ?>">List</a>
