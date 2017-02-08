<?php use_helper('Javascript', 'GMap'); ?>
<?php use_helper('Pagination'); ?>

<!-- ZERRENDA -->
<div>
	<?php echo pager_navigation($pager, 'gertakaria/index') ?>
</div>
<table class="gertakariak">
	<caption>
		<?php echo __('%gertakariak% gertakari topatu dira', array('%gertakariak%' => count($pager->getCountQuery()))) ?>:
	</caption>
	<thead>
		<tr>
<?php foreach ($zutabeak as $item): ?>
			<th class="<?php echo $item->klasea ?>"><?php echo $item->izena ?></th>
<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
<?php foreach ($datuak as $eskaera): ?>
		<tr class="<?php echo sprintf('egoera%d', $eskaera->egoeraId); ?>">
	<?php foreach ($eskaera->datuak as $klabea => $datua): ?>
		<?php if (!$datua): ?>
			<td title="<?php echo $zutabeak[$klabea]->izena; ?>"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId); ?>">&nbsp;</a></td>
		<?php elseif ($klabea === 'lehentasuna'): ?>
			<td class="lehentasuna" title="<?php echo $zutabeak[$klabea]->izena; ?>"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId); ?>"><?php echo $datua; ?></a></td>
		<?php elseif ($klabea === 'created_at'): ?>
			<td title="<?php echo $zutabeak[$klabea]->izena; ?>"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId); ?>"><?php echo date('Y-m-d',strtotime($datua)); ?></a></td>
		<?php else: ?>
			<td title="<?php echo $zutabeak[$klabea]->izena; ?>"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId); ?>"><?php echo str_replace('###', '<br />', $datua); ?></a></td>
		<?php endif; ?>
	<?php endforeach; ?>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<div>
	<?php echo pager_navigation($pager, 'gertakaria/index') ?>
</div>

<?php if (sfConfig::get('gerkud_mapa_aktibatuta')): ?>
	<?php slot('mapa'); ?>
		<li id="mapa" onclick="<?php echo sprintf('window.open(\'%s\', \'%s\', \'%s\')', url_for('gertakaria/mapa?page=' . $pager->getPage()), 'Planoa', 'width=805,height=600'); ?>"><a><?php echo image_tag('map.png', array('alt' => __('Mapa'))); ?><?php echo __('Mapa'); ?></a></li>
	<?php end_slot(); ?>
<?php endif; ?>
