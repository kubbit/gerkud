<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form  class="erab_form" action="<?php echo url_for('erabiltzaileak/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

	<label>
		<span><?php echo __('Erabiltzailea') ?>:</span>
		<?php echo $form['username']->render(array('readonly' => 'readonly', 'size' => 30)); ?>
	</label>
	<label>
		<span><?php echo __('Pasahitza') ?>:</span>
		<?php echo $form['password']->render(array('readonly' => 'readonly', 'size' => 30)) ?>
	</label>
	<label>
		<span>&nbsp;</span>
		<?php echo __('Aktibo dago?') ?>
		<?php echo $form['is_active']->render() ?>
	</label>
	<label>
		<span>&nbsp;</span>
		<?php echo __('Administratzailea da') ?>
		<?php echo $form['is_super_admin']->render() ?>
	</label>
	<div>
		<label>
			<span><?php echo __('Izena') ?>:</span>
			<?php echo $form['first_name']->render(array('autofocus' => 'autofocus', 'size' => 30)) ?>
		</label>
		<label>
			<span><?php echo __('Abizena(k)') ?>:</span>
			<?php echo $form['last_name']->render(array('size' => 30)) ?>
		</label>
	</div>
	<label>
		<span><?php echo __('Ohartarazi') ?>:</span>
		<?php echo $form['ohartaraztea_id']->render() ?>
	</label>
	<label>
		<span><?php echo __('Posta elektronikoa') ?>:</span>
		<?php echo $form['email_address']->render(array('size' => 50)) ?>
	</label>
	<label>
		<span><?php echo __('Sailak') ?>:</span>
		<?php echo $form['groups_list']->render() ?>
	</label>
	<div>
		<label>
			<span><?php echo __('Azkenekoz sartua') ?>:</span>
			<span><?php echo $form['last_login']->getValue() ?></span>
		</label>
	</div>

	<div class="erdiratuta">
		<a href="<?php echo url_for('erabiltzaileak/index') ?>" class="boton"><?php echo __('Zerrendara bueltatu') ?></a>
<?php if (!$form->getObject()->isNew()): ?>
		<?php echo link_to(__('Ezabatu'), 'erabiltzaileak/delete?id=' . $form->getObject()->getId(), array('class' => 'boton', 'method' => 'delete', 'confirm' => __('Ziur zaude?'))) ?>
<?php endif; ?>
		<input type="submit" value="<?php echo __('Gorde') ?>" />
	</div>

	<div style="display: none">
		<?php echo $form['algorithm']->render() ?>
		<?php echo $form['salt']->render() ?>
		<?php //echo $form['username']->render() ?>

		<?php //echo $form['permissions_list']->render() ?>
		<?php //echo $form['last_login']->render() ?>
		<?php echo $form['created_at']->render(); ?>
		<?php echo $form['updated_at']->render(); ?>
	</div>
</form>
