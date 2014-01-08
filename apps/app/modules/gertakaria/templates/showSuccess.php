<?php use_helper('Javascript', 'GMap') ?>

<?php $lang = $sf_user->getGuardUser()->getId(); ?>
<?php use_helper('Debug') ?>

<?php log_message('Gertakaria....', 'info') ?>

<?php $configEremuak = sfConfig::get('app_gerkud_eremuak'); ?>

<div class="gertakaria">
	<div class="taulaGoiburua"><?php echo $gertakaria->getLaburpena() ?></div>
	<div class="botoiak">
<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
	<?php if (($gertakaria->getEgoeraId() != 5) && ($gertakaria->getEgoeraId() != 6)): ?>
		<!-- Baztertu -->
		<a class="boton" href="<?php echo url_for('gertakaria/egoera?id=' . $gertakaria->getId() . '&eg_id=6') ?>"
		 onclick="return confirm('<?php echo __('Gertakaria baztertu nahi duzu?') ?>');">
			<?php echo __('Baztertu') ?>
		</a>

		<?php log_message('Panela....', 'info'); ?>

		<!-- Editatu -->
		<a class="boton" href="<?php echo url_for('gertakaria/edit?id=' . $gertakaria->getId()) ?>">
			<?php echo __('Editatu') ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

		<!-- Esleitu -->
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
			<input type="submit" value="<?php echo ($gertakaria->getEgoeraId() == 1) ? __('Gertakaria esleitu') : __('Berriz esleitu')?>" />
		</form>
	<?php endif; ?>
<?php endif; ?>

		<!-- Imprimatu -->
		<a class="boton" target="_blank" href="<?php echo url_for('gertakaria/inprimatu?id=' . $gertakaria->getId()) ?>">
			<?php echo __('Inprimatu') ?>
		</a>

<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false) || $sailakoa): ?>
		<!-- Prozesuan jarri -->
	<?php if ($gertakaria->getEgoeraId() == 2 || $gertakaria->getEgoeraId() == 3): ?>
		<a class="boton" href="<?php echo url_for('gertakaria/egoera?id=' . $gertakaria->getId() . '&eg_id=4') ?>">
			<?php echo __('Prozesuan jarri') ?>
		</a>
	<?php endif; ?>

		<!-- Itxi -->
	<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false) || $sailakoa): ?>
		<?php if ($gertakaria->getEgoeraId() == 4): ?>
		<a class="boton" href="<?php echo url_for('gertakaria/egoera?id=' . $gertakaria->getId() . '&eg_id=5') ?>">
			<?php echo __('Itxi') ?>
		</a>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

		<!-- Gertakaria berrireki -->
<?php if ($sf_user->hasCredential(array('admins', 'gerkud', 'zerbitzu', 'arrunta'), false)): ?>
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

			<input type="submit" value="<?php echo __('Gertakaria berrireki') ?>" />
		</form>
	<?php endif; ?>
<?php endif; ?>

		<!-- Gertakaria kopiatu -->
		<a class="boton" href="<?php echo url_for('gertakaria/kopiatu?id=' . $gertakaria->getId()) ?>">
			<?php echo __('Kopiatu') ?>
		</a>
	</div>

	<div class="detailea">
		<div>
			<div><?php echo __('Kodea') ?>:</div>
			<span><?php echo $gertakaria->getId() ?></span>
		</div>
<?php if (in_array('lehentasuna', $configEremuak)): ?>
		<div>
			<div><?php echo __('Lehentasuna') ?>:</div>
			<span><?php echo $gertakaria->getLehentasuna() ?>&nbsp;</span>
		</div>
<?php endif; ?>
<?php if (in_array('mota', $configEremuak)): ?>
		<div>
			<div><?php echo __('Mota/Azpimota') ?>:</div>
			<span><?php echo sprintf('%s%s', $gertakaria->getMota(), $gertakaria->getAzpimotaId() == null ? '' : '/' . $gertakaria->getAzpimota()); ?>&nbsp;</span>
		</div>
