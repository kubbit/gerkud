<h1>Fitxategias List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Gertakaria</th>
      <th>Langilea</th>
      <th>Fitxategia</th>
      <th>Deskribapena</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($fitxategias as $fitxategia): ?>
    <tr>
      <td><a href="<?php echo url_for('fitxategia/show?id='.$fitxategia->getId()) ?>"><?php echo $fitxategia->getId() ?></a></td>
      <td><?php echo $fitxategia->getGertakariaId() ?></td>
      <td><?php echo $fitxategia->getLangileaId() ?></td>
      <td><?php echo $fitxategia->getFitxategia() ?></td>
      <td><?php echo $fitxategia->getDeskribapena() ?></td>
      <td><?php echo $fitxategia->getCreatedAt() ?></td>
      <td><?php echo $fitxategia->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('fitxategia/new') ?>">New</a>
