<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php $configEremuak = sfConfig::get('gerkud_eremuak_gaituak'); ?>
<?php $configDerrigorrezkoak = sfConfig::get('gerkud_eremuak_derrigorrezkoak'); ?>

<?php if($form->hasErrors() || $form->hasGlobalErrors()): ?>
<ul id="erroreak">
	<?php foreach($form->getGlobalErrors() as $name => $error): ?>
	<li><?php echo $name; ?>: <?php echo $error; ?></li>
	<?php endforeach; ?>

	<?php foreach($form->getErrorSchema()->getErrors() as $name => $error): ?>
	<li title="<?php echo $name; ?>"><?php echo __($error); ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<form class="panela" action="<?php echo url_for('gertakaria/create'); ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

	<fieldset>
		<legend><?php echo __('Gertakari berria') ?></legend>

<?php
// Gertakari originalaren datuak kopiatu
$form->setDefault('laburpena', $formZ->getObject()->getLaburpena());
$form->setDefault('klasea_id', $formZ->getObject()->getKlaseaId());
$form->setDefault('mota_id', $formZ->getObject()->getMotaId());
$form->setDefault('azpimota_id', $formZ->getObject()->getAzpimotaId());
$form->setDefault('barrutia_id', $formZ->getObject()->getBarrutiaId());
$form->setDefault('auzoa_id', $formZ->getObject()->getAuzoaId());
$form->setDefault('kalea_id', $formZ->getObject()->getKaleaId());
$form->setDefault('kale_zbkia', $formZ->getObject()->getKaleZbkia());
$form->setDefault('deskribapena', $formZ->getObject()->getDeskribapena());
$form->setDefault('lehentasuna_id', $formZ->getObject()->getLehentasunaId());
$form->setDefault('jatorrizkoSaila_id', $formZ->getObject()->getJatorrizkosailaId());
$form->setDefault('eraikina_id', $formZ->getObject()->getEraikinaId());
// Gertakariaren eremu guztiak kopiatzeko
if (sfConfig::get('gerkud_kopia_zehatza'))
{
	$form->setDefault('created_at', $formZ->getObject()->getCreatedAt());
	$form->setDefault('abisuaNork', $formZ->getObject()->getAbisuanork());
	$form->setDefault('hasiera_aurreikusia', $formZ->getObject()->getHasieraAurreikusia());
	$form->setDefault('amaiera_aurreikusia', $formZ->getObject()->getAmaieraAurreikusia());
}
?>

<?php if (!sfConfig::get('gerkud_sortze_data_automatikoa')): ?>
		<fieldset>
			<div id="created_at" class="field">
				<label for="gertakaria_created_at"><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['created_at']->render(); ?>
			</div>
		</fieldset>
