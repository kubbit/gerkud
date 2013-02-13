<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


<form action="<?php echo url_for('gertakaria/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" class="formul" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="formularioa">
    <tfoot>
      <tr>
      </tr>
    </tfoot>
    <thead>
      <?php if (!$form->getObject()->isNew()): ?>
        <tr><th colspan="6" valign=top class="ezker"><?php echo __('Gertakaria editatu')?><br><br></th></tr>
      <?php else: ?>
        <tr><th colspan="6" valign=top class="ezker"><?php echo __('Gertakari berria')?><br><br></th></tr>
      <?php endif; ?>

    </thead>
    <tbody>
      <?php //echo $form ?>
      <?php if (!$form->getObject()->isNew()): ?>
        <tr>
                <th class="eskuin"><?php echo __('Kodea')?>:</th><td class="ezker"><?php echo $form->getObject()->getId();?></td>
                <th class="eskuin"><?php echo __('Sortze Data')?>:</th><td class="ezker"> <?php echo $form->getObject()->getCreatedAt();?></td>
        </tr>
      <?php endif; ?>
      <tr>
	<th class="eskuin"  valign=top><?php echo __('Laburpena')?>:*</th>
<!--	<td colspan="5"><?php //echo $form['laburpena']->render(array('size'=>58)); ?></td></tr>-->
        <td colspan="5"><?php echo $form['laburpena']->render(array('cols'=>50,'rows'=>1)); ?></td></tr>
      <tr><th class="eskuin"><?php echo __('Klasea')?>:</th>
          <td colspan="5"><?php echo $form['klasea_id']->render();?></td>
      </tr><tr>
        <th class=eskuin><?php echo __('Mota')?>:* </th><th class="ezker"> <?php echo $form['mota_id']->render();?></th>
	<th class=eskuin><?php echo __('Azpimota')?>:*</th><th class="ezker"><?php echo $form['azpimota_id']->render(); ?></th>
      </tr>
      <tr><th class="eskuin"><?php echo __('Helbidea')?>:</th>
          <td colspan=5><?php echo $form['barrutia_id']->render();echo $form['kalea_id']->render()."".$form['kale_zbkia']->render(array('size'=>3))?></th>
      </tr><tr>
          <th class="eskuin" nowrap><?php echo __('Eraikina')?>:</th>
          <td colspan="5"><?php echo $form['eraikina_id']->render();?></td>
      </tr><tr>
          <th class="eskuin" nowrap><?php echo __('Jatorrizko Saila')?>:</th>
	  <th class="ezker" colspan=5><?php echo $form['jatorrizkoSaila_id']->render();?></th>
      </tr>
      <tr>
        <th class="eskuin"><?php echo __('Lehentasuna')?>:</th>
        <td class="ezker" colspan=5><?php echo $form['lehentasuna_id']->render(); ?></td>
      </tr><tr>
        <th class="eskuin" valign=top><?php echo __('Nork eman du abisua')?>:</th>
	<th class="ezker" colspan=5><?php echo $form['abisuaNork']->render(array('cols'=>32,'rows'=>1)); ?></td>
      </tr>
<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
	  <tr>
        <th class="eskuin" valign=top><?php echo __('Hasiera aurreikusia')?>:</th>
	<th class="ezker" colspan=5><?php echo $form['hasiera_aurreikusia']->render();?><?php echo __($form['hasiera_aurreikusia']->getError()); ?></th>
      </tr><tr>
        <th class="eskuin" valign=top><?php echo __('Amaiera aurreikusia')?>:</th>
	<th class="ezker" colspan=5><?php echo $form['amaiera_aurreikusia']->render();?><?php echo __($form['amaiera_aurreikusia']->getError()); ?></th>
      </tr>
<?php endif; ?>

      <tr>
        <th class="eskuin" valign="top"><?php echo __('Deskribapena')?>:*</th>
        <td class="ezker" colspan=5><?php echo $form['deskribapena']->render(array('cols'=>50,'rows'=>4)); ?></td>
      </tr>
      <tr>
        <th class=panela colspan="6">
            <a class="boton" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Ezeztatu')?></a>
          <?php if (!$form->getObject()->isNew()): ?>
                <?php $gertakaria=$form->getObject(); ?>
                <input type="submit" value="<?php echo __('Gorde')?>" />
        <?php else: ?>
                <input type="submit" value="<?php echo __('Sortu')?>" />
        <?php endif; ?>
        </th>
     </tr>
     <tr><th colspan=5>
            <div id="izkutua_"  style="display:none">
                <?php echo $form['saila_id']->render();  ?>
		<?php if ($form->getObject()->isNew()): ?>
	                <?php $form->setDefault ('langilea_id', $sf_user->getGuardUser()->getId()); ?>
		<?php endif; ?>
                <?php echo $form['langilea_id']->render();  ?>
                <?php echo $form['egoera_id']->render();  ?>
                <?php echo $form['ixte_data']->render(); ?>
	        <?php if ($form->isCSRFProtected()) : ?>
        	  <?php echo $form['_csrf_token']->render(); ?>
	        <?php endif; ?>
            </div>
     </th></tr>
    </tbody>
  </table>
</form>

