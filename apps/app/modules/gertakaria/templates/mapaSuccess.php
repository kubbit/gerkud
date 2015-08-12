<?php use_helper('Javascript', 'GMap') ?>
<?php use_helper('Pagination'); ?>

<div id="planoOsoa">
	<div class="mapa">
<?php if (!sfConfig::get('app_google_offline')): ?>
		<?php
		$herria = sfConfig::get('app_google_helbidea');

		$gMap = new GMap();
		$gMap->setScroll('false');
		$gMap->setZoom(14);
		$coord = $gMap->geocodeXml($herria);
		$gMap->setCenter($coord->getLat(), $coord->getLng());
		$gMap->setHeight('100%');
		$gMap->setWidth('100%');
		?>
		<?php foreach ($pager->getResults() as $gertakaria): ?>
<?php
			$latitudea = NULL;
			$longitudea = NULL;

			if ($gertakaria->getKalea_id())
			{
				$kale = Doctrine_Core::getTable('Kalea')->find($gertakaria->getKaleaId());

				$helbidea = sprintf('%s, %s %s', $kale->getGoogle(), $gertakaria->getKale_zbkia(), $herria);

				$puntua = $gMap->geocodeXml($helbidea);
				if (($puntua->getLat() != '') || ($puntua->getLng() != ''))
				{
					$latitudea = $puntua->getLat();
					$longitudea = $puntua->getLng();
				}
			}
			elseif ($gertakaria->getKoordenadak()->count() > 0)
			{
				$puntuak = $gertakaria->getKoordenadak();

				$latitudea = $puntuak[0]->getLatitudea();
				$longitudea = $puntuak[0]->getLongitudea();
			}

			if ($latitudea !== NULL && $longitudea !== NULL)
			{
				$test = "'" . $gertakaria->getLaburpena() . "'";
				$ikonoa = sprintf('\'https://chart.googleapis.com/chart?chst=%s&chld=%s|%s|%s\'', 'd_map_pin_letter_withshadow', $gertakaria->getId(), 'ff8888', '000000');
				$gMapMarker = new GMapMarker($latitudea, $longitudea, array('title' => $test, 'icon ' => $ikonoa));
				$gMap->addMarker($gMapMarker);
			}
?>
		<?php endforeach; ?>

		<?php $gMap->centerOnMarkers(); ?>
		<?php include_map($gMap); ?>

		<!-- Javascript included at the bottom of the page -->
		<?php include_map_javascript($gMap); ?>
<?php endif; ?>
	</div>
</div>
