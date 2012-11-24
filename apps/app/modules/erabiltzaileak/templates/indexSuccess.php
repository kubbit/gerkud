<center>
<table width=90% class="zerrenda">
  <thead>
	<tr><th><h1><?php echo __('Erabiltzaileak')?></h1></th></tr>
  </thead>
  <tbody>
    <tr>
      <th class=ezker><?php echo __('Id')?></th>
      <th class=ezker><?php echo __('Username')?></th>
      <th class=ezker><?php echo __('Izen/Abizenak')?></th>
      <th class=ezker><?php echo __('Email helbidea')?></th>
      <th class=ezker><?php echo __('Aktibo dago?')?></th>
      <th class=ezker><?php echo __('Azkenekoz sartua')?></th>
    </tr>
    <?php foreach ($erabiltzaileak as $erabiltzailea): ?>
    <tr>
      <td><a href="<?php echo url_for('erabiltzaileak/edit?id='.$erabiltzailea->getId()) ?>"><?php echo $erabiltzailea->getId() ?></a></td>
      <td><?php echo $erabiltzailea->getUsername() ?></td>
      <td><?php echo $erabiltzailea->getFirstName()." ".$erabiltzailea->getLastName() ?></td>
      <td><?php echo $erabiltzailea->getEmailAddress() ?></td>
      <td><?php if ($erabiltzailea->getIsActive()) echo __('Bai'); else echo __('Ez'); ?></td>
      <td><?php echo $erabiltzailea->getLastLogin() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <!--tfoot>
        <tr><td colspan=5 align=right>
        </td><td align=right>
            <a class="boton" href="<?php //echo url_for('erabiltzaileak/new') ?>"><?php //echo __('Erabiltzailea Sortu')?></a>
        </td></tr>
  </tfoot-->
</table>

