<?php use_helper('I18N') ?>
<?php $LDAP_config = bhLDAP::getConfig(); ?>

<form class="login" method="post" action="<?php echo url_for('bhLDAPAuth/signin'); ?>">

<?php if (sfConfig::get('app_logotipoa')): ?>
	<?php echo image_tag('logoa.png', array('alt' => 'Logo')); ?>
<?php endif; ?>

	<fieldset>
		<legend><?php echo __('Saioa hasi'); ?></legend>

<?php if ($form->hasErrors() || $form->hasGlobalErrors()): ?>
		<ul class="erroreak">
			<li><?php echo $form['username']->getError(); ?></li>
		</ul>
<?php endif; ?>

		<div class="field">
			<label for="signin_username"><?php echo __('Erabiltzaile izena'); ?>:</label>
			<?php echo $form['username']->render(array('autofocus' => 'autofocus')); ?>
		</div>
		<div class="field">
			<label for="signin_password"><?php echo __('Pasahitza'); ?>:</label>
			<?php echo $form['password']->render(); ?>
		</div>
	</fieldset>
	<input type="submit" class="botoia" value="<?php echo __('Sartu'); ?>" />
</form>