<?php endif; ?>
		<div>
			<div><?php echo __('Irekiera data') ?>:</div>
			<span>
				<?php echo date(sfConfig::get('app_data_formatoa'), strtotime($gertakaria->getCreatedAt())) ?>
<?php if (($gertakaria->getEgoeraId() == 5) || ($gertakaria->getEgoeraId() == 6)): ?>
				<?php echo date(sfConfig::get('app_data_formatoa'), strtotime($gertakaria->getIxteData())) ?>
<?php endif; ?>
			&nbsp;</span>
		</div>
<?php if (in_array('egoera', $configEremuak)): ?>
		<div>
			<div><?php echo __('Egoera') ?>:</div>
			<span><?php echo $gertakaria->getEgoera() ?>&nbsp;</span>
		</div>
<?php endif; ?>
<?php if (in_array('saila', $configEremuak)): ?>
		<div>
			<div><?php echo __('Saila') ?>:</div>
			<span>
	<?php if (($gertakaria->getEgoeraId() != 1) && ($gertakaria->getSailaId())): ?>
			<?php echo $gertakaria->getSaila() ?>
	<?php endif; ?>
			&nbsp;</span>
		</div>
<?php endif; ?>
<?php if (in_array('langilea', $configEremuak)): ?>
		<div>
			<div><?php echo __('Erabiltzailea') ?>:</div>
			<span><?php echo $gertakaria->getLangilea() ?>&nbsp;</span>
		</div>
<?php endif; ?>
<?php if (in_array('abisuanork', $configEremuak)): ?>
		<div>
			<div><?php echo __('Abisua nork') ?>:</div>
			<span><?php echo $gertakaria->getAbisuaNork() ?>&nbsp;</span>
		</div>
<?php endif; ?>
<?php if (in_array('hasiera_aurreikusia', $configEremuak)): ?>
		<div>
			<div><?php echo __('Hasiera aurreikusia') ?>:</div>
			<span><?php echo $gertakaria->getHasieraAurreikusia() ?>&nbsp;</span>
		</div>
<?php endif; ?>
<?php if (in_array('amaiera_aurreikusia', $configEremuak)): ?>
		<div>
			<div><?php echo __('Amaiera aurreikusia') ?>:</div>
			<span><?php echo $gertakaria->getAmaieraAurreikusia() ?>&nbsp;</span>
		</div>
<?php endif; ?>
<?php if(count(array_intersect($configEremuak, array('barrutia', 'auzoa', 'kalea', 'kale_zbkia', 'eraikina'))) > 0): ?>
		<div class="luzea">
			<div><?php echo __('Helbidea') ?>:</div>
			<span>
	<?php
		if ($gertakaria->getKalea_id())
			echo sprintf('%s, %s', $gertakaria->getKalea(), $gertakaria->getKaleZbkia());
		if ($gertakaria->getBarrutia_id())
			echo sprintf(' (%s)', $gertakaria->getBarrutia());
		if ($gertakaria->getAuzoa_id())
			echo sprintf(' (%s)', $gertakaria->getAuzoa());
		if ($gertakaria->getEraikina_id())
			echo sprintf('  -- %s --', $gertakaria->getEraikina());
	?>
			&nbsp;</span>
		</div>
<?php endif; ?>
<?php if (in_array('deskribapena', $configEremuak)): ?>
		<div class="luzea">
			<div><?php echo __('Deskribapena') ?>:</div>
			<span><?php echo htmlspecialchars($gertakaria->getDeskribapena(), ENT_QUOTES, "utf-8"); ?>&nbsp;</span>
		</div>
<?php endif; ?>
	</div>
</div>

