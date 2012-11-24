<br><br>
<?php use_helper('I18N') ?>
<?php $LDAP_config = bhLDAP::getConfig(); ?>
<div id="sf_admin_container">

<div id="sf_guard_auth_form"></div>
<div class="login_form">
<?php echo form_tag('@bh_ldap_signin') ?>

<!--    <h1>Log In</h1> -->

  <fieldset>

	<table> 
	<tr><td><br></td></tr>
	<tr>
	    <td class="eskuin"><label for="signin_username"><?php echo __('Erabiltzaile izena')?>:</label></td>
	    <td class="ezker">
		<?php echo $form['username']->renderError()  ?>
		<?php echo $form['username']->render() ?>
	      	<?php //echo $LDAP_config['adLDAP']['account_suffix'] ;  ?>
	    </td>
	</tr>
	<tr>
            <td class="eskuin"><?php echo __('Pasahitza')?>:</td>
	    <td class="ezker">
		<?php //echo $form['password']->renderRow() ?>
            	<?php echo $form['password']->render() ?>
	    </td>
	</tr>
        <tr  style="display:none">
            <td class="eskuin"><?php echo __('Gogoratu')?></td>
            <td class="ezker">
		<?php //echo $form['remember']->renderRow() ?>
                <?php echo $form['remember']->render() ?>
	    </td>
        </tr>
	<tr>
	    <td colspan=3 class="erdi">
		<input type="submit" value="<?php echo __('Sartu') ?>" class="sf_admin_action_save" />
	    </td>
	</tr>
	</table>

  </fieldset>

<!--
      <ul class="sf_admin_actions">
	<li class="float-right">
	  <input type="submit" value="<?php //echo __('Log In') ?>" class="sf_admin_action_save" />
	</li>
      </ul>
-->
    </form>
    </div>
  </div>
