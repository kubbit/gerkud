<?php use_helper('Javascript', 'GMap') ?>
<?php use_helper('Pagination'); ?>

<div id="geolokalizazioa">
	<div class="planoOsoa">
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
			<?php if (($gertakaria->getKalea_id()) && ($gertakaria->getBarrutia_id() != 6)) : ?>
				<?php
				$test = "'" . $gertakaria->getId() . "'";
				$kale = Doctrine::getTable('Kalea')->find($gertakaria->getKaleaId());

				$helbidea = sprintf('%s, %s %s', $kale->getGoogle(), $gertakaria->getKale_zbkia(), $herria);

				$puntua = $gMap->geocodeXml($helbidea);
				if (($puntua->getLat() != '') || ($puntua->getLng() != ''))
				{
					$gMapMarker = new GMapMarker($puntua->getLat(), $puntua->getLng(), array('title' => $test));
					$gMap->addMarker($gMapMarker);
				}
				?>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php $gMap->centerOnMarkers(); ?>
		<?php include_map($gMap, array('width' => '100%', 'height' => '500px')); ?>

		<!-- Javascript included at the bottom of the page -->
		<?php include_map_javascript($gMap); ?>
	</div>
</div>