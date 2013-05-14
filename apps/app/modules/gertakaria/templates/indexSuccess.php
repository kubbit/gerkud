<?php use_helper('Javascript', 'GMap') ?>
<?php use_helper('Pagination'); ?>

<?php if ($bilaketa == "true"): ?>
<form id="bilaketa" action="<?php echo url_for('gertakaria/index'); ?>" method="post" class="bilaketa_form">
	<h2><?php echo __('Gertakarien bilaketa') ?></h2>
	<img id="ezkutatuBilaketa" src="/images/Ezabatu.png" class="ezkutatu" alt="Ezkutatu" />

	<div class="hilarak">
		<div>
			<label><?php echo __('Kodea') ?>:</label>
			<?php echo $filter['id']->render(array('size' => 5)); ?>
		</div>
		<div>
			<label><?php echo __('Sartu bilatu nahi duzun testua') ?>:</label>
			<?php echo $filter['librea']->render(array('size' => 75)); ?>
		</div>
	</div>
	<div id="aurreratua" class="hilarak" style="display: none">
		<fieldset>
			<div>
				<label><?php echo __('Irekiera data (noiztik-nora)') ?>:</label>
				<div><?php echo $filter['created_at_noiztik']->render(); ?></div>
				<div><?php echo $filter['created_at_nora']->render(); ?></div>
			</div>
			<div>
				<label><?php echo __('Ixte data (noiztik-nora)') ?>:</label>
				<div><?php echo $filter['ixte_data_noiztik']->render(); ?></div>
				<div><?php echo $filter['ixte_data_nora']->render(); ?></div>
			</div>
		</fieldset>
		<div>
			<label><?php echo __('Klasea') ?>:</label>
			<?php echo $filter['klasea_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Egoera') ?>:</label>
			<?php echo $filter['egoera_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Saila') ?>:</label>
			<?php echo $filter['saila_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Mota/Azpimota') ?>:</label>
			<?php echo $filter['mota_id']->render(); ?><?php echo $filter['azpimota_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Helbidea') ?>:</label>
			<?php $filter->setDefault('barrutia_id', 'Donibane'); ?>
			<?php echo $filter['barrutia_id']->render(); ?>
			<?php echo $filter['kalea_id']->render(); ?>
			<?php echo $filter['kale_zbkia']->render(array('size' => 5)); ?>
		</div>
		<div>
			<label><?php echo __('Eraikina') ?>:</label>
			<?php echo $filter['eraikina_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Jatorrizko Saila') ?>:</label>
			<?php echo $filter['jatorrizkoSaila_id']->render(); ?>
		</div>
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
<table class="taula gertakariZerrenda">
	<caption class="txikia">
		<?php echo __('%gertakariak% gertakari topatu dira', array('%gertakariak%' => count($pager->getCountQuery()))) ?>:
	</caption>
	<thead>
		<tr>
			<th></th>
			<th><?php echo __('Id') ?></th>
			<th style="width: 6em;"><?php echo __('Irekiera') ?></th>
			<th><?php echo __('Mota') ?></th>
			<th style="width: 5em;"><?php echo __('Auzoa') ?></th>
			<th style="min-width: 8em;"><?php echo sprintf('%s / %s', __('Kalea'), __('Eraikina')) ?></th>
			<th><?php echo __('Laburpena') ?></th>
			<th style="width: 6em;"><?php echo __('Egoera') ?></th>
			<!--th>Langilea</th-->
			<th style="min-width: 6em;"><?php echo __('Abisua nork') ?></th>
			<th style="width: 6em;"><?php echo __('Aldatuta') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($pager->getResults() as $gertakaria): ?>
		<tr class="<?php echo sprintf('lehen%d', $gertakaria->getLehentasunaId()); ?>">
			<td class="lehentasuna"><?php for ($i = 0; $i < $gertakaria->getLehentasunaId() - 1; $i++) echo '!'; ?></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php echo $gertakaria->getId() ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php echo date(sfConfig::get('app_data_formatoa'), strtotime($gertakaria->getCreatedAt())) ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php echo $gertakaria->getMota() ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php if ($gertakaria->getBarrutiaId()) echo $gertakaria->getBarrutia() ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php if ($gertakaria->getEraikinaId()) echo $gertakaria->getEraikina(); else if ($gertakaria->getKaleaId()) echo sprintf('%s, %s', $gertakaria->getKalea(), $gertakaria->getKaleZbkia()); ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php echo $gertakaria->getLaburpena() ?></a></td>
			<?php $kol = $gertakaria->getEgoeraKolorea(); ?>
			<td <?php echo "bgcolor='" . $kol[0]->getKolorea() . "'"; ?>><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>">
			<?php echo $gertakaria->getEgoera() ?></a></td>
			<!--td><?php //if ($gertakaria->getLangileaId()) {echo $gertakaria->getLangilea();}  ?></td-->
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php echo $gertakaria->getAbisuaNork() ?></a></td>
			<td><a href="<?php echo url_for('gertakaria/show?id=' . $gertakaria->getId()) ?>"><?php echo date(sfConfig::get('app_data_formatoa'), strtotime($gertakaria->getUpdatedAt())) ?></a></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<div class="orriak">
	<?php echo pager_navigation($pager, 'gertakaria/index') ?>
</div>


<!-- MAPA orri berri batean irekitzeko. Helbidea begiratu behar da! -->
<a href="#" onclick="<?php echo sprintf('window.open(\'%s\', \'%s\', \'%s\')', url_for('gertakaria/mapa?page=' . $pager->getPage()), 'Planoa', 'width=800,height=600,scroll=yes'); ?>">
	<img class="mapa" src="<?php echo sprintf('/images/Planoa_%s.png', $sf_user->getCulture()); ?>" alt="Planoa" />
</a>
