<table class="eskaerak">
	<caption><?php echo __('%eskaerak% eskaera topatu dira', array('%eskaerak%' => count($eskaerak))) ?>:</caption>
	<thead>
		<tr>
<?php foreach ($zutabeak as $key => $item): ?>
			<th title="<?php echo $key; ?>" class="<?php echo $item->klasea ?>"><?php echo $item->izena ?></th>
<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
<?php foreach ($datuak as $eskaera): ?>
		<tr>
	<?php foreach ($eskaera->datuak as $klabea => $datua): ?>
		<?php if (!$datua) : ?>
			<td title="<?php echo $zutabeak[$klabea]->izena; ?>"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>">&nbsp;</a></td>
		<?php elseif ($klabea === 'lehentasuna') : ?>
			<td class="lehentasuna" title="<?php echo $zutabeak[$klabea]->izena; ?>"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>"><?php echo $datua ?></a></td>
		<?php else : ?>
			<td title="<?php echo $zutabeak[$klabea]->izena; ?>"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>"><?php echo $datua ?></a></td>
		<?php endif; ?>
	<?php endforeach; ?>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
