<?php use_javascripts_for_form($zerrendatuaForm) ?>
<div>
	<form action="<?php echo url_for('zerrendatu/index'); ?>" method="post" target="_blank" class="bilaketa_form hilarak">
		<div id="sailkapena">
			<label for="zerrendatu_sailkapena1"><?php echo __('Sailkapena'); ?></label>
			<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena1]')); ?>
			<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena2]')); ?>
			<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena3]')); ?>
		</div>
		<div id="hasiera">
			<label for="zerrendatu_hasiera_year"><?php echo __('Hasiera'); ?></label>
			<?php echo $zerrendatuaForm['hasiera']->render(); ?>
		</div>
		<div id="amaiera">
			<label for="zerrendatu_amaiera_year"><?php echo __('Amaiera'); ?></label>
			<?php echo $zerrendatuaForm['amaiera']->render(); ?>
		</div>
		<div id="klasea">
			<label for="zerrendatu_klasea"><?php echo __('Klasea'); ?></label>
			<?php echo $zerrendatuaForm['klasea']->render(); ?>
		</div>
		<div id="saila">
			<label for="zerrendatu_saila"><?php echo __('Saila'); ?></label>
			<?php echo $zerrendatuaForm['saila']->render(); ?>
		</div>
		<div id="mota">
			<label for="zerrendatu_mota"><?php echo __('Mota'); ?></label>
			<?php echo $zerrendatuaForm['mota_id']->render(); ?>
		</div>
		<div id="azpimota">
			<label for="zerrendatu_azpimota"><?php echo __('Azpimota'); ?></label>
			<?php echo $zerrendatuaForm['azpimota_id']->render(); ?>
		</div>
		<div id="barrutia">
			<label for="zerrendatu_barrutia"><?php echo __('Auzoa'); ?></label>
			<?php echo $zerrendatuaForm['barrutia']->render(); ?>
		</div>
		<div id="kalea">
			<label for="zerrendatu_kalea"><?php echo __('Kalea'); ?></label>
			<?php echo $zerrendatuaForm['kalea']->render(); ?>
		</div>
		<div id="eraikina">
			<label for="zerrendatu_eraikina"><?php echo __('Eraikina'); ?></label>
			<?php echo $zerrendatuaForm['eraikina']->render(); ?>
		</div>
		<div id="egoera">
			<label for="zerrendatu_egoera"><?php echo __('Egoera'); ?></label>
			<?php echo $zerrendatuaForm['egoera']->render(); ?>
		</div>
		<div id="onartu">
			<label for="zerrendatu_onartu"></label>
			<input id="zerrendatu_onartu" type="submit" value="<?php echo __('Onartu')?>" />
		</div>
	</form>
</div>