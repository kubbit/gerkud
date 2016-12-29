<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php $configEremuak = sfConfig::get('app_gerkud_eremuak'); ?>
<?php $configDerrigorrezkoak = sfConfig::get('app_gerkud_derrigorrezkoak'); ?>

<?php
	$formularioa_url = sprintf('gertakaria/%s%s', ($form->getObject()->isNew() ? 'create' : 'update'), (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : ''));
?>

<?php if($form->hasErrors() || $form->hasGlobalErrors()): ?>
<ul id="erroreak">
	<?php foreach($form->getGlobalErrors() as $name => $error): ?>
	<li><?php echo $name; ?>: <?php echo $error; ?></li>
	<?php endforeach; ?>

	<?php foreach($form->getErrorSchema()->getErrors() as $name => $error): ?>
		<?php if ($error instanceof sfValidatorErrorSchema): ?>
			<?php foreach($error->getErrors() as $subform_name => $subform_error): ?>
	<li title="<?php echo sprintf('%s_%s', $name, $subform_name); ?>"><?php echo __($subform_error); ?></li>
			<?php endforeach; ?>
		<?php else: ?>
	<li title="<?php echo $name; ?>"><?php echo __($error); ?></li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<form class="panela" action="<?php echo url_for($formularioa_url) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
	<fieldset>
		<legend>
<?php if (!$form->getObject()->isNew()): ?>
			<?php echo __('Gertakaria editatu') ?>
<?php else: ?>
			<?php echo __('Gertakari berria') ?>
<?php endif; ?>
		</legend>

		<fieldset>
<?php if (!$form->getObject()->isNew()): ?>
			<div id="id" class="field">
				<label><?php echo __('Kodea') ?>:</label>
				<span class="motza"><?php echo $form->getObject()->getId(); ?></span>
			</div>
			<div id="created_at" class="field">
	<?php if (sfConfig::get('app_sortze_data_automatikoa')): ?>
				<label><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo date(sfConfig::get('app_data_formatoa'), strtotime($form->getObject()->getCreatedAt())); ?>
	<?php else: ?>
				<label for="gertakaria_created_at"><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['created_at']->render(); ?>
	<?php endif; ?>
			</div>
