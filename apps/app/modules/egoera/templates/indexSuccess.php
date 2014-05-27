<table>
	<caption><?php echo __('Egoerak') ?></caption>
	<thead>
		<tr>
			<th><?php echo __('Id') ?></th>
			<th><?php echo __('Izena') ?></th>
			<th><?php echo __('Kolorea') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($egoeras as $egoera): ?>
		<tr>
			<td><?php echo $egoera->getId() ?></td>
			<td><?php echo $egoera->getIzena() ?></td>
			<td style="background-color: <?php echo $egoera->getKolorea() ?>"><?php echo $egoera->getKolorea() ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
