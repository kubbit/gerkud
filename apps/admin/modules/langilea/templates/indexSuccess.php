<br><br>
<center>
<table width=90% class="zerrenda">
  <thead>
	<tr><th><h1>Erabiltzaileak</h1></th></tr>
  </thead>
  <tbody>
    <tr>
      <th class=ezker>Id</th>
      <th class=ezker>Username</th>
      <th class=ezker>Izen/Abizenak</th>
      <th class=ezker>Email helbidea</th>
      <th class=ezker>Aktibo dago?</th>
      <th class=ezker>Azkenekoz sartua</th>
    </tr>
    <?php foreach ($langileas as $langilea): ?>
    <tr>
      <td><a href="<?php echo url_for('langilea/edit?id='.$langilea->getId()) ?>"><?php echo $langilea->getId() ?></a></td>
      <td><?php echo $langilea->getUsername() ?></td>
      <td><?php echo $langilea->getFirstName()." ".$langilea->getLastName() ?></td>
      <td><?php echo $langilea->getEmailAddress() ?></td>
      <td><?php if ($langilea->getIsActive()) echo 'Bai'; else echo 'Ez'; ?></td>
      <td><?php echo $langilea->getLastLogin() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
        <tr><td colspan=5 align=right>
        </td><td align=right>
            <a class="boton" href="<?php echo url_for('langilea/new') ?>">Langilea Sortu</a>
        </td></tr>
  </tfoot>
</table>

