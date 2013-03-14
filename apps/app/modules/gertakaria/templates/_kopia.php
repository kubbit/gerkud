<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

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
$form->setDefault('kalea_id', $formZ->getObject()->getKaleaId());
$form->setDefault('kale_zbkia', $formZ->getObject()->getKaleZbkia());
$form->setDefault('deskribapena', $formZ->getObject()->getDeskribapena());
$form->setDefault('lehentasuna_id', $formZ->getObject()->getLehentasunaId());
$form->setDefault('jatorrizkosaila_id', $formZ->getObject()->getJatorrizkosailaId());
$form->setDefault('eraikina_id', $formZ->getObject()->getEraikinaId());
?>

		<div>
			<label><?php echo __('Laburpena') ?>:*</label>
			<?php echo $form['laburpena']->render(array('cols' => 50, 'rows' => 1)); ?>
		</div>
		<div>
			<label><?php echo __('Klasea') ?>:</label>
			<?php echo $form['klasea_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Mota') ?>:*</label>
			<?php echo $form['mota_id']->render(); ?>
			<label><?php echo __('Azpimota') ?>:*</label>
			<?php echo $form['azpimota_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Helbidea') ?>:</label>
			<?php echo $form['barrutia_id']->render();
			echo $form['kalea_id']->render() . "" . $form['kale_zbkia']->render(array('size' => 3)) ?>
		</div>
		<div>
			<label><?php echo __('Eraikina') ?>:</label>
			<?php echo $form['eraikina_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Jatorrizko Saila') ?>:</label>
			<?php echo $form['jatorrizkoSaila_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Lehentasuna') ?>:</label>
			<?php echo $form['lehentasuna_id']->render(); ?>
		</div>
		<div>
			<label><?php echo __('Nork eman du abisua') ?>:</label>
			<?php echo $form['abisuaNork']->render(array('cols' => 32, 'rows' => 1)); ?>
		</div>
		<div>
			<label><?php echo __('Deskribapena') ?>:*</label>
			<?php echo $form['deskribapena']->render(array('cols' => 50, 'rows' => 4)); ?>
		</div>
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