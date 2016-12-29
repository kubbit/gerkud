<?php use_javascripts_for_form($filter); ?>
<?php $configEremuak = sfConfig::get('app_gerkud_eremuak'); ?>

<?php if($filter->hasErrors() || $filter->hasGlobalErrors()): ?>
<ul id="erroreak">
	<?php foreach($filter->getGlobalErrors() as $name => $error): ?>
	<li><?php echo $name; ?>: <?php echo $error; ?></li>
	<?php endforeach; ?>

	<?php foreach($filter->getErrorSchema()->getErrors() as $name => $error): ?>
	<li title="<?php echo $name; ?>"><?php echo __($error); ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<form id="bilaketa" class="panela" action="<?php echo url_for('bilaketa/index'); ?>" method="post">
	<fieldset>
		<legend><?php echo __('Gertakarien bilaketa') ?></legend>
		<fieldset>
			<div id="id" class="field">
				<label for="gertakaria_filters_id"><?php echo __('Kodea') ?>:</label>
				<?php echo $filter['id']->render(array('autofocus' => 'autofocus', 'class' => 'motza')); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="librea" class="field">
				<label for="gertakaria_filters_librea"><?php echo __('Bilaketa testua') ?>:</label>
				<?php echo $filter['librea']->render(array('class' => 'luzea')); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="created_at_noiztik" class="field">
				<label for="gertakaria_filters_created_at_noiztik"><?php echo __('Irekiera data (noiztik)') ?>:</label>
				<?php echo $filter['created_at_noiztik']->render(); ?>
			</div>
			<div id="created_at_nora" class="field">
				<label for="gertakaria_filters_created_at_nora"><?php echo __('(nora)') ?>:</label>
				<?php echo $filter['created_at_nora']->render(); ?>
			</div>
			<div id="ixte_data_noiztik" class="field">
				<label for="gertakaria_filters_ixte_data_noiztik"><?php echo __('Ixte data (noiztik)') ?>:</label>
				<?php echo $filter['ixte_data_noiztik']->render(); ?>
			</div>
			<div id="ixte_data_nora" class="field">
				<label for="gertakaria_filters_ixte_data_nora"><?php echo __('(nora)') ?>:</label>
				<?php echo $filter['ixte_data_nora']->render(); ?>
			</div>
		</fieldset>
<?php if (in_array('mota', $configEremuak)): ?>
		<fieldset>
			<div id="mota_id" class="field">
				<label for="gertakaria_filters_mota_id"><?php echo __('Mota') ?>:</label>
				<?php echo $filter['mota_id']->render(); ?>
			</div>
	<?php if (in_array('azpimota', $configEremuak)) : ?>
			<div id="azpimota_id" class="field">
				<label for="gertakaria_filters_azpimota_id"><?php echo __('Azpimota') ?>:</label>
				<?php echo $filter['azpimota_id']->render(); ?>
			</div>
	<?php endif; ?>
		</fieldset>
<?php endif; ?>
<?php if (in_array('saila', $configEremuak)): ?>
		<fieldset>
			<div id="saila_id" class="field">
				<label for="gertakaria_filters_saila_id"><?php echo __('Saila') ?>:</label>
				<?php echo $filter['saila_id']->render(); ?>
			</div>
		</fieldset>
<?php endif; ?>
<?php if (in_array('klasea', $configEremuak)): ?>
		<fieldset>
			<div id="klasea_id" class="field">
				<label for="gertakaria_filters_klasea_id"><?php echo __('Klasea') ?>:</label>
				<?php echo $filter['klasea_id']->render(); ?>
			</div>
		</fieldset>
<?php endif; ?>
<?php if(count(array_intersect($configEremuak, array('barrutia', 'auzoa', 'kalea', 'kale_zbkia'))) > 0): ?>
		<fieldset class="azpiSailkapena">
			<label class="title"><?php echo __('Helbidea') ?>:</label>
	<?php if (in_array('barrutia', $configEremuak)): ?>
			<div id="barrutia_id" class="field">
				<label for="gertakaria_filters_barrutia_id"><?php echo __('Barrutia') ?>:</label>
				<?php echo $filter['barrutia_id']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('auzoa', $configEremuak)): ?>
			<div id="auzoa_id" class="field">
				<label for="gertakaria_filters_auzoa_id"><?php echo __('Auzoa') ?>:</label>
				<?php echo $filter['auzoa_id']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('kalea', $configEremuak)): ?>
			<div id="kalea_id" class="field">
				<label for="gertakaria_filters_kalea_id"><?php echo __('Kalea') ?>:</label>
				<?php echo $filter['kalea_id']->render(); ?>
			</div>
		<?php if (in_array('kale_zbkia', $configEremuak)): ?>
			<div id="kale_zbkia" class="field">
				<label for="gertakaria_filters_kale_zbkia"><?php echo __('Zbkia') ?>:</label>
				<?php echo $filter['kale_zbkia']->render(array('class' => 'motza')); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php if (in_array('eraikina', $configEremuak)): ?>
			<div id="eraikina_id" class="field">
				<label for="gertakaria_filters_eraikina_id"><?php echo __('Eraikina') ?>:</label>
				<?php echo $filter['eraikina_id']->render(); ?>
			</div>
	<?php endif; ?>
		</fieldset>
<?php endif; ?>
<?php if (in_array('jatorrizkosaila', $configEremuak) || in_array('espedientea', $configEremuak)): ?>
		<fieldset>
<?php if (in_array('jatorrizkosaila', $configEremuak)): ?>
			<div id="jatorrizkoSaila_id" class="field">
				<label for="gertakaria_filters_jatorrizkoSaila_id"><?php echo __('Jatorrizko Saila') ?>:</label>
				<?php echo $filter['jatorrizkoSaila_id']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('espedientea', $configEremuak)): ?>
			<div id="espedientea" class="field">
				<label for="gertakaria_filters_espedientea"><?php echo __('Espedientea') ?>:</label>
				<?php echo $filter['espedientea']->render(); ?>
			</div>
<?php endif; ?>
		</fieldset>
<?php endif; ?>
		<fieldset>
			<div id="egoera_id" class="field">
				<label for="gertakaria_filters_egoera_id"><?php echo __('Egoera') ?>:</label>
				<?php echo $filter['egoera_id']->render(); ?>
			</div>
		</fieldset>
		<?php $filter->setDefault('mapa', 0); ?>
	</fieldset>
	<div><input name="filter" type="submit" class="botoia" value="<?php echo __('Bilatu') ?>" /></div>
</form>
