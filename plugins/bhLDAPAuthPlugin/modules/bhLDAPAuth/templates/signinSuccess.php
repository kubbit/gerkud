<?php use_helper('I18N') ?>
<?php $LDAP_config = bhLDAP::getConfig(); ?>

<div id="sf_admin_container">
	<div id="sf_guard_auth_form"></div>
	<div class="login_form">
		<?php echo form_tag('@bh_ldap_signin') ?>
			<fieldset>
				<div class="errorea">
					<?php echo $form['username']->getError() ?>
				</div>
				<div>
					<label for="signin_username"><?php echo __('Erabiltzaile izena') ?>:</label>
					<?php echo $form['username']->render(array('autofocus' => 'autofocus')) ?>
				</div>
				<div>
					<label for="signin_password"><?php echo __('Pasahitza') ?>:</label>
					<?php echo $form['password']->render() ?>
				</div>
				<div>
					<input type="submit" value="<?php echo __('Sartu') ?>" class="sf_admin_action_save" />
				</div>
			</fieldset>
		</form>
	</div>
</div>
