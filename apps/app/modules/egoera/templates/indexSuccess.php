<center>
<table class="zerrenda">
  <thead>
    <tr>
      <th><h1><?php echo __('Egoerak')?></h1></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th class=ezker><?php echo __('Id')?></th>
      <th class=ezker><?php echo __('Izena')?></th>
      <th class=ezker><?php echo __('Kolorea')?></th>
<!--      <th></th> -->
    </tr>
    <?php foreach ($egoeras as $egoera): ?>
    <tr>
      <td><?php echo $egoera->getId() ?></td>
      <td><?php echo $egoera->getIzena() ?></td>
      <td bgcolor=<?php echo $egoera->getKolorea() ?> ><?php echo $egoera->getKolorea() ?></td>
    </tr>
    <?php endforeach; ?>

<!--
    <tr><td colspan=4 align=right>
          <a href="<?php //echo url_for('egoera/new') ?>">Berria</a>
    </td></tr>
-->
  </tbody>
</table>
</center>
