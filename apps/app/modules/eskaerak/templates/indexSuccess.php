<table class="eskaerak taula gertakariZerrenda">
	<caption class="txikia"><?php echo __('%eskaerak% eskaera topatu dira', array('%eskaerak%' => count($eskaerak))) ?>:</caption>
	<thead>
		<tr>
<?php foreach ($zutabeak as $item): ?>
			<th class="<?php echo $item->klasea ?>"><?php echo $item->izena ?></th>
<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
<?php foreach ($datuak as $eskaera): ?>
		<tr>
	<?php foreach ($eskaera->datuak as $klabea => $datua): ?>
		<?php if (!$datua) : ?>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>">&nbsp;</a></td>
		<?php elseif ($klabea === 'lehentasuna') : ?>
			<td class="lehentasuna"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>"><?php echo $datua ?></a></td>
		<?php else : ?>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>"><?php echo $datua ?></a></td>
		<?php endif; ?>
	<?php endforeach; ?>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
