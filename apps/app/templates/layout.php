<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=IE8" />
		<meta name="robots" content="noindex, nofollow" />
		<?php include_title(); ?>
		<link rel="shortcut icon" href="/favicon.ico" />
		<?php include_stylesheets(); ?>
		<?php include_javascripts(); ?>
	</head>

<?php
	$helbidea = sfContext::getInstance()->getRouting()->getCurrentInternalUri();
?>

	<body>
<?php if ($sf_user->isAuthenticated()): ?>
		<div id="navIreki"></div>
		<div id="nav">
			<ul>
	<?php if (sfConfig::get('app_logotipoa')): ?>
				<li id="logoa"><?php echo image_tag('logoa.png', array('alt' => 'Logo')); ?></li>
	<?php endif; ?>

	<?php if (has_slot('mapa')): ?>
				<?php include_slot('mapa'); ?>
	<?php endif; ?>

				<li id="bilatu"><?php echo link_to(image_tag('Bilatu.png', array('alt' => 'Bilatu')), 'bilaketa/index', array('id' => 'erakutsiBilaketa')) ?></li>
	<?php if ($helbidea != "gertakaria/new" && $helbidea != "gertakaria/create"): ?>
				<li id="sortu"><?php echo link_to(__('Gertakaria Sortu'), 'gertakaria/new') ?></li>
	<?php endif; ?>
				<li><?php echo link_to(__('Eskaerak (%eskaerak%)', array('%eskaerak%' => Doctrine_Core::getTable('Gertakaria')->getEskaeraKopurua())), 'eskaerak/index') ?></li>
				<li><?php echo link_to(__('Gertakariak'), 'gertakaria/index') ?></li>
	<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
				<li><?php echo link_to(__('Zerrendak'), 'zerrendatu/index') ?></li>
				<li><?php echo link_to(__('Erabilera datuak'), 'datuak/index') ?></li>
				<!--li><?php echo link_to(__('Egoerak'), 'egoera/index') ?></li>
				<li><?php echo link_to(__('Sailak'), 'saila/index') ?></li>
				<li><?php echo link_to(__('Kaleak'), 'kalea/index') ?></li-->
	<?php endif; ?>
				<li class="menuaIreki menua2">
					<a><img src="/images/asc.gif" alt="<?php echo __('Gehiago'); ?>" /></a>
					<ul>
	<?php if ($sf_user->hasCredential('admins')): ?>
						<li><?php echo link_to(__('Erabiltzaileak'), 'erabiltzaileak/index') ?></li>
	<?php endif; ?>
	<?php if (!$sf_user->hasCredential('admins')): ?>
						<li><?php echo link_to(__('Nire datuak'), 'langilea') ?></li>
	<?php endif; ?>
						<li><a target="_blank" href="<?php echo sprintf('/doc/Eskuliburua_%s.pdf', $sf_user->getCulture()); ?>"><?php echo __('Eskuliburua'); ?></a></li>
	<?php if (sfConfig::get('app_gerkud_hizkuntzak') == null || count(sfConfig::get('app_gerkud_hizkuntzak')) > 1): ?>
						<li class="menua3">
							<a><?php echo __('Hizkuntza'); ?></a>
							<ul>
		<?php if (sfConfig::get('app_gerkud_hizkuntzak') == null || in_array('eu', sfConfig::get('app_gerkud_hizkuntzak'))): ?>
								<li><a href="?sf_culture=eu"><?php echo __('Euskera'); ?></a></li>
		<?php endif; ?>
		<?php if (sfConfig::get('app_gerkud_hizkuntzak') == null || in_array('es', sfConfig::get('app_gerkud_hizkuntzak'))): ?>
								<li><a href="?sf_culture=es"><?php echo __('Gaztelera'); ?></a></li>
		<?php endif; ?>
							</ul>
						</li>
	<?php endif; ?>
						<li><?php echo link_to(__('Saioa amaitu'), 'sf_guard_signout') ?></li>
					</ul>
				</li>
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
