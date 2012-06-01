<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<br><br>


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
        <tr><th colspan=6 valign=top class="ezker">Gertakaria editatu<br><br></th></tr>
      <?php else: ?>
        <tr><th colspan=6 valign=top class="ezker">Gertakari berria<br><br></th></tr>
      <?php endif; ?>

    </thead>
    <tbody>
      <?php //echo $form ?>
      <?php if (!$form->getObject()->isNew()): ?>
      <tr>
        <th class="eskuin">Kodea:</th><td class="txuria"><?php echo $form->getObject()->getId();?></td>
        <th>Sortze Data:</th><td align=right class="txuria"> <?php echo $form->getObject()->getCreatedAt();?></td>
<th></th>
</tr>
      <?php endif; ?>
      <tr>
	<th class="eskuin">Laburpena:*</th>
<!--	<td colspan=5><?php echo $form['laburpena']->render(array('size'=>58)); ?></td>-->
        <td colspan="5"><?php echo $form['laburpena']->render(array('cols'=>54,'rows'=>1)); ?></td>
      </tr>
      <tr><th class="eskuin">Mota:*</th><td><?php echo $form['mota_id']->render()."</td>"; ?></td>
          <th class="eskuin">Azpimota:*</th><td align=left><?php echo $form['azpimota_id']->render(); ?></td>
      </tr>
      <tr><th class="eskuin">Helbidea:</th>
	  <td colspan=3><?php echo $form['barrutia_id']->render()." ".$form['kalea_id']->render()."".$form['kale_zbkia']->render(array('size'=>3))  ?></td>
      </tr><tr>
          <th class="eskuin" nowrap>Eraikina:</th>
          <td colspan="5"><?php echo $form['eraikina_id']->render();?></td>
      </tr><tr>
        <th colspan=1 class=eskuin valign=top>Nork eman du abisua:</th>
        <td colspan=2 valign=top><?php echo $form['abisuaNork']->render(array('cols'=>24,'rows'=>1)); ?></td>
      </tr><tr>
        <th class="eskuin" colspan=1 valign=top>Harremanetarako:</th>
        <td colspan=2 valign=top><?php echo $form['harremanetarako']->render(array('cols'=>24,'rows'=>1)); ?></td>
      </tr>

      <tr>
        <th class="eskuin" valign=top>Deskribapena:*</th>
        <td colspan=4><?php echo $form['deskribapena']->render(array('cols'=>54,'rows'=>6)); ?></td>
     </tr>
	<th class=panela colspan=6>
		<a class="boton" href="<?php echo url_for('gertakaria/index') ?>">Ezeztatu</a>
	        <?php if (!$form->getObject()->isNew()): ?>
        	        <?php $gertakaria=$form->getObject(); ?>
                	<input type="submit" value="Gorde" />
	        <?php else: ?>
        	        <input type="submit" value="Sortu" />
	        <?php endif; ?>
	</th>
     </th>

     <tr><th colspan=5>
            <div id="izkutua"  style="display:none">
                <?php echo $form['saila_id']->render();  ?>
                <?php $form->setDefault ('langilea_id', $sf_user->getGuardUser()->getId()); ?>
                <?php echo $form['langilea_id']->render();  ?>
                <?php $form->setDefault ('lehentasuna_id', 1); ?>
                <?php echo $form['jatorrizkoSaila_id']->render();  ?>
                <?php echo $form['klasea_id']->render();  ?>
                <?php echo $form['lehentasuna_id']->render();  ?>
                <?php echo $form['egoera_id']->render();  ?>
                <?php echo $form['ixte_data']->render(); ?>
            </div>
     </th></tr>


        <?php if ($form->isCSRFProtected()) : ?>
          <?php echo $form['_csrf_token']->render(); ?>
        <?php endif; ?>
    </tbody>
  </table>


</form>

