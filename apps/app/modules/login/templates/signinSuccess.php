<?php use_helper('I18N') ?>

<form class="login" method="post" action="<?php echo url_for('login/signin'); ?>">

<?php if (sfConfig::get('gerkud_logotipoa')): ?>
	<?php echo image_tag(sfConfig::get('gerkud_logotipoa'), array('alt' => 'Logo')); ?>
<?php endif; ?>

	<fieldset>
		<legend><?php echo __('Saioa hasi'); ?></legend>

<?php if ($form->hasErrors() || $form->hasGlobalErrors()): ?>
		<ul class="erroreak">
	<?php foreach($form->getErrorSchema()->getErrors() as $name => $error): ?>
<li><?php //var_dump($error); ?></li>
		<?php if ($error instanceof sfValidatorErrorSchema): ?>
			<?php foreach($error->getErrors() as $subform_name => $subform_error): ?>
				<li title="<?php echo sprintf('%s_%s', $name, $subform_name); ?>"><?php echo __($subform_error); ?></li>
			<?php endforeach; ?>
		<?php else: ?>
				<li title="<?php echo $name; ?>"><?php echo __($error); ?></li>
		<?php endif; ?>
	<?php endforeach; ?>
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
