<?php use_helper('Javascript','GMap') ?>


<?php $lang=$sf_user->getGuardUser()->getId(); ?>
<?php use_helper('Debug') ?>

<?php log_message('Gertakaria....', 'info') ?>
<table width=80% class="gertakaria">
  <thead>
    <tr>
<!--        <th colspan=4 class="ezker<?php //echo $gertakaria->getEgoeraId();?>"><h3><?php echo $gertakaria->getLaburpena() ?></h3></th> -->
        <th colspan=4 class="ezker"><h3><?php echo $gertakaria->getLaburpena() ?></h3></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      	<th class="ezker" align=left>Kodea:</th>
	<th class="ezker">Mota/Azpimota:</th>
	<th class="ezker">Irekiera data:</th>
        <th rowspan=9 class="panela" NOWRAP>

<!--Botoiak -->
	<br><br>
		<?php if (($gertakaria->getEgoeraId()!=5)&&($gertakaria->getEgoeraId()!=6)): ?>
	                <a class="boton" href="<?php echo url_for('gertakaria/egoera?id='.$gertakaria->getId().'&eg_id=6') ?>"
onclick="return confirm('Gertakaria baztertu nahi duzu?');"
>
        	                Baztertu</a>
			<br><br>
                       	<?php log_message('Panela....', 'info'); ?>
                        <a class="boton" href="<?php echo url_for('gertakaria/edit?id='.$gertakaria->getId()) ?>">
                                Editatu</a>
                        <br><br>


                        <?php $form2 = new IruzkinaForm(); ?>
                        <?php $form2->setDefault ('gertakaria_id', $gertakaria->getId()); ?>
                        <?php $form2->setDefault ('ekintza_id', 2); ?>
                        <?php $form2->setDefault ('langilea_id', $lang); ?>
                        <form action="<?php echo url_for('iruzkina/create') ?>" method="post"
                                <?php $form2->isMultipart() and print 'enctype="multipart/form-data" ' ?> >
                        <div id="izkutua"  style="display:none">
                                <?php echo $form2['gertakaria_id'];  ?>
                                <?php echo $form2['ekintza_id'];  ?>
                                <?php echo $form2['langilea_id'];  ?>
                                <?php if ($form2->isCSRFProtected()) : ?>
                                  <?php echo $form2['_csrf_token']->render(); ?>
                                <?php endif; ?>
                        </div>
			<?php if ($gertakaria->getSailaId()) $form2->setDefault ('saila_id', $gertakaria->getSailaId()); ?>
                        <?php echo $form2['saila_id']->render();  ?><br>
                        <input type="submit" value="Gertakaria esleitu" />
                        </form>

		<?php endif; ?>
			<br>
         	       	<a class="boton" target=_blank href="<?php echo url_for('gertakaria/inprimatu?id='.$gertakaria->getId()) ?>">Inprimatu</a>
                	<br><br>

                <?php if (($gertakaria->getEgoeraId()!=5)&&($gertakaria->getEgoeraId()!=6)): ?>
	                <a class="boton" href="<?php echo url_for('gertakaria/egoera?id='.$gertakaria->getId().'&eg_id=4') ?>">
				Prozesuan jarri</a>
	                <br><br>
	                <a class="boton" href="<?php echo url_for('gertakaria/egoera?id='.$gertakaria->getId().'&eg_id=5') ?>">
				Itxi</a>
	                <br><br>
		<?php endif; ?>


		<!--Gertakaria berrireki -->
                <?php if (($gertakaria->getEgoeraId()==5)||($gertakaria->getEgoeraId()==6)): ?>
                        <?php $form3 = new IruzkinaForm(); ?>
                        <?php $form3->setDefault ('gertakaria_id', $gertakaria->getId()); ?>
                        <?php $form3->setDefault ('ekintza_id', 3); ?>
                        <?php $form3->setDefault ('langilea_id', $lang); ?>
                        <form action="<?php echo url_for('iruzkina/create') ?>" method="post" 
				<?php $form3->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
                        <div id="izkutua"  style="display:none">
                                <?php echo $form3['gertakaria_id']->render();  ?>
                                <?php echo $form3['ekintza_id']->render();  ?>
                                <?php echo $form3['langilea_id']->render();  ?>

                                <?php if ($form3->isCSRFProtected()) : ?>
                                  <?php echo $form3['_csrf_token']->render(); ?>
                                <?php endif; ?>
                        </div>
			<?php echo $form3['testua']->render(array('cols'=>18,'rows'=>3)); ?><br>

                        <input type="submit" value="Gertakaria berrireki" />
                        </form>
			<br>
                <?php endif; ?>
                <a class="boton" href="<?php echo url_for('gertakaria/kopiatu?id='.$gertakaria->getId()) ?>">Kopiatu</a>
                <br><br>

        </th>
   </tr><tr>
      <td><?php echo $gertakaria->getId() ?></td>
      <td><?php echo $gertakaria->getMota() ?>/<?php echo $gertakaria->getAzpimota() ?></td>
      <td class="azkena"><?php echo $gertakaria->getCreatedAt() ?>
	<?php if (($gertakaria->getEgoeraId()==5)||($gertakaria->getEgoeraId()==6)): ?>
	<br><?php echo $gertakaria->getIxteData() ?>
      </td>
    </tr>
