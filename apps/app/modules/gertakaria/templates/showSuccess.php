<?php use_helper('Javascript', 'GMap') ?>

<?php $lang = $sf_user->getGuardUser()->getId(); ?>
<?php use_helper('Debug') ?>

<?php log_message('Gertakaria....', 'info') ?>

<?php $configEremuak = sfConfig::get('gerkud_eremuak_gaituak'); ?>
<?php $ekintzak = sfConfig::get('gerkud_ezarpenak_ekintzak', array()); ?>

<ul id="orriak" class="orriak">
	<li id="tabgertakaria" title="gertakaria" class="<?php echo in_array(gertakariaActions::EKINTZA_GERTAKARIA, $ekintzak) ? '' : 'ezgaituta'; ?>"><i class="fa fa-id-card-o"></i><span><?php echo __('Gertakaria'); ?></span></li>
	<li id="tabhistorikoa" title="historikoa" class="<?php echo count($gertakaria->getIruzkinak()) > 0 && in_array(gertakariaActions::EKINTZA_HISTORIKOA, $ekintzak) ? '': 'ezgaituta'; ?>"><i class="fa fa-history"></i><span><?php echo __('Historikoa'); ?></span></li>
	<li id="tabiruzkina" title="iruzkina" class="<?php echo in_array(gertakariaActions::EKINTZA_IRUZKINA, $ekintzak) ? '' : 'ezgaituta'; ?>"><i class="fa fa-comment-o"></i><span><?php echo __('Iruzkina'); ?></span></li>
	<li id="tabfitxategiak" title="fitxategiak" class="<?php echo in_array(gertakariaActions::EKINTZA_FITXATEGIAK, $ekintzak) ? '' : 'ezgaituta'; ?>"><i class="fa fa-paperclip"></i><span><?php echo __('Fitxategiak') . sprintf(' (%d)', count($gertakaria->getFitxategiak())); ?></span></li>
	<li id="taberlazioak" title="erlazioak" class="<?php echo in_array(gertakariaActions::EKINTZA_BIKOIZTUAK, $ekintzak) ? '' : 'ezgaituta'; ?>"><i class="fa fa-chain"></i><span><?php echo __('Bikoiztuak'); ?></span></li>
	<li id="tabplanoa" title="planoa" class="<?php echo sfConfig::get('gerkud_mapa_aktibatuta') && in_array(gertakariaActions::EKINTZA_PLANOA, $ekintzak) ? '': 'ezgaituta'; ?>"><i class="fa fa-map-marker"></i><span><?php echo __('Planoa'); ?></span></li>
</ul>

<div id="edukgertakaria">
<?php if (in_array(gertakariaActions::EKINTZA_GERTAKARIA, $ekintzak)): ?>
	<div id="ekintzakIreki"></div>
	<div id="ekintzak">
		<div>
<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
	<?php if (($gertakaria->getEgoeraId() != 5) && ($gertakaria->getEgoeraId() != 6)): ?>
			<!-- Baztertu -->
		<?php if (in_array(gertakariaActions::EKINTZA_BAZTERTU, $ekintzak)): ?>
			<a class="botoia" href="<?php echo url_for('gertakaria/egoera?id=' . $gertakaria->getId() . '&eg_id=6') ?>"
			 onclick="return confirm('<?php echo __('Gertakaria baztertu nahi duzu?') ?>');">
				<i class="fa fa-remove"></i><?php echo __('Baztertu'); ?>
			</a>
		<?php endif; ?>

		<?php log_message('Panela....', 'info'); ?>

			<!-- Editatu -->
		<?php if (in_array(gertakariaActions::EKINTZA_EDITATU, $ekintzak)): ?>
			<a class="botoia" href="<?php echo url_for('gertakaria/edit?id=' . $gertakaria->getId()) ?>">
				<i class="fa fa-pencil"></i><?php echo __('Editatu'); ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

			<!-- Esleitu -->
