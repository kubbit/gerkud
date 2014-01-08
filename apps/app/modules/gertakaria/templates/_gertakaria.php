<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php $configEremuak = sfConfig::get('app_gerkud_eremuak'); ?>
<?php $configDerrigorrezkoak = sfConfig::get('app_gerkud_derrigorrezkoak'); ?>

<?php
	$formularioa_url = sprintf('gertakaria/%s%s', ($form->getObject()->isNew() ? 'create' : 'update'), (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : ''));
?>

<form action="<?php echo url_for($formularioa_url) ?>" method="post" class="formul" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
	<div class="formularioa">
		<div>
<?php if (!$form->getObject()->isNew()): ?>
		<?php echo __('Gertakaria editatu') ?>
<?php else: ?>
		<?php echo __('Gertakari berria') ?>
<?php endif; ?>
		</div>

		<div>
<?php if (!$form->getObject()->isNew()): ?>
			<label><?php echo __('Kodea') ?>:</label>
			<?php echo $form->getObject()->getId(); ?>
	<?php if (sfConfig::get('app_sortze_data_automatikoa')): ?>
			<label><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo date(sfConfig::get('app_data_formatoa'), strtotime($form->getObject()->getCreatedAt())); ?>
	<?php else: ?>
			<label for="gertakaria_created_at"><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['created_at']->render(); ?>
			<span class="errorea"><?php echo __($form['created_at']->getError()); ?></span>
	<?php endif; ?>
<?php elseif (!sfConfig::get('app_sortze_data_automatikoa')): ?>
			<label for="gertakaria_created_at"><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['created_at']->render(); ?>
			<span class="errorea"><?php echo __($form['created_at']->getError()); ?></span>
<?php endif; ?>
		</div>
