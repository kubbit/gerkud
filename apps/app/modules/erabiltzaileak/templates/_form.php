<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php if($form->hasErrors() || $form->hasGlobalErrors()): ?>
<ul id="erroreak">
	<?php foreach($form->getGlobalErrors() as $name => $error): ?>
	<li><?php echo $name; ?>: <?php echo $error; ?></li>
	<?php endforeach; ?>

	<?php foreach($form->getErrorSchema()->getErrors() as $name => $error): ?>
	<li title="<?php echo $name; ?>"><?php echo __($error); ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<form class="panela" action="<?php echo url_for('erabiltzaileak/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

	<fieldset>
		<fieldset>
			<div id="username" class="field">
				<label for="langilea_username"><?php echo __('Erabiltzailea') ?>:</label>
				<?php echo $form['username']->render(array('readonly' => 'readonly')); ?>
			</div>
			<div id="password" class="field">
				<label><?php echo __('Pasahitza') ?>:</label>
<?php if (sfConfig::get('gerkud_ldap')) : ?>
				<?php echo $form['password']->render(array('readonly' => 'readonly')); ?>
<?php else: ?>
				<?php echo $form['password']->render(); ?>
<?php endif; ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="is_active" class="field">
				<label><?php echo __('Aktibo dago?') ?></label>
				<?php echo $form['is_active']->render() ?>
			</div>
			<div id="is_super_admin" class="field">
				<label><?php echo __('Administratzailea da') ?></label>
				<?php echo $form['is_super_admin']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="first_name" class="field">
				<label><?php echo __('Izena') ?>:</label>
				<?php echo $form['first_name']->render(array('autofocus' => 'autofocus')) ?>
			</div>
			<div id="last_name" class="field">
				<label><?php echo __('Abizena(k)') ?>:</label>
				<?php echo $form['last_name']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="ohartaraztea_id" class="field">
				<label><?php echo __('Ohartarazi') ?>:</label>
				<?php echo $form['ohartaraztea_id']->render() ?>
			</div>
			<div id="email_address" class="field">
				<label><?php echo __('Posta elektronikoa') ?>:</label>
				<?php echo $form['email_address']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="groups_list" class="field">
				<label><?php echo __('Sailak') ?>:</label>
				<?php echo $form['groups_list']->render() ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="last_login" class="field">
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

		<?php echo $form['permissions_list']->render() ?>
		<?php echo $form['last_login']->render() ?>
		<?php echo $form['created_at']->render(); ?>
		<?php echo $form['updated_at']->render(); ?>
	</div>
</form>
