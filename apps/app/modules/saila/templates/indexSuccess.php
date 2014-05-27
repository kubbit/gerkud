<table>
	<caption><?php echo __('Sailak') ?></caption>
	<thead>
		<tr>
			<th><?php echo __('Id') ?></th>
			<th><?php echo __('Izena') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($sailas as $saila): ?>
		<tr>
			<td><?php echo $saila->getId() ?></td>
			<td><?php echo $saila->getName() ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