<?php endif; ?>


      </td>
   </tr>
    <tr>
      <th class="ezker">Egoera:</th>
      <th class="ezker">Saila:</th>
      <th class="ezker">Abisua / Harremanetarako:</th>
    </tr><tr>
      <td><?php echo $gertakaria->getEgoera() ?></td>
      <td>
	<?php if (($gertakaria->getEgoeraId()!=1)&&($gertakaria->getSailaId())): ?>
	<?php echo $gertakaria->getSaila() ?>
	<?php endif; ?>
      </td><td class="azkena">
        <?php echo $gertakaria->getAbisuaNork() ?><br>
        <?php echo $gertakaria->getHarremanetarako() ?>
      </td>
    </tr>
    <tr>
      <th class="ezker" colspan=3>Helbidea:</th>
    </tr><tr>
      <td colspan=3 class="azkena">
        <?php if ($gertakaria->getKalea_id()) {echo $gertakaria->getKalea();    echo ', '.$gertakaria->getKaleZbkia();} ?>
        <?php if ($gertakaria->getBarrutia_id()){ echo ' ('.$gertakaria->getBarrutia().')';} ?>
	<?php if ($gertakaria->getEraikina_id()){ echo '  -- '.$gertakaria->getEraikina().' -- ';};?>
        <br>
      </td>
    </tr>
    <tr>
      <th class="ezker" colspan=3>Deskribapena:</th>
    </tr><tr>
      <td colspan=3 class="azkena">
<!--[if IE]><p width="80"> <![endif]-->
<![if !IE]><pre width=<?php if ($sf_user->getAttribute('zabalera')<=1024) echo "50"; else echo 80; ?>><![endif]>
<?php echo $gertakaria->getDeskribapena(); ?>
<![if !IE]></pre><![endif]>
<!--[if IE]>            </p> <![endif]-->

	</td>
    <tr><th class="ezker" colspan=3></th></tr>
  </tbody>
</table>
<br><br>


<!-- <h3>Historikoa </h3>  -->
<?php log_message('Historikoa....', 'info') ?>
<table width=80% class="gertakaria">
<thead>
   <tr><th class="ezker" colspan=4>Aldaketen historikoa</th></tr>
</thead>
   <tr><th class="ezker">Data</th><th class="ezker">Nork</th><th class="ezker">Ekintza</th><th class="ezker">Iruzkina</th></tr>
   <?php foreach ($gertakaria->getIruzkinak() as $i => $iruzkina): ?>
   <tr><td class="iruzk_zerrenda" width=15% NOWRAP>
	<?php echo $iruzkina->getCreated_at();?>
   </td><td class="iruzk_zerrenda" width=10%>
	<?php echo $iruzkina->getLangilea()->getFirstName();?>
   </td><td NOWRAP class="iruzk_zerrenda" width=10%>
	<?php echo $iruzkina->getEkintza();?>
   </td><td class="iruzk_zerrenda" >
	<?php echo $iruzkina->getTestua();?>
   </td></tr>
   <?php endforeach; ?>
   <tr><td colspan=4><br></td></tr>
   <tr>
	<th colspan=4 class="ezker"> 
        <?php $form = new IruzkinaForm(); ?>
        <?php $form->setDefault ('gertakaria_id', $gertakaria->getId()); ?>
        <?php $form->setDefault ('ekintza_id', 1); ?>
        <?php $form->setDefault ('langilea_id', $lang); ?>
        <form action="<?php echo url_for('iruzkina/create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <div id="izkutua"  style="display:none">
                <?php echo $form['gertakaria_id']->render();  ?>
                <?php echo $form['ekintza_id']->render();  ?>
                <?php echo $form['langilea_id']->render();  ?>

                <?php if ($form->isCSRFProtected()) : ?>
                  <?php echo $form['_csrf_token']->render(); ?>
                <?php endif; ?>
        </div>

        <br><h5>Iruzkina gehitu:</h5>

        <?php echo $form['testua']->render(array('cols'=>$sf_user->getAttribute('zabalera')/10.6,'rows'=>4)); ?>
        <input type="submit" value="Gehitu" />

