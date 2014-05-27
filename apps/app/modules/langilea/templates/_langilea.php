<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="panela" action="<?php echo url_for('langilea/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

	<fieldset>
		<legend><?php echo __('Nere datuak aldatu') ?></legend>

		<fieldset>
			<div class="field">
				<label><?php echo __('Erabiltzailea') ?>:</label>
				<?php echo $form['username']->render(array('readonly' => 'readonly', 'size' => 30)); ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Izena') ?>:</label>
				<?php echo $form['first_name']->render(array('autofocus' => 'autofocus', 'size' => 30)) ?>
			</div>
			<div class="field">
				<label><?php echo __('Abizena(k)') ?>:</label>
				<?php echo $form['last_name']->render(array('size' => 30)) ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Posta elektronikoa') ?>:</label>
				<?php echo $form['email_address']->render(array('size' => 30)) ?>
			</div>
		</fieldset>
		<fieldset>
			<div class="field">
				<label><?php echo __('Ohartarazi') ?>:</label>
				<?php echo $form['ohartaraztea_id']->render() ?>
			</div>
		</fieldset>
	</fieldset>

	<div>
		<a class="botoia" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Itzuli gertakarien zerrendara') ?></a>
		<input type="submit" class="botoia" value="<?php echo __('Gorde') ?>" />
	</div>

	<div class="izkutua">
		<?php echo $form['id']->render(); ?>
		<?php echo $form['username']->render(array('id' => '')) ?>
		<?php echo $form['algorithm']->render() ?>
		<?php echo $form['salt']->render() ?>
		<?php echo $form['password']->render(); ?>
		<?php echo $form['is_active']->render() ?>
		<?php echo $form['is_super_admin']->render() ?>
		<?php echo $form['last_login']->render() ?>
		<?php echo $form['created_at']->render(); ?>
		<?php echo $form['updated_at']->render(); ?>

		<?php echo $form['groups_list']->render() ?>
	</div>
</form>