<?php if (in_array(gertakariaActions::EKINTZA_ESLEITU, $ekintzak)): ?>
	<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false) || $sailakoa || ($sf_user->hasCredential('zerbitzu') && $gertakaria->getSaila() == "")): ?>
		<?php if (($gertakaria->getEgoeraId() != 5) && ($gertakaria->getEgoeraId() != 6)): ?>
			<?php $form2 = new IruzkinaForm(); ?>
			<?php $form2->setDefault('gertakaria_id', $gertakaria->getId()); ?>
			<?php $form2->setDefault('ekintza_id', 2); ?>
			<?php $form2->setDefault('langilea_id', $lang); ?>
			<form action="<?php echo url_for('iruzkina/create') ?>" method="post" <?php $form2->isMultipart() and print 'enctype="multipart/form-data" ' ?> >
				<div class="izkutua">
					<?php echo $form2['gertakaria_id']; ?>
					<?php echo $form2['ekintza_id']; ?>
					<?php echo $form2['langilea_id']; ?>
<?php if ($form2->isCSRFProtected()) : ?>
					<?php echo $form2['_csrf_token']->render(); ?>
<?php endif; ?>
				</div>
				<?php if ($gertakaria->getSailaId()) $form2->setDefault('saila_id', $gertakaria->getSailaId()); ?>
				<?php echo $form2['saila_id']->render(); ?>
				<button class="botoia" type="submit"><i class="fa fa-hand-o-right"></i><?php echo ($gertakaria->getEgoeraId() == 1) ? __('Gertakaria esleitu') : __('Berriz esleitu'); ?></button>
			</form>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

			<!-- Imprimatu -->
<?php if (in_array(gertakariaActions::EKINTZA_INPRIMATU, $ekintzak)): ?>
			<a class="botoia" target="_blank" href="<?php echo url_for('gertakaria/inprimatu?id=' . $gertakaria->getId()) ?>">
				<i class="fa fa-print"></i><?php echo __('Inprimatu'); ?>
			</a>
<?php endif; ?>

<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false) || $sailakoa): ?>
			<!-- Prozesuan jarri -->
	<?php if (in_array(gertakariaActions::EKINTZA_PROZESUAN_JARRI, $ekintzak)): ?>
		<?php if ($gertakaria->getEgoeraId() == 2 || $gertakaria->getEgoeraId() == 3): ?>
			<a class="botoia" href="<?php echo url_for('gertakaria/egoera?id=' . $gertakaria->getId() . '&eg_id=4') ?>">
				<i class="fa fa-wrench"></i><?php echo __('Prozesuan jarri'); ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>

			<!-- Itxi -->
	<?php if (in_array(gertakariaActions::EKINTZA_ITXI, $ekintzak)): ?>
		<?php if ($gertakaria->getEgoeraId() == 4): ?>
			<a class="botoia" href="<?php echo url_for('gertakaria/egoera?id=' . $gertakaria->getId() . '&eg_id=5') ?>">
				<i class="fa fa-check-square-o"></i><?php echo __('Itxi'); ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

			<!-- Gertakaria berrireki -->
<?php if ($sf_user->hasCredential(array('admins', 'gerkud', 'zerbitzu', 'arrunta'), false)): ?>
	<?php if (in_array(gertakariaActions::EKINTZA_BERRIREKI, $ekintzak)): ?>
		<?php if (($gertakaria->getEgoeraId() == 5) || ($gertakaria->getEgoeraId() == 6)): ?>
			<?php $form3 = new IruzkinaForm(); ?>
			<?php $form3->setDefault('gertakaria_id', $gertakaria->getId()); ?>
			<?php $form3->setDefault('ekintza_id', 3); ?>
			<?php $form3->setDefault('langilea_id', $lang); ?>
			<form action="<?php echo url_for('iruzkina/create') ?>" method="post" <?php $form3->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
				<div class="izkutua">
					<?php echo $form3['gertakaria_id']->render(array('id' => '')); ?>
					<?php echo $form3['ekintza_id']->render(array('id' => '')); ?>
					<?php echo $form3['langilea_id']->render(array('id' => '')); ?>

			<?php if ($form3->isCSRFProtected()) : ?>
					<?php echo $form3['_csrf_token']->render(); ?>
			<?php endif; ?>
				</div>
				<?php echo $form3['testua']->render(array('cols' => 18, 'rows' => 3)); ?>

				<button type="submit" class="botoia"><i class="fa fa-repeat"></i><?php echo __('Gertakaria berrireki'); ?></button>
			</form>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

			<!-- Gertakaria kopiatu -->
