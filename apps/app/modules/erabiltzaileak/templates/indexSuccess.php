<table class="taula">
	<caption><?php echo __('Erabiltzaileak')?></caption>
	<thead>
		<tr>
			<th><?php echo __('Id')?></th>
			<th><?php echo __('Username')?></th>
			<th><?php echo __('Izen/Abizenak')?></th>
			<th><?php echo __('Email helbidea')?></th>
			<th><?php echo __('Aktibo dago?')?></th>
			<th><?php echo __('Azkenekoz sartua')?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($erabiltzaileak as $erabiltzailea): ?>
		<tr>
			<td><a href="<?php echo url_for('erabiltzaileak/edit?id='.$erabiltzailea->getId()) ?>"><?php echo $erabiltzailea->getId() ?></a></td>
			<td><?php echo $erabiltzailea->getUsername() ?></td>
			<td><?php echo $erabiltzailea->getFirstName()." ".$erabiltzailea->getLastName() ?></td>
			<td><?php echo $erabiltzailea->getEmailAddress() ?></td>
			<td><?php if ($erabiltzailea->getIsActive()) echo __('Bai'); else echo __('Ez'); ?></td>
			<td><?php echo date(sfConfig::get('app_data_formatoa'), strtotime($erabiltzailea->getLastLogin())) ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
