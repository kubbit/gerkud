<?php use_helper('Javascript', 'GMap') ?>
<?php use_helper('Pagination'); ?>
<?php use_javascripts_for_form($filter) ?>
<?php $configEremuak = sfConfig::get('app_gerkud_eremuak')?>

<?php if ($bilaketa == "true" || $erroreak): ?>
<form id="bilaketa" action="<?php echo url_for('gertakaria/index'); ?>" method="post" class="bilaketa_form">
	<h2><?php echo __('Gertakarien bilaketa') ?></h2>
	<img id="ezkutatuBilaketa" src="/images/Ezabatu.png" class="ezkutatu" alt="Ezkutatu" />

	<div class="hilarak">
		<div>
			<label><?php echo __('Kodea') ?>:</label>
			<?php echo $filter['id']->render(array('autofocus' => 'autofocus', 'size' => 5)); ?>
		</div>
		<div>
			<label><?php echo __('Sartu bilatu nahi duzun testua') ?>:</label>
			<?php echo $filter['librea']->render(array('size' => 75)); ?>
		</div>
	</div>
	<div id="aurreratua" class="hilarak" style="<?php echo ($erroreak) ? '' : 'display: none' ?>">
		<fieldset>
			<div>
				<label><?php echo __('Irekiera data (noiztik-nora)') ?>:</label>
				<?php echo $filter['created_at_noiztik']->render(); ?>
				<span class="errorea"><?php echo __($filter['created_at_noiztik']->getError()); ?></span>
				<?php echo $filter['created_at_nora']->render(); ?>
				<span class="errorea"><?php echo __($filter['created_at_nora']->getError()); ?></span>
			</div>
			<div>
				<label><?php echo __('Ixte data (noiztik-nora)') ?>:</label>
				<?php echo $filter['ixte_data_noiztik']->render(); ?>
				<span class="errorea"><?php echo __($filter['ixte_data_noiztik']->getError()); ?></span>
				<?php echo $filter['ixte_data_nora']->render(); ?>
				<span class="errorea"><?php echo __($filter['ixte_data_nora']->getError()); ?></span>
			</div>
		</fieldset>
<?php if (in_array('klasea', $configEremuak)) : ?>
		<div>
			<label><?php echo __('Klasea') ?>:</label>
			<?php echo $filter['klasea_id']->render(); ?>
		</div>
<?php endif; ?>
		<div>
			<label><?php echo __('Egoera') ?>:</label>
			<?php echo $filter['egoera_id']->render(); ?>
		</div>
<?php if (in_array('saila', $configEremuak)) : ?>
		<div>
			<label><?php echo __('Saila') ?>:</label>
			<?php echo $filter['saila_id']->render(); ?>
		</div>
<?php endif; ?>
<?php if (in_array('mota', $configEremuak)) : ?>
		<div>
			<label><?php echo __('Mota/Azpimota') ?>:</label>
			<?php echo $filter['mota_id']->render(); ?>
	<?php if (in_array('azpimota', $configEremuak)) : ?>
			<?php echo $filter['azpimota_id']->render(); ?>
	<?php endif; ?>
		</div>
<?php endif; ?>
<?php if(count(array_intersect($configEremuak, ['barrutia', 'auzoa', 'kalea', 'kale_zbkia'])) > 0): ?>
		<div>
			<label><?php echo __('Helbidea') ?>:</label>
			<?php echo (in_array('barrutia', $configEremuak)) ? $filter['barrutia_id']->render() : ''; ?>
			<?php echo (in_array('auzoa', $configEremuak)) ? $filter['auzoa_id']->render() : ''; ?>
			<?php echo (in_array('kalea', $configEremuak)) ? $filter['kalea_id']->render() : ''; ?>
			<?php echo (in_array('kale_zbkia', $configEremuak)) ? $filter['kale_zbkia']->render(array('size' => 5)) : ''; ?>
		</div>
<?php endif; ?>
<?php if (in_array('eraikina', $configEremuak)) : ?>
		<div>
			<label><?php echo __('Eraikina') ?>:</label>
			<?php echo $filter['eraikina_id']->render(); ?>
		</div>
<?php endif; ?>
<?php if (in_array('jatorrizkosaila', $configEremuak)) : ?>
		<div>
			<label><?php echo __('Jatorrizko Saila') ?>:</label>
			<?php echo $filter['jatorrizkoSaila_id']->render(); ?>
		</div>
<?php endif; ?>
		<?php $filter->setDefault('mapa', 0); ?>
	</div>
	<div id="ie_fix"><input name="filter" type="submit" value="<?php echo __('Bilatu') ?>" /></div>
	<h4 id="arrunta" class="aldatuAukeraAurreratuak" onclick="erakutsiEzkutatuAurreratua();"><?php echo __('Bilaketa aurreratua') ?>...</h4>
	<h4 id="aurreratuaB" class="aldatuAukeraAurreratuak" style="display: none" onclick="erakutsiEzkutatuAurreratua();"><?php echo __('Bilaketa arrunta') ?>...</h4>
</form>
<?php endif; ?>

<!-- ZERRENDA -->
<div class="orriak">
	<?php echo pager_navigation($pager, 'gertakaria/index') ?>
</div>
<table class="gertakariak taula gertakariZerrenda">
	<caption class="txikia">
		<?php echo __('%gertakariak% gertakari topatu dira', array('%gertakariak%' => count($pager->getCountQuery()))) ?>:
	</caption>
	<thead class="zutabeak">
		<tr>
<?php foreach ($zutabeak as $item): ?>
			<th class="<?php echo $item->klasea ?>"><?php echo $item->izena ?></th>
<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
<?php foreach ($datuak as $eskaera): ?>
		<tr class="<?php echo sprintf('lehen%d', $eskaera->lehentasuna); ?>">
	<?php foreach ($eskaera->datuak as $klabea => $datua): ?>
		<?php if (!$datua) : ?>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>">&nbsp;</a></td>
		<?php elseif ($klabea === 'lehentasuna') : ?>
			<td class="lehentasuna"><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>"><?php echo $datua ?></a></td>
		<?php elseif ($klabea === 'egoera') : ?>
			<td style='background-color:<?php  echo $eskaera->egoeraKolorea ?>'><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>"><?php echo $datua ?></a></td>
		<?php else : ?>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $eskaera->estekaId) ?>"><?php echo $datua ?></a></td>
		<?php endif; ?>
	<?php endforeach; ?>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<div class="orriak">
	<?php echo pager_navigation($pager, 'gertakaria/index') ?>
</div>


<img id="mapa_ikonoa" class="mapa" src="<?php echo sprintf('/images/Planoa_%s.png', $sf_user->getCulture()); ?>" alt="Planoa"
 onclick="<?php echo sprintf('window.open(\'%s\', \'%s\', \'%s\')', url_for('gertakaria/mapa?page=' . $pager->getPage()), 'Planoa', 'width=800,height=600,scroll=yes'); ?>" />