<?php if (in_array('laburpena', $configEremuak)): ?>
		<div>
			<label for="gertakaria_laburpena"><?php echo __('Laburpena') ?>:<?php echo (in_array('laburpena', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['laburpena']->render(array('autofocus' => 'autofocus', 'cols' => 50, 'rows' => 1)); ?>
			<span class="errorea"><?php echo __($form['laburpena']->getError()); ?></span>
		</div>
<?php endif; ?>
<?php if (in_array('mota', $configEremuak)): ?>
		<div>
			<label for="gertakaria_mota_id"><?php echo __('Mota') ?>:<?php echo (in_array('mota', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['mota_id']->render(); ?>
			<span class="errorea"><?php echo __($form['mota_id']->getError()); ?></span>
	<?php if (in_array('azpimota', $configEremuak)): ?>
			<label for="gertakaria_azpimota_id"><?php echo __('Azpimota') ?>:<?php echo (in_array('azpimota', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['azpimota_id']->render(); ?>
			<span class="errorea"><?php echo __($form['azpimota_id']->getError()); ?></span>
	<?php endif; ?>
		</div>
<?php endif; ?>
<?php if (in_array('klasea', $configEremuak)): ?>
		<div>
			<label for="gertakaria_klasea_id"><?php echo __('Klasea') ?>:<?php echo (in_array('klasea', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['klasea_id']->render(); ?>
			<span class="errorea"><?php echo __($form['klasea_id']->getError()); ?></span>
		</div>
<?php endif; ?>
<?php if(count(array_intersect($configEremuak, array('barrutia', 'kalea', 'kale_zbkia', 'eraikina'))) > 0): ?>
		<div>
			<label for="gertakaria_barrutia_id"><?php echo __('Helbidea') ?>:<?php echo (count(array_intersect($configDerrigorrezkoak, array('barrutia', 'auzoa', 'kalea', 'kale_zbkia'))) > 0)?'*':'' ?></label>
	<?php if (in_array('barrutia', $configEremuak)): ?>
	<?php	echo $form['barrutia_id']->render(); ?>
			<span class="errorea"><?php echo __($form['barrutia_id']->getError()); ?></span>
	<?php endif; ?>
	<?php if (in_array('auzoa', $configEremuak)): ?>
	<?php	echo $form['auzoa_id']->render(); ?>
			<span class="errorea"><?php echo __($form['auzoa_id']->getError()); ?></span>
	<?php endif; ?>
	<?php if (in_array('kalea', $configEremuak)): ?>
	<?php	echo $form['kalea_id']->render(); ?>
			<span class="errorea"><?php echo __($form['kalea_id']->getError()); ?></span>
	<?php endif; ?>
	<?php if (in_array('kale_zbkia', $configEremuak)): ?>
	<?php	echo $form['kale_zbkia']->render(array('size' => 3)); ?>
			<span class="errorea"><?php echo __($form['kale_zbkia']->getError()); ?></span>
	<?php endif; ?>
		</div>
<?php endif; ?>
<?php if (in_array('eraikina', $configEremuak)): ?>
		<div>
			<label for="gertakaria_eraikina_id"><?php echo __('Eraikina') ?>:<?php echo (in_array('eraikina', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['eraikina_id']->render(); ?>
			<span class="errorea"><?php echo __($form['eraikina_id']->getError()); ?></span>
		</div>
<?php endif; ?>
<?php if (in_array('jatorrizkosaila', $configEremuak)): ?>
		<div>
			<label for="gertakaria_jatorrizkoSaila_id"><?php echo __('Jatorrizko Saila') ?>:<?php echo (in_array('jatorrizkosaila', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['jatorrizkoSaila_id']->render(); ?>
			<span class="errorea"><?php echo __($form['jatorrizkoSaila_id']->getError()); ?></span>
		</div>
<?php endif; ?>
<?php if (in_array('lehentasuna', $configEremuak)): ?>
		<div>
			<label for="gertakaria_lehentasuna_id"><?php echo __('Lehentasuna') ?>:<?php echo (in_array('lehentasuna', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['lehentasuna_id']->render(); ?>
			<span class="errorea"><?php echo __($form['lehentasuna_id']->getError()); ?></span>
		</div>
<?php endif; ?>
<?php if (in_array('abisuanork', $configEremuak)): ?>
		<div>
			<label for="gertakaria_abisuaNork"><?php echo __('Nork eman du abisua') ?>:<?php echo (in_array('abisuanork', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['abisuaNork']->render(array('cols' => 32, 'rows' => 1)); ?>
			<span class="errorea"><?php echo __($form['abisuaNork']->getError()); ?></span>
		</div>
<?php endif; ?>
<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
	<?php if (in_array('hasiera_aurreikusia', $configEremuak)): ?>
		<div>
			<label for="gertakaria_hasiera_aurreikusia"><?php echo __('Hasiera aurreikusia') ?>:<?php echo (in_array('hasiera_aurreikusia', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['hasiera_aurreikusia']->render(); ?>
			<span class="errorea"><?php echo __($form['hasiera_aurreikusia']->getError()); ?></span>
		</div>
	<?php endif; ?>
	<?php if (in_array('amaiera_aurreikusia', $configEremuak)): ?>
		<div>
			<label for="gertakaria_amaiera_aurreikusia"><?php echo __('Amaiera aurreikusia') ?>:<?php echo (in_array('amaiera_aurreikusia', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['amaiera_aurreikusia']->render(); ?>
			<span class="errorea"><?php echo __($form['amaiera_aurreikusia']->getError()); ?></span>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php if (in_array('deskribapena', $configEremuak)): ?>
		<div>
			<label for="gertakaria_deskribapena"><?php echo __('Deskribapena') ?>:<?php echo (in_array('deskribapena', $configDerrigorrezkoak))?'*':'' ?></label>
			<?php echo $form['deskribapena']->render(array('cols' => 50, 'rows' => 4)); ?>
			<span class="errorea"><?php echo __($form['deskribapena']->getError()); ?></span>
		</div>
<?php endif; ?>

		<div class="erdiratuta">
			<a class="boton" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Ezeztatu') ?></a>
<?php if (!$form->getObject()->isNew()): ?>
		<?php $gertakaria = $form->getObject(); ?>
			<input type="submit" value="<?php echo __('Gorde') ?>" />
<?php else: ?>
			<input type="submit" value="<?php echo __('Sortu') ?>" />
<?php endif; ?>

<?php if ($form->getObject()->getSailaId()): ?>
			<input type="submit" class="eskubian" name="gertakaria_itxi" value="<?php echo __('Gorde eta Itxi'); ?>" />
<?php endif; ?>
		</div>

		<div id="izkutua_"  style="display:none">
			<?php echo $form['saila_id']->render(); ?>

<?php if ($form->getObject()->isNew()): ?>
			<?php $form->setDefault('langilea_id', $sf_user->getGuardUser()->getId()); ?>
<?php endif; ?>

			<?php echo $form['langilea_id']->render(); ?>
			<?php echo $form['egoera_id']->render(); ?>
			<?php echo $form['ixte_data']->render(); ?>

<?php if ($form->isCSRFProtected()): ?>
			<?php echo $form['_csrf_token']->render(); ?>
<?php endif; ?>

		</div>
	</div>
</form>

