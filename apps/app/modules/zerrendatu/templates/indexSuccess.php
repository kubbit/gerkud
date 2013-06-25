<?php use_javascripts_for_form($zerrendatuaForm) ?>
<div>
	<form action="<?php echo url_for('zerrendatu/index'); ?>" method="post" target="_blank" class="bilaketa_form hilarak">
		<div id="sailkapena">
			<label for="zerrendatu_sailkapena1"><?php echo __('Sailkapena'); ?></label>
			<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena1]')); ?>
			<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena2]')); ?>
			<?php echo $zerrendatuaForm['sailkapena']->render(array('name' => 'zerrendatu[sailkapena3]')); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['sailkapena']->getError()); ?></span>
		</div>
		<div id="hasiera">
			<label for="zerrendatu_hasiera"><?php echo __('Hasiera'); ?></label>
			<?php echo $zerrendatuaForm['hasiera']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['hasiera']->getError()); ?></span>
		</div>
		<div id="amaiera">
			<label for="zerrendatu_amaiera"><?php echo __('Amaiera'); ?></label>
			<?php echo $zerrendatuaForm['amaiera']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['amaiera']->getError()); ?></span>
		</div>
		<div id="klasea">
			<label for="zerrendatu_klasea"><?php echo __('Klasea'); ?></label>
			<?php echo $zerrendatuaForm['klasea']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['klasea']->getError()); ?></span>
		</div>
		<div id="saila">
			<label for="zerrendatu_saila"><?php echo __('Saila'); ?></label>
			<?php echo $zerrendatuaForm['saila']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['saila']->getError()); ?></span>
		</div>
		<div id="mota">
			<label for="zerrendatu_mota_id"><?php echo __('Mota'); ?></label>
			<?php echo $zerrendatuaForm['mota_id']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['mota_id']->getError()); ?></span>
		</div>
		<div id="azpimota">
			<label for="zerrendatu_azpimota_id"><?php echo __('Azpimota'); ?></label>
			<?php echo $zerrendatuaForm['azpimota_id']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['azpimota_id']->getError()); ?></span>
		</div>
		<div id="barrutia">
			<label for="zerrendatu_barrutia"><?php echo __('Auzoa'); ?></label>
			<?php echo $zerrendatuaForm['barrutia']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['barrutia']->getError()); ?></span>
		</div>
		<div id="kalea">
			<label for="zerrendatu_kalea"><?php echo __('Kalea'); ?></label>
			<?php echo $zerrendatuaForm['kalea']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['kalea']->getError()); ?></span>
		</div>
		<div id="eraikina">
			<label for="zerrendatu_eraikina"><?php echo __('Eraikina'); ?></label>
			<?php echo $zerrendatuaForm['eraikina']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['eraikina']->getError()); ?></span>
		</div>
		<div id="egoera">
			<label for="zerrendatu_egoera"><?php echo __('Egoera'); ?></label>
			<?php echo $zerrendatuaForm['egoera']->render(); ?>
			<span class="errorea"><?php echo __($zerrendatuaForm['egoera']->getError()); ?></span>
		</div>
		<div id="onartu">
			<label for="zerrendatu_onartu"></label>
			<input id="zerrendatu_onartu" type="submit" value="<?php echo __('Onartu')?>" />
		</div>
	</form>
</div>