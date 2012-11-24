<center>
<table class="zerrenda">
  <thead>
    <tr>
      <th><h1><?php echo __('Sailak')?></h1></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th class=ezker><?php echo __('Id')?></th>
      <th class=ezker><?php echo __('Izena')?></th>
    </tr>
    <?php foreach ($sailas as $saila): ?>
    <tr>
      <td><?php echo $saila->getId() ?></td>
      <td><?php echo $saila->getName() ?></td>
<!--
      <td>
<?php //echo link_to('Ezabatu', 'saila/delete?id='.$saila->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>
      </td>
-->
    </tr>
    <?php endforeach; ?>
<!--
    <tr><td colspan=3 align=right><a href="<?php //echo url_for('saila/new') ?>">Berria</a></td></tr>
-->
  </tbody>
</table>
</center>