<?php if (in_array(gertakariaActions::EKINTZA_KOPIATU, $ekintzak)): ?>
			<a class="botoia" href="<?php echo url_for('gertakaria/kopiatu?id=' . $gertakaria->getId()) ?>">
				<i class="fa fa-copy"></i><?php echo __('Kopiatu'); ?>
			</a>
<?php endif; ?>
		</div>
	</div>

	<div class="panela">
		<fieldset>
			<fieldset>
				<div class="field">
					<label><?php echo __('Kodea'); ?>:</label>
					<span class="motza"><?php echo $gertakaria->getId(); ?></span>
				</div>
				<div class="field">
					<label><?php echo __('Irekiera data'); ?>:</label>
					<span><?php echo date(sfConfig::get('gerkud_data_formatoa'), strtotime($gertakaria->getCreatedAt())); ?></span>
				</div>
<?php if (($gertakaria->getEgoeraId() == 5) || ($gertakaria->getEgoeraId() == 6)): ?>
				<div class="field">
					<label><?php echo __('Ixte data'); ?>:</label>
					<span><?php echo date(sfConfig::get('gerkud_data_formatoa'), strtotime($gertakaria->getIxteData())); ?></span>
				</div>
<?php endif; ?>
			</fieldset>

			<fieldset>
				<div class="field">
					<label><?php echo __('Laburpena'); ?>:</label>
					<span class="luzea"><?php echo $gertakaria->getLaburpena(); ?></span>
				</div>
			</fieldset>

			<fieldset>
