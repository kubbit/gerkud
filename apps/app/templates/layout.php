<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=IE8" />
		<meta name="robots" content="noindex, nofollow" />
		<?php include_title(); ?>
<?php if (sfConfig::get('gerkud_logotipoa')): ?>
		<link rel="shortcut icon" href="<?php printf('/images/%s', sfConfig::get('gerkud_logotipoa')); ?>" />
<?php endif; ?>
		<?php include_stylesheets(); ?>
		<?php include_javascripts(); ?>
	</head>

<?php
const MENUA_MAPA = 'mapa';
const MENUA_BILATU = 'bilatu';
const MENUA_SORTU = 'sortu';
const MENUA_ESKAERAK = 'eskaerak';
const MENUA_GERTAKARIAK = 'gertakariak';
const MENUA_ZERRENDAK = 'zerrendak';
const MENUA_ESTATISTIKAK = 'estatistikak';
const MENUA_EGOERAK = 'egoerak';
const MENUA_SAILAK = 'sailak';
const MENUA_KALEAK = 'kaleak';
const MENUA_ERABILTZAILEAK = 'erabiltzaileak';
const MENUA_EZARPENAK = 'ezarpenak';
const MENUA_ESKULIBURUA = 'eskuliburua';
const MENUA_HIZKUNTZA = 'hizkuntza';
const MENUA_ITXI = 'itxi';

$helbidea = sfContext::getInstance()->getRouting()->getCurrentInternalUri();
$botoiak = sfConfig::get('gerkud_ezarpenak_menua', array());
?>

	<body>
<?php if ($sf_user->isAuthenticated()): ?>
		<div id="navIreki"></div>
		<div id="nav">
			<ul>
	<?php if (sfConfig::get('gerkud_logotipoa')): ?>
				<li id="logoa"><?php echo image_tag(sfConfig::get('gerkud_logotipoa'), array('alt' => 'Logo')); ?></li>
	<?php endif; ?>

