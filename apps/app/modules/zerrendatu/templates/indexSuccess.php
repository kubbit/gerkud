<?php use_javascripts_for_form($zerrendatuaForm) ?>
<?php $configEremuak = sfConfig::get('gerkud_eremuak_gaituak'); ?>

<?php if($zerrendatuaForm->hasErrors() || $zerrendatuaForm->hasGlobalErrors()): ?>
<ul id="erroreak">
	<?php foreach($zerrendatuaForm->getGlobalErrors() as $name => $error): ?>
	<li><?php echo $name; ?>: <?php echo $error; ?></li>
	<?php endforeach; ?>

	<?php foreach($zerrendatuaForm->getErrorSchema()->getErrors() as $name => $error): ?>
	<li title="<?php echo $name; ?>"><?php echo __($error); ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<form class="panela" action="<?php echo url_for('zerrendatu/index'); ?>" method="post" target="_blank">
	<fieldset>
		<fieldset class="azpiSailkapena">
			<label class="title"><?php echo __('Sailkapena'); ?></label>
			<div id="sailkapena" class="field">
				<label for="zerrendatu_sailkapena1">1.</label>
				<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena1]', 'autofocus' => 'autofocus')); ?>
			</div>
			<div class="field">
				<label for="zerrendatu_sailkapena2">2.</label>
				<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena2]')); ?>
			</div>
			<div class="field">
				<label for="zerrendatu_sailkapena3">3.</label>
				<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena3]')); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="irekiera_noiztik" class="field">
				<label for="zerrendatu_irekiera_noiztik"><?php echo __('Irekiera data (noiztik)'); ?></label>
				<?php echo $zerrendatuaForm['irekiera_noiztik']->render(); ?>
			</div>
			<div id="irekiera_nora" class="field">
				<label for="zerrendatu_irekiera_nora"><?php echo __('(nora)'); ?></label>
				<?php echo $zerrendatuaForm['irekiera_nora']->render(); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="ixte_noiztik" class="field">
				<label for="zerrendatu_ixte_noiztik"><?php echo __('Ixte data (noiztik)'); ?></label>
				<?php echo $zerrendatuaForm['ixte_noiztik']->render(); ?>
			</div>
			<div id="ixte_nora" class="field">
				<label for="zerrendatu_ixte_nora"><?php echo __('(nora)'); ?></label>
				<?php echo $zerrendatuaForm['ixte_nora']->render(); ?>
			</div>
		</fieldset>
		<fieldset>
<?php if (in_array('mota', $configEremuak)): ?>
			<div id="mota" class="field">
				<label for="zerrendatu_mota_id"><?php echo __('Mota'); ?></label>
				<?php echo $zerrendatuaForm['mota_id']->render(); ?>
			</div>
	<?php if (in_array('azpimota', $configEremuak)): ?>
			<div id="azpimota" class="field">
				<label for="zerrendatu_azpimota_id"><?php echo __('Azpimota'); ?></label>
				<?php echo $zerrendatuaForm['azpimota_id']->render(); ?>
			</div>
	<?php endif; ?>
<?php endif; ?>
<?php if (in_array('saila', $configEremuak)): ?>
			<div id="saila" class="field">
				<label for="zerrendatu_saila"><?php echo __('Saila'); ?></label>
				<?php echo $zerrendatuaForm['saila']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('klasea', $configEremuak)): ?>
			<div id="klasea" class="field">
				<label for="zerrendatu_klasea"><?php echo __('Klasea'); ?></label>
				<?php echo $zerrendatuaForm['klasea']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('arloa', $configEremuak)): ?>
			<div id="arloa" class="field">
				<label for="zerrendatu_arloa"><?php echo __('Arloa'); ?></label>
				<?php echo $zerrendatuaForm['arloa']->render(); ?>
			</div>
<?php endif; ?>
		</fieldset>
<?php if (count(array_intersect($configEremuak, array('barrutia', 'auzoa', 'kalea', 'eraikina'))) > 0): ?>
		<fieldset class="azpiSailkapena">
			<label class="title"><?php echo __('Helbidea'); ?></label>
	<?php if (in_array('barrutia', $configEremuak)): ?>
			<div id="barrutia" class="field">
				<label for="zerrendatu_barrutia"><?php echo __('Barrutia'); ?></label>
				<?php echo $zerrendatuaForm['barrutia']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('auzoa', $configEremuak)): ?>
			<div id="auzoa" class="field">
				<label for="zerrendatu_auzoa"><?php echo __('Auzoa'); ?></label>
				<?php echo $zerrendatuaForm['auzoa']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('kalea', $configEremuak)): ?>
			<div id="kalea" class="field">
				<label for="zerrendatu_kalea"><?php echo __('Kalea'); ?></label>
				<?php echo $zerrendatuaForm['kalea']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('eraikina', $configEremuak)): ?>
			<div id="eraikina" class="field">
				<label for="zerrendatu_eraikina"><?php echo __('Eraikina'); ?></label>
				<?php echo $zerrendatuaForm['eraikina']->render(); ?>
			</div>
	<?php endif; ?>
		</fieldset>
<?php endif; ?>
		<fieldset>
			<div id="egoera" class="field">
				<label for="zerrendatu_egoera"><?php echo __('Egoera'); ?></label>
				<?php echo $zerrendatuaForm['egoera']->render(); ?>
			</div>
		</fieldset>
	</fieldset>

	<input id="zerrendatu_pdf" type="submit" class="botoia" name="submit" value="PDF" />
	<input id="zerrendatu_csv" type="submit" class="botoia" name="submit" value="CSV" />
</form>
