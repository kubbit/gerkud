<h1>Ekintzak</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Mota</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ekintzas as $ekintza): ?>
    <tr>
      <td><?php echo $ekintza->getId() ?></td>
      <td><?php echo $ekintza->getMota() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!--  <a href="<?php //echo url_for('ekintza/new') ?>">New</a> -->
