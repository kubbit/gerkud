<h1>Esleipenas List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Gertakaria</th>
      <th>Langilea</th>
      <th>Testua</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($esleipenas as $esleipena): ?>
    <tr>
      <td><a href="<?php echo url_for('esleipena/show?id='.$esleipena->getId()) ?>"><?php echo $esleipena->getId() ?></a></td>
      <td><?php echo $esleipena->getGertakariaId() ?></td>
      <td><?php echo $esleipena->getLangileaId() ?></td>
      <td><?php echo $esleipena->getTestua() ?></td>
      <td><?php echo $esleipena->getCreatedAt() ?></td>
      <td><?php echo $esleipena->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('esleipena/new') ?>">New</a>