<!-- Erlazioak -->
<?php log_message('Erlazioak....', 'info'); ?>
<div class="gertakaria erlazioak">
	<div class="taulaGoiburua"><?php echo __('Bikoiztuak') ?></div>
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
	<form action="<?php echo url_for('erlazioak/create') ?>" method="post">
		<div class="izkutua">
			<input type="hidden" name="erlazioak[langilea_id]" value="<?php echo $lang; ?>" />
			<?php echo $form4['hasiera_id']->render(array('id' => '')); ?>
			<?php echo $form4['erlazio_mota_id']->render(array('id' => '')); ?>
			<?php echo $form4['ekintza_id']->render(array('id' => '')); ?>
	<?php if ($form4->isCSRFProtected()) : ?>
			<?php echo $form4['_csrf_token']->render(); ?>
	<?php endif; ?>
		</div>
		<?php echo __('Hurrengo gertakariaren bikoitza bezala baztertu:'); ?>
		<?php echo $form4['amaiera_id']->render(array('id' => '')); ?>
		<input type="submit" value="<?php echo __('Baztertu') ?>" />
	</form>
<?php endif; ?>
</div>

<!-- Historikoa  -->
<?php log_message('Historikoa....', 'info') ?>
<div class="gertakaria">
<?php if (count($gertakaria->getIruzkinak()) > 0): ?>
	<table>
		<caption class="taulaGoiburua"><?php echo __('Aldaketen historikoa') ?></caption>
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
				<td><?php echo date(sfConfig::get('app_data_formatoa'), strtotime($iruzkina->getCreated_at())); ?></td>
				<td><?php echo $iruzkina->getLangilea(); ?></td>
				<td><?php echo $iruzkina->getEkintza(); ?></td>
				<td><?php echo $iruzkina->getTestua(); ?></td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<?php
	$form = new IruzkinaForm();
	$form->setDefault('gertakaria_id', $gertakaria->getId());
	$form->setDefault('ekintza_id', 1);
	$form->setDefault('langilea_id', $lang);
?>
	<form action="<?php echo url_for('iruzkina/create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<div class="izkutua">
			<?php echo $form['gertakaria_id']->render(array('id' => '')); ?>
			<?php echo $form['ekintza_id']->render(array('id' => '')); ?>
			<?php echo $form['langilea_id']->render(array('id' => '')); ?>

<?php if ($form->isCSRFProtected()) : ?>
			<?php echo $form['_csrf_token']->render(); ?>
<?php endif; ?>
		</div>

		<h5><?php echo __('Iruzkina gehitu') ?>:</h5>

		<?php echo $form['testua']->render(); ?>
		<input type="submit" value="<?php echo __('Gehitu') ?>" />
	</form>
</div>


<!-- Fitxategiak:  -->
<?php log_message('Fitxategiak....', 'info'); ?>
<div class="gertakaria fitxategiak">
	<div class="taulaGoiburua"><?php echo __('Fitxategiak') ?></div>
<?php if (count($gertakaria->getFitxategiak()) > 0): ?>
	<ul>
	<?php foreach ($gertakaria->getFitxategiak() as $i => $fitxategia): ?>
		<li>-<a href="<?php echo '/uploads/FILES/' . $gertakaria->getId() . '/' . $fitxategia->getFitxategia(); ?>"  target="_blank">
			<?php echo $fitxategia->getDeskribapena() . " (" . $fitxategia->getFitxategia() . ")"; ?></a>
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
<?php if ($form->isCSRFProtected()) : ?>
			<?php echo $form['_csrf_token']->render(); ?>
<?php endif; ?>
		</div>
		<div><strong><?php echo __('Fitxategia gehitu') ?>:</strong></div>
		<div>
			<?php echo __('Deskribapena') ?>:<?php echo $form['deskribapena']->render(array('size' => 50)); ?>
			<?php echo __('Fitxategia') ?>:<?php echo $form['fitxategia2']->render(); ?><input type="submit" value="<?php echo __('Gehitu') ?>" />
		</div>
	</form>
</div>


<!-- Planoak: -->
<div id="plano_icon">
	<img id="erakutsiPlanoa" src="<?php echo sprintf('/images/Planoa_%s.png', $sf_user->getCulture()); ?>" alt="<?php echo __('Planoa'); ?>" />
</div>
<div id="geolokalizazioa" style="display: none;">
	<?php log_message('Planoak....', 'info'); ?>
	<div class="planoa">
		<div class="taulaGoiburua">
			<?php echo __('Planoa') ?>
			<img id="ezkutatuPlanoa" src="/images/Ezabatu.png" alt="<?php echo __('Ezabatu'); ?>" />
		</div>
