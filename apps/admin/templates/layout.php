<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <script>
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
//			alert('Honaino iristen da...');
		}
		function click_coord(event)
		{
		//    alert('haha');
  			document.getElementById('geo_latitudea').value=event.latLng.lat();
                        document.getElementById('geo_longitudea').value=event.latLng.lng();
		}
    </script>
  </head>

  <body>
	<?php
        	if (!($sf_user->getAttribute('zabalera'))||!($sf_user->getAttribute('altuera')))
	        {
        	        if (!isset($_GET['ancho']) || !isset($_GET['alto']))
	                {
	                        echo '<script>location.href="?ancho=" + screen.width + "&alto=" + screen.height;</script>';
	                        exit();

	                }else
        	        {
                	        $zabalera=$_GET['ancho'];
                       		$altuera=$_GET['alto'];
                        	$sf_user->setAttribute('zabalera', $zabalera);
	                        $sf_user->setAttribute('altuera', $altuera);
         	       }
        	}
	?>
    <div id="container">
     <div id="goiburua">
	<div class="logoa">
		<img src="/images/logo2.jpg">
	</div>
        <?php if ($sf_user->isAuthenticated()): ?>
	<div class="post">
                <h2><?php echo $sf_user->getGuardUser()->getFirstName()." ".$sf_user->getGuardUser()->getLastName();  ?><br>
               	( <?php echo $sf_user->getUsername(); ?> )</h2>
		<br><?php //echo link_to('Saioa amaitu', 'sf_guard_signout') ?>
	</div>
        <div class="eskuliburua">
                <a target="_blank" href="/uploads/FILES/Eskuliburua.pdf"><img src="/images/Eskuliburua.png"></a>
        </div>
        <?php endif ?>
    </div>
    <div id="gorputza">
	<div id="menua">
	   <ul>
                <li><?php echo link_to('Gertakarien zerrenda', 'gertakaria/index') ?></li>
		<li><?php echo link_to('Egoera', 'egoera/index') ?></li>
                <li><?php echo link_to('Saila', 'saila/index') ?></li>
                <li><?php echo link_to('Kaleak', 'kalea/index') ?></li>

              <?php if ($sf_user->isAuthenticated()): ?>
	        <?php if ($sf_user->getUsername()=='admin'): ?>
<!--		   <li><?php //echo link_to('Erabiltzaileak', 'sf_guard_user') ?></li>  -->
                   <li><?php echo link_to('Erabiltzaileak', 'langilea/index') ?></li>
                   <li><?php echo link_to('Indexatu', 'gertakaria/indexatu') ?></li>
	        <?php endif; ?>
                <li><?php echo link_to('Saioa amaitu', 'sf_guard_signout') ?></li>
           <?php endif ?>
	</div>
	<div id="edukia">

<?php use_helper('Debug') ?>
<?php //log_message('Debugging....', 'err') ?>


    <?php if ($sf_user): ?>
    <?php //$taldeak=bhLDAP::getUserGroups('uid='.$sf_user->getUsername(), 1); ?>
	<?php //$sailak=$sf_user->getGroups(); ?>
        <?php //echo $sf_user->getUsername()."<br>"; ?>
        <?php 
/*
		if ($sailak->count()==0)
		{
			echo "Hutsik dago!!";
//			$this->redirect('otherModule/index');
//			$this->redirect('http://debianpdf/index.php');
		}
		echo "<br>";
	    	foreach ($sailak as $saila):
		{
			echo $saila.",";
		} 
		endforeach;
*/
	?>
      <?php endif; ?>
    <br>
    <?php echo $sf_content ?>

        </div>
     </div>
    </div>
  </body>
</html>
