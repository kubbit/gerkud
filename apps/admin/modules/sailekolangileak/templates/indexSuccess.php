<h1>Saileko langileak</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Saila</th>
      <th>Langilea</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($sailekolangileaks as $sailekolangileak): ?>
    <tr>
      <td><?php echo $sailekolangileak->getId() ?></td>
      <td><?php echo $sailekolangileak->getSaila() ?></td>
      <td><?php echo $sailekolangileak->getLangilea() ?></td>
      <td><?php echo link_to('Ezabatu', 'sailekolangileak/delete?id='.$sailekolangileak->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>
    </tr>
    <?php endforeach; ?>
    <tr><td colspan=4 align=right><a href="<?php echo url_for('sailekolangileak/new') ?>">Berria</a></td></tr>

  </tbody>
</table>

