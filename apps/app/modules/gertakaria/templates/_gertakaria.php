<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

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
			<label><?php echo __('Sortze Data') ?>:</label>
			<?php echo date(sfConfig::get('app_data_formatoa'), strtotime($form->getObject()->getCreatedAt())); ?>
	<?php else: ?>
			<label><?php echo __('Sortze Data') ?>:*</label>
			<?php echo $form['created_at']->render(); ?>
			<span class="errorea"><?php echo __($form['created_at']->getError()); ?></span>
	<?php endif; ?>
<?php elseif (!sfConfig::get('app_sortze_data_automatikoa')): ?>
			<label><?php echo __('Sortze Data') ?>:*</label>
			<?php echo $form['created_at']->render(); ?>
			<span class="errorea"><?php echo __($form['created_at']->getError()); ?></span>
<?php endif; ?>
		</div>
		<div>
			<label><?php echo __('Laburpena') ?>:*</label>
			<?php echo $form['laburpena']->render(array('cols' => 50, 'rows' => 1)); ?>
			<span class="errorea"><?php echo __($form['laburpena']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Klasea') ?>:</label>
			<?php echo $form['klasea_id']->render(); ?>
			<span class="errorea"><?php echo __($form['klasea_id']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Mota') ?>:*</label>
			<?php echo $form['mota_id']->render(); ?>
			<span class="errorea"><?php echo __($form['mota_id']->getError()); ?></span>
			<label><?php echo __('Azpimota') ?>:*</label>
			<?php echo $form['azpimota_id']->render(); ?>
			<span class="errorea"><?php echo __($form['azpimota_id']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Helbidea') ?>:</label>
			<?php echo $form['barrutia_id']->render();
			echo $form['kalea_id']->render() . "" . $form['kale_zbkia']->render(array('size' => 3)) ?>
			<span class="errorea"><?php echo __($form['barrutia_id']->getError()); ?></span>
			<span class="errorea"><?php echo __($form['kalea_id']->getError()); ?></span>
			<span class="errorea"><?php echo __($form['kale_zbkia']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Eraikina') ?>:</label>
			<?php echo $form['eraikina_id']->render(); ?>
			<span class="errorea"><?php echo __($form['eraikina_id']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Jatorrizko Saila') ?>:</label>
			<?php echo $form['jatorrizkoSaila_id']->render(); ?>
			<span class="errorea"><?php echo __($form['jatorrizkoSaila_id']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Lehentasuna') ?>:</label>
			<?php echo $form['lehentasuna_id']->render(); ?>
			<span class="errorea"><?php echo __($form['lehentasuna_id']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Nork eman du abisua') ?>:</label>
			<?php echo $form['abisuaNork']->render(array('cols' => 32, 'rows' => 1)); ?>
			<span class="errorea"><?php echo __($form['abisuaNork']->getError()); ?></span>
		</div>

<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
		<div>
			<label><?php echo __('Hasiera aurreikusia') ?>:</label>
			<?php echo $form['hasiera_aurreikusia']->render(); ?>
			<span class="errorea"><?php echo __($form['hasiera_aurreikusia']->getError()); ?></span>
		</div>
		<div>
			<label><?php echo __('Amaiera aurreikusia') ?>:</label>
			<?php echo $form['amaiera_aurreikusia']->render(); ?>
			<span class="errorea"><?php echo __($form['amaiera_aurreikusia']->getError()); ?></span>
		</div>
<?php endif; ?>

		<div>
			<label><?php echo __('Deskribapena') ?>:</label>
			<?php echo $form['deskribapena']->render(array('cols' => 50, 'rows' => 4)); ?>
			<span class="errorea"><?php echo __($form['deskribapena']->getError()); ?></span>
		</div>

		<div class="erdiratuta">
			<a class="boton" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Ezeztatu') ?></a>
<?php if (!$form->getObject()->isNew()): ?>
		<?php $gertakaria = $form->getObject(); ?>
			<input type="submit" value="<?php echo __('Gorde') ?>" />
<?php else: ?>
			<input type="submit" value="<?php echo __('Sortu') ?>" />
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

