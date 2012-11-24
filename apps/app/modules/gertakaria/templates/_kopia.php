<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<!--
<form action="<?php echo url_for('gertakaria/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" class="formul" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
-->

<form action="<?php echo url_for('gertakaria/create'); ?>" method="post" class="formul" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?><input type="hidden" name="sf_method" value="put" />
<?php endif; ?>




  <table class="formularioa">
    <tfoot>
      <tr>
      </tr>
    </tfoot>
    <thead>
     <tr><th colspan="6" valign=top class="ezker">Gertakari berria<br><br></th></tr>

     <?php $form->setDefault ('laburpena', $formZ->getObject()->getLaburpena()); ?>
     <?php $form->setDefault ('klasea_id', $formZ->getObject()->getKlaseaId()); ?>
     <?php $form->setDefault ('mota_id', $formZ->getObject()->getMotaId()); ?>
     <?php $form->setDefault ('azpimota_id', $formZ->getObject()->getAzpimotaId()); ?>
     <?php $form->setDefault ('barrutia_id', $formZ->getObject()->getBarrutiaId()); ?>     
     <?php $form->setDefault ('kalea_id', $formZ->getObject()->getKaleaId()); ?>
     <?php $form->setDefault ('kale_zbkia', $formZ->getObject()->getKaleZbkia()); ?>
     <?php $form->setDefault ('deskribapena', $formZ->getObject()->getDeskribapena()); ?>
     <?php $form->setDefault ('lehentasuna_id', $formZ->getObject()->getLehentasunaId()); ?>
     <?php $form->setDefault ('jatorrizkosaila_id', $formZ->getObject()->getJatorrizkosailaId()); ?>
     <?php $form->setDefault ('eraikina_id', $formZ->getObject()->getEraikinaId()); ?>
     <?php //echo $form['mota_id']->render();  ?>
    </thead>
    <tbody>
      <?php //echo $form ?>
      <tr>
	<th class="eskuin" valign=top>Laburpena:*</th>
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
            <input type="submit" value="Sortu" />
        </th>
     </tr>
     <tr><th colspan=5>
            <div id="izkutua_"  style="display:none">
                <?php echo $form['saila_id']->render();  ?>
	        <?php $form->setDefault ('langilea_id', $sf_user->getGuardUser()->getId()); ?>
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

