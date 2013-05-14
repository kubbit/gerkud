<table class="taula gertakariZerrenda">
	<caption class="txikia"><?php echo __('%eskaerak% eskaera topatu dira', array('%eskaerak%' => count($eskaerak))) ?>:</caption>
	<thead>
		<tr>
			<th></th>
			<th><?php echo __('Id') ?></th>
			<th style="width: 5em;"><?php echo __('Irekiera') ?></th>
			<th><?php echo __('Mota') ?></th>
			<th style="width: 4em;"><?php echo __('Auzoa') ?></th>
			<th style="min-width: 8em;"><?php echo sprintf('%s / %s', __('Kalea'), __('Eraikina')) ?></th>
			<th><?php echo __('Laburpena') ?></th>
			<!--th><?php echo __('Egoera') ?></th-->
			<th style="min-width: 6em;"><?php echo __('Abisua nork') ?></th>
			<!--th>Aldatuta</th-->
		</tr>
	</thead>
	<tbody>
<?php foreach ($eskaerak as $eskaera): ?>
		<tr>
			<td class="lehentasuna"><?php for ($i = 0; $i < $eskaera->getLehentasunaId() - 1; $i++) echo '!'; ?></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->getId()) ?>"><?php echo $eskaera->getId() ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->getId()) ?>"><?php echo date(sfConfig::get('app_data_formatoa'), strtotime($eskaera->getCreatedAt())) ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->getId()) ?>"><?php echo $eskaera->getMota() ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->getId()) ?>"><?php if ($eskaera->getBarrutiaId()) echo $eskaera->getBarrutia() ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->getId()) ?>"><?php if ($eskaera->getEraikinaId()) echo $eskaera->getEraikina(); else if ($eskaera->getKaleaId()) echo sprintf('%s, %s', $eskaera->getKalea(), $eskaera->getKaleZbkia()) ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->getId()) ?>"><?php echo $eskaera->getLaburpena() ?></a></td>
			<?php //$kol=$eskaera->getEgoeraKolorea(); ?>
			<!--td <?php //echo "bgcolor='".$kol[0]->getKolorea()."'";  ?>><a href="<?php //echo url_for('gertakaria/show?id='.$eskaera->getId())  ?>"-->
			<?php //echo $eskaera->getEgoera() ?><!--/a></td-->
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->getId()) ?>"><?php echo $eskaera->getAbisuaNork() ?></a></td>
			<!--td><a href="<?php //echo url_for('gertakaria/show?id='.$eskaera->getId())  ?>"><?php //echo $eskaera->getUpdatedAt()  ?></a></td-->
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