<!--
	<?php echo $form['testua']->render(); ?>
        <input type="submit" value="Iruzkina gehitu" />
-->
        </form>
</th></tr>
</table>

<!-- Fitxategiak:  -->
<?php log_message('Fitxategiak....', 'info'); ?>
<br><br>
<table width=80% class="gertakaria">
  <thead>
    <tr><th  class="ezker" colspan=4>Fitxategiak</th></tr>
  </thead>
  <tr><td colspan=3 class="fitx_zerrenda">
    <ul>
    <?php foreach ($gertakaria->getFitxategiak() as $i => $fitxategia): ?>
        <li>-<a href="<?php echo '/uploads/FILES/'.$gertakaria->getId().'/'.$fitxategia->getFitxategia();?>"  target=_blank>
<?php echo $fitxategia->getDeskribapena()." (".$fitxategia->getFitxategia().")"; ?></a>
        </li>
    <?php endforeach; ?>
    </ul>
   <br>
   </td></tr>
   <tr><th colspan=3 class="eskuin">
	<?php $form = new FitxategiaForm(); ?>
        <?php $form->setDefault ('gertakaria_id', $gertakaria->getId()); ?>
        <?php $form->setDefault ('langilea_id', $lang); ?>
	<form action="<?php echo url_for('fitxategia/create') ?>" method="post" 
		<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<div id="izkutua"  style="display:none">
	      	<?php echo $form['gertakaria_id']->render();  ?>
                <?php echo $form['langilea_id']->render();  ?>
		<?php if ($form->isCSRFProtected()) : ?>
	          <?php echo $form['_csrf_token']->render(); ?>
		<?php endif; ?>
	</div>
<!--
	Deskribapena:<?php //echo $form['deskribapena']->render(array('size'=>50));  ?>
	<br>
	Fitxategia:<?php //echo $form['fitxategia2']->render();  ?>
	<input type="submit" value="Gehitu" />
-->
        </th></tr>
        <tr><th class="ezker" colspan=3><h5>Fitxategia gehitu:</h5></th></tr>
        <tr>
           <th class="ezker" colspan=3><div style="font-weight:normal">
                Deskribapena:<?php echo $form['deskribapena']->render(array('size'=>50));  ?>
                Fitxategia:<?php echo $form['fitxategia2']->render();  ?><input type="submit" value="Gehitu" /></th>
           </div>
        </tr>



	</form>
</th></tr>
</table>
<br><br>

<!-- Planoak: -->
<center>
<div id="plano_icon"><A href="#" onclick="mapaErakutsi();"><img src="/images/Planoa.png"></a></div>
</center>
<div id="geolokalizazioa" style="display:block;visibility:hidden;">
<?php log_message('Planoak....', 'info'); ?>
<br><br>
<table class="planoa">
<thead>
<tr><th class="ezker">Planoa</th><th class="eskuin"><A href="#" onclick="mapaErakutsi();"><img src="/images/Ezabatu.png"></a></th></tr>
</thead>
<tr><td colspan=2>
	<?php 
	  $gMap = new GMap();
          $gMap->setZoom(15);
	  $gMap->setScroll('false');
          $gMap->setCenter(43.3251,-1.920894);
          $gMap->setHeight('500');
          $gMap->setWidth('100%');
	  $k=0;
	?>
        <?php foreach ($gertakaria->getKoordenadak() as $i => $puntua): ?>
		<?php $test="'".$puntua->getTestua()."'"; ?>
       		<?php $gMapMarker = new GMapMarker($puntua->getLatitudea(),$puntua->getLongitudea(),array('title'=>$test)); ?>
       		<?php $gMap->addMarker($gMapMarker); ?>
		<?php $k++; ?>
	<?php endforeach; ?>
    	<?php //if (($k==0)&&($gertakaria->getKalea())) : ?>
	<?php if (($gertakaria->getKalea_id())&&($gertakaria->getBarrutia_id()!=6)) : ?>
		<?php
		  //$helbidea = $gertakaria->getKalea().", ".$gertakaria->getKale_zbkia()." 20110 PASAIA";
		  //kaleen izenak google-ek dituen bezala hartuko ditugu:
		  $kale = Doctrine::getTable('Kalea')->find($gertakaria->getKaleaId());