<?php endif; ?>
<?php if (in_array('laburpena', $configEremuak)): ?>
		<fieldset>
			<div id="laburpena" class="field">
				<label for="gertakaria_laburpena"><?php echo __('Laburpena') ?>:<?php echo (in_array('laburpena', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['laburpena']->render(array('autofocus' => 'autofocus', 'class' => 'luzea', 'rows' => 1)); ?>
			</div>
		</fieldset>
<?php endif; ?>

		<fieldset>
<?php if (in_array('mota', $configEremuak)): ?>
			<div id="mota_id" class="field">
				<label for="gertakaria_mota_id"><?php echo __('Mota') ?>:<?php echo (in_array('mota', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['mota_id']->render(); ?>
			</div>
	<?php if (in_array('azpimota', $configEremuak)): ?>
			<div id="azpimota_id" class="field">
				<label for="gertakaria_azpimota_id"><?php echo __('Azpimota') ?>:<?php echo (in_array('azpimota', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['azpimota_id']->render(); ?>
			</div>
	<?php endif; ?>
<?php endif; ?>
<?php if (in_array('klasea', $configEremuak)): ?>
			<div id="klasea_id" class="field">
				<label for="gertakaria_klasea_id"><?php echo __('Klasea') ?>:<?php echo (in_array('klasea', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['klasea_id']->render(); ?>
			</div>
<?php endif; ?>
		</fieldset>

<?php if (in_array('lehentasuna', $configEremuak)): ?>
		<fieldset>
			<div id="lehentasuna_id" class="field">
				<label for="gertakaria_lehentasuna_id"><?php echo __('Lehentasuna') ?>:<?php echo (in_array('lehentasuna', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['lehentasuna_id']->render(); ?>
			</div>
		</fieldset>
<?php endif; ?>

<?php if(count(array_intersect($configEremuak, array('barrutia', 'kalea', 'kale_zbkia', 'eraikina'))) > 0): ?>
		<fieldset class="azpiSailkapena">
			<label class="title"><?php echo __('Helbidea') ?>:</label>
	<?php if (in_array('barrutia', $configEremuak)): ?>
			<div id="barrutia_id" class="field">
				<label for="gertakaria_barrutia_id"><?php echo __('Barrutia'); ?>:<?php echo (in_array('barrutia', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['barrutia_id']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('auzoa', $configEremuak)): ?>
			<div id="auzoa_id" class="field">
				<label for="gertakaria_auzoa_id"><?php echo __('Auzoa'); ?>:<?php echo (in_array('auzoa', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['auzoa_id']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('kalea', $configEremuak)): ?>
			<div id="kalea_id" class="field">
				<label for="gertakaria_kalea_id"><?php echo __('Kalea'); ?>:<?php echo (in_array('kalea', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['kalea_id']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('kale_zbkia', $configEremuak)): ?>
			<div id="kale_zbkia" class="field">
				<label for="gertakaria_kale_zbkia"><?php echo __('Zbkia'); ?>:<?php echo (in_array('kale_zbkia', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['kale_zbkia']->render(array('class' => 'motza')); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('eraikina', $configEremuak)): ?>
			<div id="eraikina_id" class="field">
				<label for="gertakaria_eraikina_id"><?php echo __('Eraikina') ?>:<?php echo (in_array('eraikina', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['eraikina_id']->render(); ?>
			</div>
	<?php endif; ?>
		</fieldset>
<?php endif; ?>

		<fieldset>
<?php if (in_array('jatorrizkosaila', $configEremuak)): ?>
			<div id="jatorrizkoSaila_id" class="field">
				<label for="gertakaria_jatorrizkoSaila_id"><?php echo __('Jatorrizko Saila') ?>:<?php echo (in_array('jatorrizkosaila', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['jatorrizkoSaila_id']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('abisuanork', $configEremuak)): ?>
			<div id="abisuaNork" class="field">
				<label for="gertakaria_abisuaNork"><?php echo __('Nork eman du abisua') ?>:<?php echo (in_array('abisuanork', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['abisuaNork']->render(array('class' => 'luzea', 'rows' => 1)); ?>
			</div>
<?php endif; ?>
		</fieldset>

<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
		<fieldset>
	<?php if (in_array('hasiera_aurreikusia', $configEremuak)): ?>
			<div id="hasiera_aurreikusia" class="field">
				<label for="gertakaria_hasiera_aurreikusia"><?php echo __('Hasiera aurreikusia') ?>:<?php echo (in_array('hasiera_aurreikusia', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['hasiera_aurreikusia']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('amaiera_aurreikusia', $configEremuak)): ?>
			<div id="amaiera_aurreikusia" class="field">
				<label for="gertakaria_amaiera_aurreikusia"><?php echo __('Amaiera aurreikusia') ?>:<?php echo (in_array('amaiera_aurreikusia', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['amaiera_aurreikusia']->render(); ?>
			</div>
	<?php endif; ?>
		</fieldset>
<?php endif; ?>

<?php if (in_array('deskribapena', $configEremuak)): ?>
		<fieldset>
			<div id="deskribapena" class="field">
				<label for="gertakaria_deskribapena"><?php echo __('Deskribapena') ?>:<?php echo (in_array('deskribapena', $configDerrigorrezkoak))?'*':''?></label>
				<?php echo $form['deskribapena']->render(array('class' => 'luzea', 'rows' => 4)); ?>
			</div>
		</fieldset>
<?php endif; ?>
	</fieldset>

	<div>
		<a class="botoia" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Ezeztatu') ?></a>
		<input type="submit" class="botoia" value="<?php echo __('Sortu') ?>" />
	</div>

	<div class="izkutua">
		<?php echo $form['saila_id']->render(); ?>
		<?php $form->setDefault('langilea_id', $sf_user->getGuardUser()->getId()); ?>
		<?php echo $form['langilea_id']->render(); ?>
		<?php echo $form['egoera_id']->render(); ?>
		<?php echo $form['ixte_data']->render(); ?>
<?php if ($form->isCSRFProtected()) : ?>
		<?php echo $form['_csrf_token']->render(); ?>
<?php endif; ?>
	</div>
</form>