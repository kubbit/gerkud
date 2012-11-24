<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('langilea/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>



<br><br><br>
  <table class="formularioa" style="width:60%">
    <thead>
        <tr><th class="ezker" colspan=3><h3><?php echo __('Nere datuak aldatu')?></h3></th>
    </thead>
    <tbody>
      <?php //echo $form ?>
<!--	<tr><th class="ezker" colspan=3>Nere datuak aldatu</th>  -->
	<tr><th class="eskuin"><br></th><td class="ezker"><br></td><th rowspan=5 class="panela">
          <a class="boton" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Itzuli gertakarien zerrendara')?></a><br><br>
          <input type="submit" value="<?php echo __('Gorde')?>" /><br>
	</th></tr>
		<?php //echo $form['username']->render(array('readonly'=>'readonly'));?>
        <tr><th class="eskuin"><?php echo __('Erabiltzailea')?>:</th><td class="ezker">
		<?php echo $form['username']->render(array('readonly'=>'readonly','size'=>30));  ?>
	</td></tr>
        <tr><th class="eskuin"><?php echo __('Izena')?>:</th><td class="ezker"><?php echo $form['first_name']->render(array('size'=>30)) ?></td></tr>
        <tr><th class="eskuin"><?php echo __('Abizena(k)')?>:</th><td class="ezker"><?php echo $form['last_name']->render(array('size'=>30)) ?></td></tr>
        <tr><th class="eskuin"><?php echo __('Posta elektronikoa')?>:</th><td class="ezker"><?php echo $form['email_address']->render(array('size'=>30)) ?></td></tr>
        <tr><th class="eskuin"><?php echo __('Ohartarazi')?>:</th><td class="ezker"><?php echo $form['ohartaraztea_id']->render() ?></td></tr>
        <tr><th colspan=3><br>
            <div id="izkutua"  style="display:none">
                <?php echo $form['id']->render();  ?>
                <?php echo $form['username']->render() ?>
                <?php echo $form['algorithm']->render() ?>
                <?php echo $form['salt']->render() ?>
                <?php echo $form['password']->render();  ?>
                <?php echo $form['is_active']->render() ?>
                <?php echo $form['is_super_admin']->render() ?>
                <?php echo $form['last_login']->render() ?>
                <?php echo $form['created_at']->render();  ?>
                <?php echo $form['updated_at']->render(); ?>

                <?php echo $form['groups_list']->render() ?>
            </div>
	</th></tr>


    </tbody>
  </table>
</form>
