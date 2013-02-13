<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_title() ?>
		<link rel="shortcut icon" href="/favicon.ico" />
		<?php include_stylesheets() ?>
		<?php include_javascripts() ?>

		<script type="text/javascript">
			function erakutsiEzkutatu()
			{
				if (document.getElementById('aurreratua').style.display == 'none')
				{
					document.getElementById('aurreratua').style.display = 'block';
					document.getElementById('arrunta').style.display = 'none';
					document.getElementById('aurreratuaB').style.display = 'block';
				}
				else if (document.getElementById('aurreratua').style.display == 'block')
				{
					document.getElementById('aurreratua').style.display = 'none';
					document.getElementById('arrunta').style.display = 'block';
					document.getElementById('aurreratuaB').style.display = 'none';
				}
			}

			function mapaErakutsi()
			{
				if (document.getElementById('geolokalizazioa').style.visibility == 'hidden')
				{
					document.getElementById('geolokalizazioa').style.visibility = 'visible';
					document.getElementById('plano_icon').style.display = 'none';
				}
				else if (document.getElementById('geolokalizazioa').style.display == 'none')
				{
					document.getElementById('geolokalizazioa').style.display = 'block';
					document.getElementById('plano_icon').style.display = 'none';
					document.getElementById('map').event.trigger(gmap, "resize");
				}
				else if (document.getElementById('geolokalizazioa').style.display == 'block')
				{
					document.getElementById('geolokalizazioa').style.display = 'none';
					document.getElementById('plano_icon').style.display = 'block';
				}
			}
			function click_coord(event)
			{
				document.getElementById('geo_latitudea').value=event.latLng.lat();
				document.getElementById('geo_longitudea').value=event.latLng.lng();
			}
		</script>
	</head>

	<body>
<?php
		if (!($sf_user->getAttribute('zabalera')) || !($sf_user->getAttribute('altuera')))
		{
			if (!isset($_GET['ancho']) || !isset($_GET['alto']))
			{
				echo '<script>location.href="?ancho=" + screen.width + "&alto=" + screen.height;</script>';
				exit();
			}
			else
			{
				$zabalera = $_GET['ancho'];
				$altuera = $_GET['alto'];
				$sf_user->setAttribute('zabalera', $zabalera);
				$sf_user->setAttribute('altuera', $altuera);
			}
		}
?>
		<div id="container">
			<div id="goiburua">
				<div class="logoa">
					<img src="/images/logo2.jpg" />
				</div>
<?php if ($sf_user->isAuthenticated()): ?>
					<div class="post">
						<h2><?php echo $sf_user->getGuardUser()->getFirstName() . " " . $sf_user->getGuardUser()->getLastName(); ?><br />
							( <?php echo $sf_user->getUsername(); ?> )</h2>
						<br />
						[<a href="?sf_culture=eu">eu</a>] [<a href="?sf_culture=es">es</a>]
					</div>
					<div class="eskuliburua">
						<a target="_blank" href="<?php echo sprintf('/doc/Eskuliburua_%s.pdf', $sf_user->getCulture()); ?>">
							<img src="<?php echo sprintf('/images/Eskuliburua_%s.png', $sf_user->getCulture()); ?>" />
						</a>
					</div>
<?php endif; ?>
			</div>
			<div id="gorputza">
				<div class="sesioa">
					<h2>
						<ul>
<?php if ($sf_user->isAuthenticated()): ?>
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
<?php endif; ?>
						</ul>
					</h2>
				</div>
				<div id="edukia">
					<br />
<?php echo $sf_content; ?>
				</div>
			</div>
		</div>
	</body>
</html>
