<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_title() ?>
		<link rel="shortcut icon" href="/favicon.ico" />
		<?php include_stylesheets() ?>
		<?php include_javascripts() ?>
	</head>

	<body>
		<div id="goiburua">
			<img class="logoa" src="/images/logo2.jpg" alt="Logotipo" />
<?php if ($sf_user->isAuthenticated()): ?>
			<div class="post">
				<div class="erabiltzailea">
					<div><?php echo $sf_user->getGuardUser()->getFirstName() . " " . $sf_user->getGuardUser()->getLastName(); ?></div>
					<div>( <?php echo $sf_user->getUsername(); ?> )</div>
				</div>

				[<a href="?sf_culture=eu">eu</a>] [<a href="?sf_culture=es">es</a>]
			</div>
			<a class="eskuliburua" target="_blank" href="<?php echo sprintf('/doc/Eskuliburua_%s.pdf', $sf_user->getCulture()); ?>">
				<img src="<?php echo sprintf('/images/Eskuliburua_%s.png', $sf_user->getCulture()); ?>" alt="<?php echo __('Eskuliburua') ?>" />
			</a>
<?php endif; ?>
		</div>
		<div id="gorputza">
<?php if ($sf_user->isAuthenticated()): ?>
			<ul class="sesioa">
				<li><?php echo link_to(__('Gertakariak'), 'gertakaria/index') ?></li>
	<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
				<li><?php echo link_to(__('Zerrendatuak'), 'zerrendatu/index') ?></li>
				<li><?php echo link_to(__('Erabilera datuak'), 'datuak/index') ?></li>
				<li><?php echo link_to(__('Egoerak'), 'egoera/index') ?></li>
				<li><?php echo link_to(__('Sailak'), 'saila/index') ?></li>
				<li><?php echo link_to(__('Kaleak'), 'kalea/index') ?></li>
	<?php endif; ?>

	<?php if ($sf_user->hasCredential('admins')): ?>
				<li><?php echo link_to(__('Erabiltzaileak'), 'erabiltzaileak/index') ?></li>
				<li><?php echo link_to(__('Indexatu'), 'gertakaria/indexatu') ?></li>
	<?php endif; ?>
	<?php if (!$sf_user->hasCredential('admins')): ?>
				<li><?php echo link_to(__('Nire datuak'), 'langilea') ?></li>
	<?php endif; ?>
				<li><?php echo link_to(__('Saioa amaitu'), 'sf_guard_signout') ?></li>
			</ul>
<?php endif; ?>
			<div id="edukia">
<!-- Edukiaren hasiera -->
<?php echo $sf_content; ?>
<!-- Edukiaren amaiera -->
			</div>
		</div>
	</body>
</html>
