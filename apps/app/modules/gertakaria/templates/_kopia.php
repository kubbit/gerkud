<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php $configEremuak = sfConfig::get('app_gerkud_eremuak'); ?>
<?php $configDerrigorrezkoak = sfConfig::get('app_gerkud_derrigorrezkoak'); ?>

<form action="<?php echo url_for('gertakaria/create'); ?>" method="post" class="formul" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

	<div class="formularioa">
		<div><?php echo __('Gertakari berria') ?></div>

<?php
// Gertakari originalaren datuak kopiatu
$form->setDefault('laburpena', $formZ->getObject()->getLaburpena());
$form->setDefault('klasea_id', $formZ->getObject()->getKlaseaId());
$form->setDefault('mota_id', $formZ->getObject()->getMotaId());
$form->setDefault('azpimota_id', $formZ->getObject()->getAzpimotaId());
$form->setDefault('barrutia_id', $formZ->getObject()->getBarrutiaId());
$form->setDefault('auzoa_id', $formZ->getObject()->getAuzoaId());
$form->setDefault('kalea_id', $formZ->getObject()->getKaleaId());
$form->setDefault('kale_zbkia', $formZ->getObject()->getKaleZbkia());
$form->setDefault('deskribapena', $formZ->getObject()->getDeskribapena());
$form->setDefault('lehentasuna_id', $formZ->getObject()->getLehentasunaId());
$form->setDefault('jatorrizkoSaila_id', $formZ->getObject()->getJatorrizkosailaId());
$form->setDefault('eraikina_id', $formZ->getObject()->getEraikinaId());
// Gertakariaren eremu guztiak kopiatzeko
if (sfConfig::get('app_gerkud_kopia_zehatza'))
{
	$form->setDefault('created_at', $formZ->getObject()->getCreatedAt());
	$form->setDefault('abisuaNork', $formZ->getObject()->getAbisuanork());
	$form->setDefault('hasiera_aurreikusia', $formZ->getObject()->getHasieraAurreikusia());
	$form->setDefault('amaiera_aurreikusia', $formZ->getObject()->getAmaieraAurreikusia());
}
?>

<?php if (!sfConfig::get('app_sortze_data_automatikoa')): ?>
		<div>
			<label for="gertakaria_created_at"><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['created_at']->render(); ?>
			<span class="errorea"><?php echo __($form['created_at']->getError()); ?></span>
		</div>
<?php endif; ?>
<?php if (in_array('laburpena', $configEremuak)): ?>
		<div>
			<label><?php echo __('Laburpena') ?>:<?php echo (in_array('laburpena', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['laburpena']->render(array('autofocus' => 'autofocus', 'cols' => 50, 'rows' => 1)); ?>
		</div>
<?php endif; ?>
<?php if (in_array('klasea', $configEremuak)): ?>
		<div>
			<label><?php echo __('Klasea') ?>:<?php echo (in_array('klasea', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['klasea_id']->render(); ?>
		</div>
<?php endif; ?>
<?php if (in_array('mota', $configEremuak)): ?>
		<div>
			<label><?php echo __('Mota') ?>:<?php echo (in_array('mota', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['mota_id']->render(); ?>
	<?php if (in_array('klasea', $configEremuak)): ?>
			<label><?php echo __('Azpimota') ?>:<?php echo (in_array('azpimota', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['azpimota_id']->render(); ?>
	<?php endif; ?>
		</div>
<?php endif; ?>
<?php if(count(array_intersect($configEremuak, array('barrutia', 'auzoa', 'kalea', 'kale_zbkia'))) > 0): ?>
		<div>
			<label><?php echo __('Helbidea') ?>:<?php echo (count(array_intersect($configDerrigorrezkoak, array('barrutia', 'auzoa', 'kalea', 'kale_zbkia'))) > 0)?'*':''?></label>
	<?php if (in_array('barrutia', $configEremuak)): ?>
			<?php echo $form['barrutia_id']->render(); ?>
	<?php endif; ?>
	<?php if (in_array('auzoa', $configEremuak)): ?>
			<?php echo $form['auzoa_id']->render(); ?>
	<?php endif; ?>
	<?php if (in_array('kalea', $configEremuak)): ?>
			<?php	echo $form['kalea_id']->render(); ?>
	<?php endif; ?>
	<?php if (in_array('kale_zbkia', $configEremuak)): ?>
			<?php	echo $form['kale_zbkia']->render(array('size' => 3)); ?>
	<?php endif; ?>
		</div>
<?php endif; ?>
<?php if (in_array('eraikina', $configEremuak)): ?>
		<div>
			<label><?php echo __('Eraikina') ?>:<?php echo (in_array('eraikina', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['eraikina_id']->render(); ?>
		</div>
<?php endif; ?>
<?php if (in_array('jatorrizkosaila', $configEremuak)): ?>
		<div>
			<label><?php echo __('Jatorrizko Saila') ?>:<?php echo (in_array('jatorrizkosaila', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['jatorrizkoSaila_id']->render(); ?>
		</div>
<?php endif; ?>
<?php if (in_array('lehentasuna', $configEremuak)): ?>
		<div>
			<label><?php echo __('Lehentasuna') ?>:<?php echo (in_array('lehentasuna', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['lehentasuna_id']->render(); ?>
		</div>
<?php endif; ?>
<?php if (in_array('abisuanork', $configEremuak)): ?>
		<div>
			<label><?php echo __('Nork eman du abisua') ?>:<?php echo (in_array('abisuanork', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['abisuaNork']->render(array('cols' => 32, 'rows' => 1)); ?>
		</div>
<?php endif; ?>
<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
	<?php if (in_array('hasiera_aurreikusia', $configEremuak)): ?>
		<div>
			<label for="gertakaria_hasiera_aurreikusia"><?php echo __('Hasiera aurreikusia') ?>:<?php echo (in_array('hasiera_aurreikusia', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['hasiera_aurreikusia']->render(); ?>
			<span class="errorea"><?php echo __($form['hasiera_aurreikusia']->getError()); ?></span>
		</div>
	<?php endif; ?>
	<?php if (in_array('amaiera_aurreikusia', $configEremuak)): ?>
		<div>
			<label for="gertakaria_amaiera_aurreikusia"><?php echo __('Amaiera aurreikusia') ?>:<?php echo (in_array('amaiera_aurreikusia', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['amaiera_aurreikusia']->render(); ?>
			<span class="errorea"><?php echo __($form['amaiera_aurreikusia']->getError()); ?></span>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php if (in_array('deskribapena', $configEremuak)): ?>
		<div>
			<label><?php echo __('Deskribapena') ?>:<?php echo (in_array('deskribapena', $configDerrigorrezkoak))?'*':''?></label>
			<?php echo $form['deskribapena']->render(array('cols' => 50, 'rows' => 4)); ?>
		</div>
<?php endif; ?>
		<div class="erdiratuta">
			<a class="boton" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Ezeztatu') ?></a>
			<input type="submit" value="<?php echo __('Sortu') ?>" />
		</div>

		<div style="display: none">
			<?php echo $form['saila_id']->render(); ?>
			<?php $form->setDefault('langilea_id', $sf_user->getGuardUser()->getId()); ?>
			<?php echo $form['langilea_id']->render(); ?>
			<?php echo $form['egoera_id']->render(); ?>
			<?php echo $form['ixte_data']->render(); ?>
<?php if ($form->isCSRFProtected()) : ?>
			<?php echo $form['_csrf_token']->render(); ?>
<?php endif; ?>
		</div>
	</div>
</form>