<?php elseif (!sfConfig::get('app_sortze_data_automatikoa')): ?>
			<div id="created_at" class="field">
				<label for="gertakaria_created_at"><?php echo __('Irekiera data') ?>:<?php echo (in_array('created_at', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['created_at']->render(); ?>
			</div>
<?php endif; ?>
		</fieldset>

<?php if (in_array('laburpena', $configEremuak)): ?>
		<fieldset>
			<div id="laburpena" class="field">
				<label for="gertakaria_laburpena"><?php echo __('Laburpena') ?>:<?php echo (in_array('laburpena', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['laburpena']->render(array('autofocus' => 'autofocus', 'class' => 'luzea', 'rows' => 1)); ?>
			</div>
		</fieldset>
<?php endif; ?>

		<fieldset>
<?php if (in_array('mota', $configEremuak)): ?>
			<div id="mota_id" class="field">
				<label for="gertakaria_mota_id"><?php echo __('Mota') ?>:<?php echo (in_array('mota', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['mota_id']->render(); ?>
			</div>
	<?php if (in_array('azpimota', $configEremuak)): ?>
			<div id="azpimota_id" class="field">
				<label for="gertakaria_azpimota_id"><?php echo __('Azpimota') ?>:<?php echo (in_array('azpimota', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['azpimota_id']->render(); ?>
			</div>
	<?php endif; ?>
<?php endif; ?>
<?php if (in_array('klasea', $configEremuak)): ?>
			<div id="klasea_id" class="field">
				<label for="gertakaria_klasea_id"><?php echo __('Klasea') ?>:<?php echo (in_array('klasea', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['klasea_id']->render(); ?>
			</div>
<?php endif; ?>
		</fieldset>

<?php if (in_array('lehentasuna', $configEremuak)): ?>
		<fieldset>
			<div id="lehentasuna_id" class="field">
				<label for="gertakaria_lehentasuna_id"><?php echo __('Lehentasuna') ?>:<?php echo (in_array('lehentasuna', $configDerrigorrezkoak))?'*':'' ?></label>
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
				<label for="gertakaria_jatorrizkoSaila_id"><?php echo __('Jatorrizko Saila') ?>:<?php echo (in_array('jatorrizkosaila', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['jatorrizkoSaila_id']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('espedientea', $configEremuak)): ?>
			<div id="espedientea" class="field">
				<label for="gertakaria_espedientea"><?php echo __('Espedientea') ?>:<?php echo (in_array('espedientea', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['espedientea']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('abisuanork', $configEremuak) && !in_array('kontaktua_izena', $configEremuak)): ?>
			<div id="abisuaNork" class="field">
				<label for="gertakaria_abisuaNork"><?php echo __('Nork eman du abisua') ?>:<?php echo (in_array('abisuanork', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['abisuaNork']->render(array('class' => 'luzea', 'rows' => 1)); ?>
			</div>
<?php endif; ?>
		</fieldset>

		<fieldset>
<?php if (in_array('kontaktua_izena', $configEremuak)): ?>
			<div id="Kontaktua_izena" class="field">
				<label for="gertakaria_Kontaktua_izena"><?php echo __('Izena') ?>:<?php echo (in_array('kontaktua_izena', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['Kontaktua']['izena']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('kontaktua_abizenak', $configEremuak)): ?>
			<div id="Kontaktua_abizenak" class="field">
				<label for="gertakaria_Kontaktua_abizenak"><?php echo __('Abizenak') ?>:<?php echo (in_array('kontaktua_abizenak', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['Kontaktua']['abizenak']->render(array('class' => 'luzea', 'rows' => 1)); ?>
			</div>
<?php endif; ?>
<?php if (in_array('kontaktua_nan', $configEremuak)): ?>
			<div id="Kontaktua_nan" class="field">
				<label for="gertakaria_Kontaktua_nan"><?php echo __('NAN') ?>:<?php echo (in_array('kontaktua_nan', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['Kontaktua']['nan']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('kontaktua_posta', $configEremuak)): ?>
			<div id="Kontaktua_posta" class="field">
				<label for="gertakaria_Kontaktua_posta"><?php echo __('Posta-e') ?>:<?php echo (in_array('kontaktua_posta', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['Kontaktua']['posta']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('kontaktua_telefonoa', $configEremuak)): ?>
			<div id="Kontaktua_telefonoa" class="field">
				<label for="gertakaria_Kontaktua_telefonoa"><?php echo __('Telefonoa') ?>:<?php echo (in_array('kontaktua_telefonoa', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['Kontaktua']['telefonoa']->render(); ?>
			</div>
<?php endif; ?>
<?php if (in_array('kontaktua_ohartarazi', $configEremuak)): ?>
			<div id="Kontaktua_ohartarazi" class="field">
				<label for="gertakaria_Kontaktua_ohartarazi"><?php echo __('Ohartarazi') ?>:<?php echo (in_array('kontaktua_ohartarazi', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['Kontaktua']['ohartarazi']->render(); ?>
			</div>
<?php endif; ?>
		</fieldset>

<?php if (sfConfig::get('app_gerkud_aurreikusia_aldatu_edozein') || $sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
		<fieldset>
	<?php if (in_array('hasiera_aurreikusia', $configEremuak)): ?>
			<div id="hasiera_aurreikusia" class="field">
				<label for="gertakaria_hasiera_aurreikusia"><?php echo __('Hasiera aurreikusia') ?>:<?php echo (in_array('hasiera_aurreikusia', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['hasiera_aurreikusia']->render(); ?>
			</div>
	<?php endif; ?>
	<?php if (in_array('amaiera_aurreikusia', $configEremuak)): ?>
			<div id="amaiera_aurreikusia" class="field">
				<label for="gertakaria_amaiera_aurreikusia"><?php echo __('Amaiera aurreikusia') ?>:<?php echo (in_array('amaiera_aurreikusia', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['amaiera_aurreikusia']->render(); ?>
			</div>
	<?php endif; ?>
		</fieldset>
<?php endif; ?>

<?php if (in_array('deskribapena', $configEremuak)): ?>
		<fieldset>
			<div id="deskribapena" class="field">
				<label for="gertakaria_deskribapena"><?php echo __('Deskribapena') ?>:<?php echo (in_array('deskribapena', $configDerrigorrezkoak))?'*':'' ?></label>
				<?php echo $form['deskribapena']->render(array('class' => 'luzea')); ?>
			</div>
		</fieldset>
<?php endif; ?>
	</fieldset>

	<div>
		<a class="botoia" href="<?php echo url_for('gertakaria/index') ?>"><?php echo __('Ezeztatu') ?></a>
<?php if (!$form->getObject()->isNew()): ?>
		<?php $gertakaria = $form->getObject(); ?>
		<input type="submit" class="botoia" value="<?php echo __('Gorde') ?>" />
<?php else: ?>
		<input type="submit" class="botoia" value="<?php echo __('Sortu') ?>" />
<?php endif; ?>

<?php if ($form->getObject()->getSailaId()): ?>
		<input type="submit" class="botoia" name="gertakaria_itxi" value="<?php echo __('Gorde eta Itxi'); ?>" />
<?php endif; ?>
	</div>

	<div class="izkutua">
		<?php echo $form['saila_id']->render(); ?>

<?php if ($form->getObject()->isNew()): ?>
		<?php $form->setDefault('langilea_id', $sf_user->getGuardUser()->getId()); ?>
<?php endif; ?>

		<?php echo $form['langilea_id']->render(); ?>
		<?php echo $form['egoera_id']->render(); ?>
		<?php echo $form['ixte_data']->render(); ?>

<?php if ($form->isCSRFProtected()): ?>
		<?php echo $form['_csrf_token']->render(); ?>
<?php endif; ?>

	</div>
</form>

