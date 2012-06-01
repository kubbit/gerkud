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
        <tr><th colspan="6" valign=top class="ezker">Gertakaria editatu<br><br></th></tr>
      <?php else: ?>
        <tr><th colspan="6" valign=top class="ezker">Gertakari berria<br><br></th></tr>
      <?php endif; ?>

    </thead>
    <tbody>
      <?php //echo $form ?>
      <?php if (!$form->getObject()->isNew()): ?>
        <tr>
                <th class="eskuin">Kodea:</th><td class="ezker"><?php echo $form->getObject()->getId();?></td>
                <th class="eskuin">Sortze Data:</th><td class="ezker"> <?php echo $form->getObject()->getCreatedAt();?></td>
        </tr>
      <?php endif; ?>
      <tr>
	<th class="eskuin"  valign=top>Laburpena:*</th>
<!--	<td colspan="5"><?php //echo $form['laburpena']->render(array('size'=>58)); ?></td></tr>-->
        <td colspan="5"><?php echo $form['laburpena']->render(array('cols'=>50,'rows'=>1)); ?></td></tr>
      <tr><th class="eskuin">Klasea:</th>
          <td colspan="5"><?php echo $form['klasea_id']->render();?></td>
      </tr><tr>
        <th class=eskuin>Mota:* </th><th class="ezker"> <?php echo $form['mota_id']->render();?></th>
	<th class=eskuin>Azpimota:*</th><th class="ezker"><?php echo $form['azpimota_id']->render(); ?></th>
      </tr>
      <tr><th class="eskuin">Helbidea:</th>
          <td colspan=5><?php echo $form['barrutia_id']->render();echo $form['kalea_id']->render()."".$form['kale_zbkia']->render(array('size'=>3))?></th>
      </tr><tr>
          <th class="eskuin" nowrap>Eraikina:</th>
          <td colspan="5"><?php echo $form['eraikina_id']->render();?></td>
      </tr><tr>
          <th class="eskuin" nowrap>Jatorrizko Saila:</th>
	  <th class="ezker" colspan=5><?php echo $form['jatorrizkoSaila_id']->render();?></th>
      </tr>
      <tr>
        <th class="eskuin">Lehentasuna:</th>
        <td class="ezker" colspan=5><?php echo $form['lehentasuna_id']->render(); ?></td>
      </tr><tr>
        <th class="eskuin" valign=top>Nork eman du abisua:</th>
	<th class="ezker" colspan=5><?php echo $form['abisuaNork']->render(array('cols'=>32,'rows'=>1)); ?></td>
      </tr><tr>
        <th class="eskuin" valign=top>Harremanetarako:</th>
	<th class="ezker" colspan="5"><?php echo $form['harremanetarako']->render(array('cols'=>32,'rows'=>1)); ?></th>
      </tr>

      <tr>
        <th class="eskuin" valign="top">Deskribapena:*</th>
        <td class="ezker" colspan=5><?php echo $form['deskribapena']->render(array('cols'=>50,'rows'=>4)); ?></td>
      </tr>
      <tr>
        <th class=panela colspan="6">
            <a class="boton" href="<?php echo url_for('gertakaria/index') ?>">Ezeztatu</a>
          <?php if (!$form->getObject()->isNew()): ?>
                <?php $gertakaria=$form->getObject(); ?>
                <input type="submit" value="Gorde" />
        <?php else: ?>
                <input type="submit" value="Sortu" />
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

