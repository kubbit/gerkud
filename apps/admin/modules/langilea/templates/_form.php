<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<br><br>
<form  class="erab_form" action="<?php echo url_for('langilea/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td class="erdi" colspan="4">
          &nbsp;<a href="<?php echo url_for('langilea/index') ?>" class="boton">Zerrendara bueltatu</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;&nbsp;&nbsp;<?php echo link_to('Ezabatu', 'langilea/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Ziur zaude?')) ?>
          <?php endif; ?>
          &nbsp;&nbsp;&nbsp;<input type="submit" value="Gorde" />
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
	   <td class="ezker"><b>Erabiltzailea:</b></td><td class="ezker"><b>Pasahitza:</b></td>
	</tr>
	<tr>
	   <td class="ezker"><?php echo $form['username']->render(array('readonly'=>'readonly','size'=>30));  ?></td>
	   <td class="ezker" colspan=2><?php echo $form['password']->render(array('readonly'=>'readonly','size'=>30)) ?></td>
           <td class="ezker">
                <b>Is Active:</b><?php echo $form['is_active']->render() ?>
                &nbsp;&nbsp;&nbsp;<b>Is Super Admin:</b><?php echo $form['is_super_admin']->render() ?>
           </td>

	</tr>
        <tr>
          <td class="ezker"><b>Izena:</b</td>
	  <td class="ezker"><b>Abizena(k):</b></td>
          <td class="ezker" colspan=2><b>Ohartarazi:</b></td>
	</tr><tr>
          <td class="ezker"><?php echo $form['first_name']->render(array('size'=>30)) ?></td>
          <td class="ezker"><?php echo $form['last_name']->render(array('size'=>30)) ?></td>
          <td class="ezker" colspan=2><?php echo $form['ohartaraztea_id']->render() ?></td>
        </tr>

        <tr>
          <td class="ezker" colspan=2><b>Email helbidea:</b></td>
          <td class="ezker" colspan=2><b>Taldeak:</b></td>
	</tr><tr>
          <td class="ezker" colspan=2><?php echo $form['email_address']->render(array('size'=>50)) ?></td>
          <td class="ezker" colspan=2 rowspan=3 valign=top><?php echo $form['groups_list']->render() ?></td>
	</tr>
        <tr>
          <td class="ezker"><b>Azkenekoz sartua:</b></td>
        </tr><tr>
	  <td class="ezker" colspan=2><?php echo $form['last_login']->render(array('readonly'=>'readonly')) ?></td>
        </tr>
        <tr>
        </tr>

        <tr><th colspan=3><br>
            <div id="izkutua"  style="display:none">
		<?php echo $form['algorithm']->render() ?>
		<?php echo $form['salt']->render() ?>		
		<?php echo $form['username']->render() ?>		

                <?php echo $form['permissions_list']->render() ?>
		<?php echo $form['last_login']->render() ?>
                <?php echo $form['created_at']->render();  ?>
                <?php echo $form['updated_at']->render(); ?>
            </div>
        </th></tr>


<!--      <?php //echo $form ?>  -->
    </tbody>
  </table>
</form>
