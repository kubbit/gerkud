<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<br><br>
<form  class="erab_form" action="<?php echo url_for('erabiltzaileak/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td class="erdi" colspan="4">
          &nbsp;<a href="<?php echo url_for('erabiltzaileak/index') ?>" class="boton"><?php echo __('Zerrendara bueltatu')?></a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;&nbsp;&nbsp;<?php echo link_to(__('Ezabatu'), 'erabiltzaileak/delete?id='.$form->getObject()->getId(), array('class' => 'boton', 'method' => 'delete', 'confirm' => __('Ziur zaude?'))) ?>
          <?php endif; ?>
          &nbsp;&nbsp;&nbsp;<input type="submit" value="<?php echo __('Gorde')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
	   <td class="ezker"><b><?php echo __('Erabiltzailea')?>:</b></td><td class="ezker"><b><?php echo __('Pasahitza')?>:</b></td>
	</tr>
	<tr>
	   <td class="ezker"><?php echo $form['username']->render(array('readonly'=>'readonly','size'=>30));  ?></td>
	   <td class="ezker" colspan=2><?php echo $form['password']->render(array('readonly'=>'readonly','size'=>30)) ?></td>
           <td class="ezker">
                <b><?php echo __('Aktibo dago?')?>&nbsp;</b><?php echo $form['is_active']->render() ?>
                &nbsp;&nbsp;&nbsp;<b><?php echo __('Administratzailea da')?>&nbsp;</b><?php echo $form['is_super_admin']->render() ?>
           </td>

	</tr>
        <tr>
          <td class="ezker"><b><?php echo __('Izena')?>:</b</td>
	  <td class="ezker"><b><?php echo __('Abizena(k)')?>:</b></td>
          <td class="ezker" colspan=2><b><?php echo __('Ohartarazi')?>:</b></td>
	</tr><tr>
          <td class="ezker"><?php echo $form['first_name']->render(array('size'=>30)) ?></td>
          <td class="ezker"><?php echo $form['last_name']->render(array('size'=>30)) ?></td>
          <td class="ezker" colspan=2><?php echo $form['ohartaraztea_id']->render() ?></td>
        </tr>

        <tr>
          <td class="ezker" colspan=2><b><?php echo __('Posta elektronikoa')?>:</b></td>
          <td class="ezker" colspan=2><b><?php echo __('Sailak')?>:</b></td>
	</tr><tr>
          <td class="ezker" colspan=2><?php echo $form['email_address']->render(array('size'=>50)) ?></td>
          <td class="ezker" colspan=2 rowspan=3 valign=top><?php echo $form['groups_list']->render() ?></td>
	</tr>
        <tr>
          <td class="ezker"><b><?php echo __('Azkenekoz sartua')?>:</b></td>
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