<?php if ($sf_user->hasCredential(array('admins', 'gerkud', 'zerbitzu', 'arrunta'), false)): ?>

		<?php if (has_slot('mapa') && in_array(MENUA_MAPA, $botoiak)): ?>
				<?php include_slot('mapa'); ?>
		<?php endif; ?>

		<?php if (in_array(MENUA_BILATU, $botoiak)): ?>
				<li id="bilatu"><?php echo link_to(image_tag('bilatu.png', array('alt' => __('Bilatu'))) . __('Bilatu'), 'bilaketa/index', array('id' => 'erakutsiBilaketa')); ?></li>
		<?php endif; ?>
		<?php if ($helbidea != "gertakaria/new" && $helbidea != "gertakaria/create" && in_array(MENUA_SORTU, $botoiak)): ?>
				<li id="sortu"><?php echo link_to(image_tag('sortu.png', array('alt' => __('Gertakaria Sortu'))) . __('Gertakaria Sortu'), 'gertakaria/new'); ?></li>
		<?php endif; ?>
		<?php if (in_array(MENUA_ESKAERAK, $botoiak)): ?>
				<li><?php echo link_to(image_tag('eskaerak.png', array('alt' => __('Eskaerak'))) . __('Eskaerak (%eskaerak%)', array('%eskaerak%' => Doctrine_Core::getTable('Gertakaria')->getEskaeraKopurua())), 'eskaerak/index'); ?></li>
		<?php endif; ?>
		<?php if (in_array(MENUA_GERTAKARIAK, $botoiak)): ?>
				<li><?php echo link_to(image_tag('gertakariak.png', array('alt' => __('Gertakariak'))) . __('Gertakariak'), 'gertakaria/index'); ?></li>
		<?php endif; ?>
		<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
			<?php if (in_array(MENUA_ZERRENDAK, $botoiak)): ?>
				<li><?php echo link_to(image_tag('zerrendak.png', array('alt' => __('Zerrendak'))) . __('Zerrendak'), 'zerrendatu/index'); ?></li>
			<?php endif; ?>
			<?php if (in_array(MENUA_ESTATISTIKAK, $botoiak)): ?>
				<li><?php echo link_to(image_tag('estatistikak.png', array('alt' => __('Erabilera datuak'))) . __('Erabilera datuak'), 'datuak/index'); ?></li>
			<?php endif; ?>
			<?php if (in_array(MENUA_EGOERAK, $botoiak)): ?>
				<li><?php echo link_to(__('Egoerak'), 'egoera/index'); ?></li>
			<?php endif; ?>
			<?php if (in_array(MENUA_SAILAK, $botoiak)): ?>
				<li><?php echo link_to(__('Sailak'), 'saila/index'); ?></li>
			<?php endif; ?>
			<?php if (in_array(MENUA_KALEAK, $botoiak)): ?>
				<li><?php echo link_to(__('Kaleak'), 'kalea/index'); ?></li>
			<?php endif; ?>
		<?php endif; ?>
				<li class="menuaIreki menua2">
					<a><i class="fa fa-bars fa-2x" title="<?php echo __('Gehiago'); ?>"></i></a>
					<ul>
		<?php if ($sf_user->hasCredential('admins') && in_array(MENUA_ERABILTZAILEAK, $botoiak)): ?>
						<li><?php echo link_to(image_tag('erabiltzaileak.png', array('alt' => __('Erabiltzaileak'))) . __('Erabiltzaileak'), 'erabiltzaileak/index'); ?></li>
		<?php endif; ?>
		<?php if (!$sf_user->hasCredential('admins') && in_array(MENUA_EZARPENAK, $botoiak)): ?>
						<li><?php echo link_to(image_tag('ezarpenak.png', array('alt' => __('Nire datuak'))) . __('Nire datuak'), 'langilea'); ?></li>
		<?php endif; ?>
		<?php if (in_array(MENUA_ESKULIBURUA, $botoiak)): ?>
						<li><a target="_blank" href="<?php echo sprintf('/doc/Eskuliburua_%s.pdf', $sf_user->getCulture()); ?>"><?php echo image_tag('eskuliburua.png', array('alt' => __('Eskuliburua'))) . __('Eskuliburua'); ?></a></li>
		<?php endif; ?>
		<?php if (in_array(MENUA_HIZKUNTZA, $botoiak) && (sfConfig::get('gerkud_hizkuntzak_gaituak') == null || count(sfConfig::get('gerkud_hizkuntzak_gaituak')) > 1)): ?>
						<li class="menua3">
							<a><?php echo image_tag('hizkuntza.png', array('alt' => __('Hizkuntza'))) . __('Hizkuntza'); ?></a>
							<ul>
			<?php if (sfConfig::get('gerkud_hizkuntzak_gaituak') == null || in_array('eu', sfConfig::get('gerkud_hizkuntzak_gaituak'))): ?>
								<li><a href="?sf_culture=eu"><?php echo __('Euskera'); ?></a></li>
			<?php endif; ?>
			<?php if (sfConfig::get('gerkud_hizkuntzak_gaituak') == null || in_array('es', sfConfig::get('gerkud_hizkuntzak_gaituak'))): ?>
								<li><a href="?sf_culture=es"><?php echo __('Gaztelera'); ?></a></li>
			<?php endif; ?>
							</ul>
						</li>
		<?php endif; ?>
	<?php endif; ?>
	<?php if (in_array(MENUA_ITXI, $botoiak)): ?>
						<li><?php echo link_to(image_tag('saioa-itxi.png', array('alt' => __('Saioa amaitu'))) . __('Saioa amaitu'), 'sf_guard_signout'); ?></li>
	<?php endif; ?>
	<?php if ($sf_user->hasCredential(array('admins', 'gerkud', 'zerbitzu', 'arrunta'), false)): ?>
					</ul>
				</li>
	<?php endif; ?>
			</ul>
		</div>
<?php endif; ?>
		<div id="edukia">
<!-- Edukiaren hasiera -->
<?php echo $sf_content; ?>
<!-- Edukiaren amaiera -->
		</div>
	</body>
</html>