<?php if (in_array('mota', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Mota'); ?>:</label>
					<span><?php echo $gertakaria->getMota(); ?></span>
				</div>
<?php endif; ?>
<?php if (in_array('azpimota', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Azpimota'); ?>:</label>
					<span><?php echo $gertakaria->getAzpimota(); ?></span>
				</div>
<?php endif; ?>
<?php if (in_array('saila', $configEremuak) && $gertakaria->getEgoeraId() != 1 && $gertakaria->getSailaId()): ?>
				<div class="field">
					<label><?php echo __('Saila'); ?>:</label>
					<span><?php echo $gertakaria->getSaila(); ?></span>
				</div>
<?php endif; ?>
<?php if (in_array('klasea', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Klasea'); ?>:</label>
					<span><?php echo $gertakaria->getKlasea(); ?></span>
				</div>
<?php endif; ?>
<?php if (in_array('arloa', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Arloa'); ?>:</label>
					<span><?php echo $gertakaria->getArloa(); ?></span>
				</div>
<?php endif; ?>
			</fieldset>

			<fieldset>
<?php if (in_array('lehentasuna', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Lehentasuna'); ?>:</label>
					<span><?php echo $gertakaria->getLehentasuna(); ?></span>
				</div>
<?php endif; ?>
<?php if (in_array('egoera', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Egoera'); ?>:</label>
					<span><?php echo $gertakaria->getEgoera(); ?></span>
				</div>
<?php endif; ?>
			</fieldset>

			<fieldset>
<?php if(count(array_intersect($configEremuak, array('barrutia', 'auzoa', 'kalea', 'kale_zbkia', 'eraikina'))) > 0): ?>
				<div class="field">
					<label><?php echo __('Helbidea'); ?>:</label>
	<?php
		$helbidea = '';
		if ($gertakaria->getKalea_id())
			$helbidea .= sprintf('%s, %s', $gertakaria->getKalea(), $gertakaria->getKaleZbkia());
		if ($gertakaria->getBarrutia_id())
			$helbidea .= sprintf(' (%s)', $gertakaria->getBarrutia());
		if ($gertakaria->getAuzoa_id())
			$helbidea .= sprintf(' (%s)', $gertakaria->getAuzoa());
		if ($gertakaria->getEraikina_id())
			$helbidea .= sprintf('  -- %s --', $gertakaria->getEraikina());
	?>
					<span class="luzea"><?php echo $helbidea; ?></span>
				</div>
<?php endif; ?>
			</fieldset>

			<fieldset>
<?php if (in_array('langilea', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Erabiltzailea'); ?>:</label>
<?php if (sfConfig::get('gerkud_izena_eta_abizena')): ?>
					<span><?php echo $gertakaria->getLangilea(); ?></span>
<?php elseif ($gertakaria->getLangilea() != ''): ?>
					<span><?php echo sprintf('%s (%s %s)', $gertakaria->getLangilea(), $gertakaria->getLangilea()->getFirstName(), $gertakaria->getLangilea()->getLastName()); ?></span>
<?php else: ?>
					<span></span>
<?php endif; ?>
				</div>
<?php endif; ?>
<?php if (in_array('jatorrizkosaila', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Jatorrizko Saila'); ?>:</label>
					<span><?php echo $gertakaria->getJatorrizkoSaila(); ?></span>
				</div>
<?php endif; ?>
<?php if (in_array('abisuanork', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Abisua nork'); ?>:</label>
					<span class="luzea"><?php echo $gertakaria->getAbisuaNork(); ?></span>
				</div>
<?php endif; ?>
			</fieldset>

<?php if (in_array('kontaktua_izena', $configEremuak)): ?>
<?php
$kontaktua = $gertakaria->getKontaktua();
?>
			<fieldset>
				<div class="field">
					<label><?php echo __('Abisua nork'); ?>:</label>
					<span><?php echo sprintf('%s %s', $kontaktua->getIzena(), $kontaktua->getAbizenak()); ?></span>
<?php if (in_array('kontaktua_nan', $configEremuak)): ?>
					<label><?php echo __('NAN'); ?>:</label>
					<span><?php echo $kontaktua->getNAN(); ?></span>
<?php endif; ?>
				</div>
				<div class="field">
<?php if (in_array('kontaktua_posta', $configEremuak)): ?>
					<label><?php echo __('Posta-e'); ?>:</label>
					<span><?php echo $kontaktua->getPosta(); ?></span>
<?php endif; ?>
<?php if (in_array('kontaktua_telefonoa', $configEremuak)): ?>
					<label><?php echo __('Telefonoa'); ?>:</label>
					<span><?php echo $kontaktua->getTelefonoa(); ?></span>
<?php endif; ?>
				</div>
<?php if (in_array('kontaktua_ohartarazi', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Ohartarazi'); ?>:</label>
					<span><?php echo $kontaktua->getKontaktuaOhartaraztea(); ?></span>
				</div>
<?php endif; ?>
			</fieldset>
<?php endif; ?>

<?php if (in_array('espedientea', $configEremuak)): ?>
			<fieldset>
				<div class="field">
					<label><?php echo __('Espedientea'); ?>:</label>
					<span><?php echo $gertakaria->getEspedientea(); ?></span>
				</div>
			</fieldset>
<?php endif; ?>

			<fieldset>
<?php if (in_array('hasiera_aurreikusia', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Hasiera aurreikusia'); ?>:</label>
					<span><?php echo $gertakaria->getHasieraAurreikusia(); ?></span>
				</div>
<?php endif; ?>
<?php if (in_array('amaiera_aurreikusia', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Amaiera aurreikusia'); ?>:</label>
					<span><?php echo $gertakaria->getAmaieraAurreikusia(); ?></span>
				</div>
<?php endif; ?>
			</fieldset>

			<fieldset>
<?php if (in_array('deskribapena', $configEremuak)): ?>
				<div class="field">
					<label><?php echo __('Deskribapena'); ?>:</label>
					<span class="luzea"><?php echo $gertakaria->getDeskribapena(); ?></span>
				</div>
<?php endif; ?>
			</fieldset>
		</fieldset>
	</div>
<?php endif; ?>
</div>



<!-- Erlazioak -->
<?php log_message('Erlazioak....', 'info'); ?>
<div id="edukerlazioak" class="<?php echo in_array(gertakariaActions::EKINTZA_BIKOIZTUAK, $ekintzak) ? 'panela' : ''; ?>">
<?php if (in_array(gertakariaActions::EKINTZA_BIKOIZTUAK, $ekintzak)): ?>
	<fieldset>
		<legend><?php echo __('Bikoiztuak'); ?></legend>
	<?php if (count($erlazioak) > 0): ?>
		<ul>
		<?php foreach ($erlazioak as $bakoitza): ?>
			<li><a href="<?php echo url_for('gertakaria/show?id=' . $bakoitza) ?>"><?php echo $bakoitza ?></a></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if ($sf_user->hasCredential(array('admins', 'gerkud', 'zerbitzu'), false) && $gertakaria->getEgoeraId() <> "6"): ?>
		<?php
			$form4 = new ErlazioakForm();
			$form4->setDefault('hasiera_id', $gertakaria->getId());
			$form4->setDefault('erlazio_mota_id', 1);
			$form4->setDefault('ekintza_id', 1);
		?>
		<form action="<?php echo url_for('erlazioak/create'); ?>" method="post">
			<div class="izkutua">
				<input type="hidden" name="erlazioak[langilea_id]" value="<?php echo $lang; ?>" />
				<?php echo $form4['hasiera_id']->render(array('id' => '')); ?>
				<?php echo $form4['erlazio_mota_id']->render(array('id' => '')); ?>
				<?php echo $form4['ekintza_id']->render(array('id' => '')); ?>
		<?php if ($form4->isCSRFProtected()): ?>
				<?php echo $form4['_csrf_token']->render(); ?>
		<?php endif; ?>
			</div>

			<fieldset>
				<div class="field">
					<label class="luzea"><?php echo __('Hurrengo gertakariaren bikoitza bezala baztertu'); ?>:</label>
					<?php echo $form4['amaiera_id']->render(array('id' => '', 'autofocus' => 'autofocus')); ?>
				</div>
			</fieldset>

			<input type="submit" class="botoia" value="<?php echo __('Baztertu'); ?>" />
		</form>
	<?php endif; ?>
	</fieldset>
<?php endif; ?>
</div>



<!-- Historikoa  -->
<?php log_message('Historikoa....', 'info') ?>
<div id="edukhistorikoa">
<?php if (count($gertakaria->getIruzkinak()) > 0 && in_array(gertakariaActions::EKINTZA_HISTORIKOA, $ekintzak)): ?>
	<table>
		<caption><?php echo __('Aldaketen historikoa') ?></caption>
		<thead>
			<tr>
				<th><?php echo __('Data') ?></th>
				<th><?php echo __('Nork') ?></th>
				<th><?php echo __('Ekintza') ?></th>
				<th><?php echo __('Iruzkina') ?></th>
			</tr>
		</thead>
		<tbody>
	<?php foreach ($gertakaria->getIruzkinak() as $i => $iruzkina): ?>
			<tr>
				<td title="<?php echo __('Data'); ?>"><?php echo date(sfConfig::get('gerkud_data_formatoa'), strtotime($iruzkina->getCreated_at())); ?></td>
				<td title="<?php echo __('Nork'); ?>"><?php echo $iruzkina->getLangilea(); ?></td>
				<td title="<?php echo __('Ekintza'); ?>"><?php echo $iruzkina->getEkintza(); ?></td>
				<td title="<?php echo __('Iruzkina'); ?>"><?php echo $iruzkina->getTestua(); ?></td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
</div>



<!-- Iruzkina -->
<div id="edukiruzkina">
<?php if (in_array(gertakariaActions::EKINTZA_IRUZKINA, $ekintzak)): ?>
<?php
	$form = new IruzkinaForm();
	$form->setDefault('gertakaria_id', $gertakaria->getId());
	$form->setDefault('ekintza_id', 1);
	$form->setDefault('langilea_id', $lang);
?>
	<form class="iruzkinak" action="<?php echo url_for('iruzkina/create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<fieldset>
			<legend><?php echo __('Iruzkina gehitu') ?>:</legend>

			<div class="izkutua">
				<?php echo $form['gertakaria_id']->render(array('id' => '')); ?>
				<?php echo $form['ekintza_id']->render(array('id' => '')); ?>
				<?php echo $form['langilea_id']->render(array('id' => '')); ?>

	<?php if ($form->isCSRFProtected()): ?>
				<?php echo $form['_csrf_token']->render(); ?>
	<?php endif; ?>
			</div>

			<div class="field">
				<?php echo $form['testua']->render(array('autofocus' => 'autofocus')); ?>
			</div>
		</fieldset>

		<input type="submit" class="botoia" value="<?php echo __('Gehitu') ?>" />
	</form>
<?php endif; ?>
</div>



<!-- Fitxategiak:  -->
<?php log_message('Fitxategiak....', 'info'); ?>
<div id="edukfitxategiak" class="<?php echo in_array(gertakariaActions::EKINTZA_FITXATEGIAK, $ekintzak) ? 'panela' : ''; ?>">
<?php if (in_array(gertakariaActions::EKINTZA_FITXATEGIAK, $ekintzak)): ?>
	<fieldset>
		<legend><?php echo __('Fitxategiak'); ?></legend>
	<?php if (count($gertakaria->getFitxategiak()) > 0): ?>
		<ul>
		<?php foreach ($gertakaria->getFitxategiak() as $i => $fitxategia): ?>
			<li>
				<a href="<?php echo sprintf('/%s/FILES/%s/%s', sfConfig::get('sf_upload_dir_name'), $gertakaria->getId(), rawurlencode($fitxategia->getFitxategia())); ?>" target="_blank">
					<?php echo $fitxategia->getDeskribapena() . " (" . $fitxategia->getFitxategia() . ")"; ?>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>

		<?php $form = new FitxategiaForm(); ?>
		<?php $form->setDefault('gertakaria_id', $gertakaria->getId()); ?>
		<?php $form->setDefault('langilea_id', $lang); ?>
		<form action="<?php echo url_for('fitxategia/create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
			<div class="izkutua">
				<?php echo $form['gertakaria_id']->render(array('id' => '')); ?>
				<?php echo $form['langilea_id']->render(array('id' => '')); ?>
	<?php if ($form->isCSRFProtected()): ?>
				<?php echo $form['_csrf_token']->render(); ?>
	<?php endif; ?>
			</div>

			<fieldset>
				<div class="field">
					<label><?php echo __('Fitxategia'); ?>:</label>
					<?php echo $form['fitxategia2']->render(array('class' => 'luzea')); ?>
				</div>
			</fieldset>
			<fieldset>
				<div class="field">
					<label><?php echo __('Deskribapena'); ?>:</label>
					<?php echo $form['deskribapena']->render(array('class' => 'luzea', 'autofocus' => 'autofocus')); ?>
				</div>
			</fieldset>

			<input type="submit" class="botoia" value="<?php echo __('Gehitu'); ?>" />
		</form>
	</fieldset>
<?php endif; ?>
</div>



<!-- Planoak: -->
<div id="edukplanoa">
<?php if (sfConfig::get('gerkud_mapa_aktibatuta') && in_array(gertakariaActions::EKINTZA_BIKOIZTUAK, $ekintzak)): ?>
	<?php log_message('Planoak....', 'info'); ?>
	<div class="mapa">
<?php
	$herria = sfConfig::get('gerkud_mapa_helbidea');

	$gMap = new GMap();
	$gMap->setParameter('onload_method', 'none');
	$gMap->setZoom(15);
	$gMap->setScroll('false');
	$coord = $gMap->geocodeXml($herria);
	$gMap->setCenter($coord->getLat(), $coord->getLng());
	$gMap->setHeight('100%');
	$gMap->setWidth('100%');
	$k = 0;

	$info_window = new GMapInfoWindow('', array());

	foreach ($gertakaria->getKoordenadak() as $i => $puntua)
	{
		$test = "'" . $puntua->getTestua() . "'";
		$ikonoa = sprintf('\'https://chart.googleapis.com/chart?chst=%s&chld=edge_bc|%s|%s\'', 'd_bubble_text_small_withshadow', urlencode($puntua->getTestua()), 'C6EF8C', '000000');
		$gMapMarker = new GMapMarker($puntua->getLatitudea(), $puntua->getLongitudea(), array('title ' => $test, 'icon ' => $ikonoa), 'marker' . $k);

		//gertakarian informazio leihoa
		if ($sf_user->hasCredential(array('admins', 'gerkud'), false))
			$infoHTML = sprintf('<div class="infoWindow"><span>%s</span> <a class="botoia" href="%s">%s</a></div>', $puntua->getTestua(), url_for('geo/delete?id=' . $puntua->getId()), __('Ezabatu'));
		else
			$infoHTML = sprintf('<div class="infoWindow"><pre>%s</pre></div>', $puntua->getTestua());
		$gMapMarker->setCustomProperty('infoEdukia', $infoHTML);
		$gMapMarker->addHtmlInfoWindow($info_window);

		$gMap->addMarker($gMapMarker);
		$k++;
	}

	if ($gertakaria->getKalea_id())
	{
		$kale = Doctrine_Core::getTable('Kalea')->find($gertakaria->getKaleaId());

		$helbidea = sprintf('%s, %s %s', $kale->getGoogle(), $gertakaria->getKale_zbkia(), $herria);

		$puntua = $gMap->geocodeXml($helbidea);
		$gMapMarker = new GMapMarker($puntua->getLat(), $puntua->getLng());

		//gertakarian informazio leihoa
		$infoHTML = sprintf('<div class="infoWindow">'
		 . '	<strong>%s</strong>: %d<br />'
		 . '	<strong>%s</strong>: %s<br />'
		 . '	<strong>%s</strong>: <pre>%s</pre>'
		 . '</div>',
		 __('ID'), $gertakaria->getId(),
		 __('Laburpena'), $gertakaria->getLaburpena(),
		 __('Deskribapena'), str_replace(array("\r", "\n"), "", $gertakaria->getDeskribapena()));
		$gMapMarker->setCustomProperty('infoEdukia', $infoHTML);
		$gMapMarker->addHtmlInfoWindow($info_window);

		$gMap->addMarker($gMapMarker);
		$k++;
	}

	if ($gertakaria->getEraikinaId() != null)
	{
		$eraikina = $gertakaria->getEraikina();
		$ikonoa = sprintf('\'https://chart.googleapis.com/chart?chst=%s&chld=%s|%s\'', 'd_map_pin_icon_withshadow', 'home', '99ffff');
		$gMapMarker = new GMapMarker($eraikina->getLatitudea(), $eraikina->getLongitudea(), array('title' => "'" . $eraikina->getIzena() . "'", 'icon ' => $ikonoa));
		$gMap->addMarker($gMapMarker);
		$k++;
	}

	if ($k != 0)
		$gMap->centerOnMarkers();

	// Koordenatuak
	$mapEvt = new GMapEvent('click', 'function(event){click_coord(event);}', false);
	$gMap->addEvent($mapEvt);

	include_map($gMap);
?>
	</div>
	<?php $form = new GeoForm(); ?>
	<script type='text/javascript'>
<?php
/*
 * Puntuak gehitzeko formularioa (Google Maps-eko InfoWindow baten bidez)
 * Javascript-en bidez kargatzen da puntu berri bat markatzean
 */
$puntuBerriaForm = sprintf('<form class="infoWindow" action="%s" method="post">', url_for('geo/create'));
$puntuBerriaForm .= sprintf('	<input type="hidden" name="geo[gertakaria_id]" value="%s" />', $gertakaria->getId());
$puntuBerriaForm .= sprintf('	<input type="hidden" name="geo[geometria_id]" value="%d" />', 1);

if ($form->isCSRFProtected())
	$puntuBerriaForm .= $form['_csrf_token']->render();

$puntuBerriaForm .= '	<input type="hidden" id="geo_latitudea" name="geo[latitudea]" value="<latitudea>" />';
$puntuBerriaForm .= '	<input type="hidden" id="geo_longitudea" name="geo[longitudea]" value="<longitudea>" />';
$puntuBerriaForm .= $form['testua']->render(array('autofocus' => 'autofocus'));
$puntuBerriaForm .= sprintf('	<input class="botoia" type="submit" value="%s" />', __('Gehitu'));
$puntuBerriaForm .= '</form>';
?>
var puntuBerriaForm = '<?php echo $puntuBerriaForm; ?>';
	</script>
</div>

<!-- Javascript included at the bottom of the page -->
<?php include_map_javascript($gMap); ?>

<?php endif; ?>
