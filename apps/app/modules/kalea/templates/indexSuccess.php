<table class="taula">
	<caption><?php echo __('Kaleak') ?></caption>
	<thead>
		<tr>
			<th><?php echo __('Id') ?></th>
			<th><?php echo __('Barrutia') ?></th>
			<th><?php echo __('Izena') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($kaleas as $kalea): ?>
		<tr>
			<td><?php echo $kalea->getId() ?></td>
			<td><?php echo $kalea->getBarrutia() ?></td>
			<td><?php echo $kalea->getIzena() ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