//                $herria = sfConfig::get('app_helbide');
//                $herria = sfConfig::get('app_pk')." ".sfConfig::get('app_herria');
//                echo "<br>##########<br>".$herria."<br>##########<br>";


		  //echo '<script>alert("google: '.$kale->getGoogle().'");</script>';
//                  $helbidea = $kale->getGoogle().", ".$gertakaria->getKale_zbkia()." 20110 PASAIA";
                  $helbidea = $kale->getGoogle().", ".$gertakaria->getKale_zbkia().sfConfig::get('app_herria');

		  $puntua = $gMap->geocodeXml($helbidea);
		  $gMapMarker = new GMapMarker($puntua->getLat(),$puntua->getLng());
//gertakarian informazio leihoa
                  $info_window = new GMapInfoWindow('<div><b>ID</b>: '.$gertakaria->getId().'<br><b>Laburpena:</b> '.$gertakaria->getLaburpena().'<br><b>Deskribapena:</b><br><pre>'.$gertakaria->getDeskribapena().'</pre></div>');
                  $gMapMarker->addHtmlInfoWindow($info_window);
//
		  $gMap->addMarker($gMapMarker);
		  $k++;
		?>
    	<?php endif; ?>
	<?php if ($k!=0) $gMap->centerOnMarkers();?>

<!-- Koordenatuak:  -->
	<?php $mapEvt = new GMapEvent('click','function(event){click_coord(event);}',false); ?>
	<?php $gMap->addEvent($mapEvt); ?>
<!-- End koordenatuak -->




	<?php include_map($gMap,array('width'=>'512px','height'=>'400px')); ?>
<!-- </td><td align="left"> -->
</td></tr>
<tr><td colspan=2>
	<table class="koord" width=100%>
	<tr><th class=ezker>Latitudea</th><th class=ezker>Longitudea</th><th class=ezker colspan=2></th>
        <?php foreach ($gertakaria->getKoordenadak() as $i => $puntua): ?>
		<tr><td class="iruzk_zerrenda"><?php echo $puntua->getLatitudea()?></td>
		<td class="iruzk_zerrenda"><?php echo $puntua->getLongitudea()?></td>
		<td class="iruzk_zerrenda"><?php echo $puntua->getTestua()?></td>
		<td class="iruzk_zerrenda" align=right><a href="<?php echo url_for('geo/delete?id='.$puntua->getId())?>" ><img src="/images/Ezabatu.png">
</A></td></tr>
        <?php endforeach; ?>

<?php log_message('Planoak....formularioa', 'info'); ?>


	<tr>
        <?php $form = new GeoForm(); ?>
        <?php $form->setDefault ('gertakaria_id', $gertakaria->getId()); ?>
        <?php $form->setDefault ('geometria_id', 1); ?>
        <form action="<?php echo url_for('geo/create') ?>" method="post"
                <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <div id="izkutua"  style="display:none">
//Hemen hutsegiten du, asko tardatzen du kargatzen...
                <?php echo $form['gertakaria_id']->render();  ?>
                <?php echo $form['geometria_id']->render();  ?>
                <?php if ($form->isCSRFProtected()) : ?>
                  <?php echo $form['_csrf_token']->render(); ?>
                <?php endif; ?>
        </div>
<?php log_message('Planoak....Render', 'info'); ?>
        <th class=ezker><?php echo $form['latitudea']->render(array('size'=>10));  ?></th>
        <th class=ezker><?php echo $form['longitudea']->render(array('size'=>10));  ?></th>
        <th class=ezker><?php echo $form['testua']->render(array('size'=>20));  ?></th>
	<th class=eskuin><input type="submit" value="Gehitu" /></th></tr>
        </form>
	</table>
</td>
</tr>
</table>
</div>

<br><br><br>
<hr>




<!-- Javascript included at the bottom of the page -->
<?php include_map_javascript($gMap); ?>

<!-- <script type=text/javascript>mapaErakutsi();</script>   -->