<?php
	$herria = sfConfig::get('app_google_helbidea');

	$gMap = new GMap();
	$gMap->setParameters(array('onload_method' => 'none'));
	$gMap->setZoom(15);
	$gMap->setScroll('false');
	$coord = $gMap->geocodeXml($herria);
	$gMap->setCenter($coord->getLat(), $coord->getLng());
	$gMap->setHeight('500');
	$gMap->setWidth('100%');
	$k = 0;

	foreach ($gertakaria->getKoordenadak() as $i => $puntua)
	{
		$test = "'" . $puntua->getTestua() . "'";
		$ikonoa = sprintf('\'https://chart.googleapis.com/chart?chst=%s&chld=edge_bc|%s|%s\'', 'd_bubble_text_small_withshadow', urlencode($puntua->getTestua()), 'C6EF8C', '000000');
		$gMapMarker = new GMapMarker($puntua->getLatitudea(), $puntua->getLongitudea(), array('title ' => $test, 'icon ' => $ikonoa));
		$gMap->addMarker($gMapMarker);
		$k++;
	}

	if ($gertakaria->getKalea_id())
	{
		$kale = Doctrine::getTable('Kalea')->find($gertakaria->getKaleaId());

		$helbidea = sprintf('%s, %s %s', $kale->getGoogle(), $gertakaria->getKale_zbkia(), $herria);

		$puntua = $gMap->geocodeXml($helbidea);
		$gMapMarker = new GMapMarker($puntua->getLat(), $puntua->getLng());

		//gertakarian informazio leihoa
		$info_window = new GMapInfoWindow('<div><b>' . __('ID') . '</b>: ' . $gertakaria->getId() . '<br /><b>' . __('Laburpena') . ':</b> ' . $gertakaria->getLaburpena() . '<br /><b>' . __('Deskribapena') . ':</b><br /><pre>' . $gertakaria->getDeskribapena() . '</pre></div>');
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

	include_map($gMap, array('width' => '512px', 'height' => '400px'));
?>

		<div class="puntuPanela">
			<div class="puntuGoiburua lerroa">
				<div><?php echo __('Latitudea') ?></div>
				<div><?php echo __('Longitudea') ?></div>
			</div>
<?php foreach ($gertakaria->getKoordenadak() as $i => $puntua): ?>
			<div class="puntuak lerroa">
				<div><?php echo $puntua->getLatitudea() ?></div>
				<div><?php echo $puntua->getLongitudea() ?></div>
				<div><?php echo $puntua->getTestua() ?></div>
	<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
				<a href="<?php echo url_for('geo/delete?id=' . $puntua->getId()) ?>" >
					<img src="/images/Ezabatu.png" alt="<?php __('Ezabatu'); ?>" />
				</a>
	<?php endif; ?>
			</div>
<?php endforeach; ?>

			<?php log_message('Planoak....formularioa', 'info'); ?>

			<?php $form = new GeoForm(); ?>
			<?php $form->setDefault('gertakaria_id', $gertakaria->getId()); ?>
			<?php $form->setDefault('geometria_id', 1); ?>
			<form action="<?php echo url_for('geo/create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
				<div class="izkutua">
					<!-- //Hemen hutsegiten du, asko tardatzen du kargatzen... -->
					<?php echo $form['gertakaria_id']->render(array('id' => '')); ?>
					<?php echo $form['geometria_id']->render(array('id' => '')); ?>
<?php if ($form->isCSRFProtected()) : ?>
					<?php echo $form['_csrf_token']->render(); ?>
<?php endif; ?>
				</div>

				<?php log_message('Planoak....Render', 'info'); ?>
				<div class="lerroa">
					<div><?php echo $form['latitudea']->render(array('size' => 10)); ?></div>
					<div><?php echo $form['longitudea']->render(array('size' => 10)); ?></div>
					<div><?php echo $form['testua']->render(array('size' => 20)); ?></div>
					<input type="submit" value="<?php echo __('Gehitu') ?>" />
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Javascript included at the bottom of the page -->
<?php include_map_javascript($gMap); ?>
