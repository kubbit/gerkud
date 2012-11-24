<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('iruzkina/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="Gorde" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php //echo $form ?>
        <div id="izkutua"  style="display:block">
	<tr><td>
                <?php echo $form['gertakaria_id']->render();  ?>
                <?php echo $form['ekintza_id']->render();  ?>
                <?php echo $form['sf_guard_user_id']->render();  ?>
        </div>
	</td></tr>
	<tr>
      <?php if ($form->getDefault('ekintza_id')!=2): ?>
	<th>Idatzi iruzkina:</th></tr>
	<tr><td><?php echo $form['testua']->render();  ?></td></tr>
      <?php else: ?>
        <th>Aukeratu zein sailari esleitzen zaion:</th></tr>
        <tr><td><?php echo $form['saila_id']->render();  ?></td></tr>
      <?php endif; ?>

      <?php if ($form->isCSRFProtected()) : ?>
          <?php echo $form['_csrf_token']->render(); ?>
      <?php endif; ?>


    </tbody>
  </table>
</form>

