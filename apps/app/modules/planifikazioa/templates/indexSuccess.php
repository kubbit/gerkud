<h1>Planifikazioas List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Gertakaria</th>
      <th>Langile</th>
      <th>Hasiera data</th>
      <th>Hasiera ordua noiztik</th>
      <th>Hasiera ordua noizarte</th>
      <th>Amaiera data</th>
      <th>Amaiera ordua noiztik</th>
      <th>Amaiera ordua noizarte</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($planifikazioas as $planifikazioa): ?>
    <tr>
      <td><a href="<?php echo url_for('planifikazioa/show?id='.$planifikazioa->getId()) ?>"><?php echo $planifikazioa->getId() ?></a></td>
      <td><?php echo $planifikazioa->getGertakariaId() ?></td>
      <td><?php echo $planifikazioa->getLangileId() ?></td>
      <td><?php echo $planifikazioa->getHasieraData() ?></td>
      <td><?php echo $planifikazioa->getHasieraOrduaNoiztik() ?></td>
      <td><?php echo $planifikazioa->getHasieraOrduaNoizarte() ?></td>
      <td><?php echo $planifikazioa->getAmaieraData() ?></td>
      <td><?php echo $planifikazioa->getAmaieraOrduaNoiztik() ?></td>
      <td><?php echo $planifikazioa->getAmaieraOrduaNoizarte() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('planifikazioa/new') ?>">New</a>
