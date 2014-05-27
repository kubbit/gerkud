<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="panela" action="<?php echo url_for('erabiltzaileak/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

	<fieldset>
		<fieldset>
			<div class="field">
				<label for="langilea_username"><?php echo __('Erabiltzailea') ?>:</label>
				<?php echo $form['username']->render(array('readonly' => 'readonly')); ?>
			</div>
			<div class="field">
				<label><?php echo __('Pasahitza') ?>:</label>
				<?php echo $form['password']->render(array('readonly' => 'readonly')) ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Aktibo dago?') ?></label>
				<?php echo $form['is_active']->render() ?>
			</div>
			<div class="field">
				<label><?php echo __('Administratzailea da') ?></label>
				<?php echo $form['is_super_admin']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Izena') ?>:</label>
				<?php echo $form['first_name']->render(array('autofocus' => 'autofocus')) ?>
			</div>
			<div class="field">
				<label><?php echo __('Abizena(k)') ?>:</label>
				<?php echo $form['last_name']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Ohartarazi') ?>:</label>
				<?php echo $form['ohartaraztea_id']->render() ?>
			</div>
			<div class="field">
				<label><?php echo __('Posta elektronikoa') ?>:</label>
				<?php echo $form['email_address']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Sailak') ?>:</label>
				<?php echo $form['groups_list']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Azkenekoz sartua') ?>:</label>
				<label><?php echo $form['last_login']->getValue() ?></label>
			</div>
		</fieldset>
	</fieldset>

	<div>
		<a href="<?php echo url_for('erabiltzaileak/index') ?>" class="botoia"><?php echo __('Zerrendara bueltatu') ?></a>
<?php if (!$form->getObject()->isNew()): ?>
		<?php echo link_to(__('Ezabatu'), 'erabiltzaileak/delete?id=' . $form->getObject()->getId(), array('class' => 'botoia', 'method' => 'delete', 'confirm' => __('Ziur zaude?'))) ?>
<?php endif; ?>
		<input type="submit" class="botoia" value="<?php echo __('Gorde') ?>" />
	</div>

	<div class="izkutua">
		<?php echo $form['algorithm']->render() ?>
		<?php echo $form['salt']->render() ?>
		<?php //echo $form['username']->render() ?>

		<?php //echo $form['permissions_list']->render() ?>
		<?php echo $form['last_login']->render() ?>
		<?php echo $form['created_at']->render(); ?>
		<?php echo $form['updated_at']->render(); ?>
	</div>
</form>
