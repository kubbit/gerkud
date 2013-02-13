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
      	<th class="ezker" align=left><?php echo __('Kodea')?>:</th>
	<th class="ezker"><?php echo __('Mota/Azpimota')?>:</th>
	<th class="ezker"><?php echo __('Irekiera data')?>:</th>
        <th rowspan=9 class="panela" NOWRAP>

<!--Botoiak -->
	<br><br>
		<!-- Editatu -->
		<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
		<?php if (($gertakaria->getEgoeraId()!=5)&&($gertakaria->getEgoeraId()!=6)): ?>
	                <a class="boton" href="<?php echo url_for('gertakaria/egoera?id='.$gertakaria->getId().'&eg_id=6') ?>"
onclick="return confirm('<?php echo __('Gertakaria baztertu nahi duzu?')?>');"
>
        	                <?php echo __('Baztertu')?></a>
			<br><br>
                       	<?php log_message('Panela....', 'info'); ?>
                        <a class="boton" href="<?php echo url_for('gertakaria/edit?id='.$gertakaria->getId()) ?>">
                                <?php echo __('Editatu')?></a>
                        <br><br>
		<?php endif; ?>
		<?php endif; ?>


		<!-- Esleitu -->
		<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false) || $sailakoa || ($sf_user->hasCredential('zerbitzu') && $gertakaria->getSaila() == "")): ?>
		<?php if (($gertakaria->getEgoeraId()!=5)&&($gertakaria->getEgoeraId()!=6)): ?>
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
                        <input type="submit" value="<?php echo __('Gertakaria esleitu')?>" />
                        </form>

		<?php endif; ?>
		<?php endif; ?>

		<!-- Imprimatu -->
			<br>
         	       	<a class="boton" target=_blank href="<?php echo url_for('gertakaria/inprimatu?id='.$gertakaria->getId()) ?>"><?php echo __('Inprimatu')?></a>
                	<br><br>

		<!-- Prozesuan jarri -->
		<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false) || $sailakoa): ?>
                <?php if ($gertakaria->getEgoeraId() == 2 || $gertakaria->getEgoeraId() == 3): ?>
	                <a class="boton" href="<?php echo url_for('gertakaria/egoera?id='.$gertakaria->getId().'&eg_id=4') ?>">
				<?php echo __('Prozesuan jarri')?></a>
	                <br><br>
		<?php endif; ?>
		<!-- Itxi -->
		<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false) || $sailakoa): ?>
                <?php if ($gertakaria->getEgoeraId() == 4): ?>
	                <a class="boton" href="<?php echo url_for('gertakaria/egoera?id='.$gertakaria->getId().'&eg_id=5') ?>">
				<?php echo __('Itxi')?></a>
	                <br><br>
		<?php endif; ?>
		<?php endif; ?>
		<?php endif; ?>


		<!--Gertakaria berrireki -->
		<?php if ($sf_user->hasCredential(array('admins', 'gerkud', 'zerbitzu', 'arrunta'), false)): ?>
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

                        <input type="submit" value="<?php echo __('Gertakaria berrireki')?>" />
                        </form>
			<br>
                <?php endif; ?>
		<?php endif; ?>
		<!--Gertakaria berrireki -->
		<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
                <a class="boton" href="<?php echo url_for('gertakaria/kopiatu?id='.$gertakaria->getId()) ?>"><?php echo __('Kopiatu')?></a>
                <br><br>
		<?php endif; ?>

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
      <th class="ezker"><?php echo __('Egoera')?>:</th>
      <th class="ezker"><?php echo __('Saila')?>:</th>
      <th class="ezker"><?php echo __('Abisua nork')?>:</th>
    </tr><tr>
      <td><?php echo $gertakaria->getEgoera() ?></td>
      <td>
	<?php if (($gertakaria->getEgoeraId()!=1)&&($gertakaria->getSailaId())): ?>
	<?php echo $gertakaria->getSaila() ?>
	<?php endif; ?>
      </td><td class="azkena">
        <?php echo $gertakaria->getAbisuaNork() ?>
      </td>
    </tr>
    <tr>
      <th class="ezker"><?php echo __('Hasiera aurreikusia')?>:</th>
      <th class="ezker"><?php echo __('Amaiera aurreikusia')?>:</th>
    </tr><tr>
      <td class="ezker"><?php echo $gertakaria->getHasieraAurreikusia() ?></td>
      <td class="ezker"><?php echo $gertakaria->getAmaieraAurreikusia() ?></td>
      <td class="azkena">&nbsp;</td>
    </tr>
    <tr>
      <th class="ezker" colspan=3><?php echo __('Helbidea')?>:</th>
    </tr><tr>
      <td colspan=3 class="azkena">
        <?php if ($gertakaria->getKalea_id()) {echo $gertakaria->getKalea();    echo ', '.$gertakaria->getKaleZbkia();} ?>
        <?php if ($gertakaria->getBarrutia_id()){ echo ' ('.$gertakaria->getBarrutia().')';} ?>
	<?php if ($gertakaria->getEraikina_id()){ echo '  -- '.$gertakaria->getEraikina().' -- ';};?>
        <br>
      </td>
    </tr>
    <tr>
      <th class="ezker" colspan=3><?php echo __('Deskribapena')?>:</th>
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
   <tr><th class="ezker" colspan=4><?php echo __('Aldaketen historikoa')?></th></tr>
</thead>
   <tr><th class="ezker"><?php echo __('Data')?></th><th class="ezker"><?php echo __('Nork')?></th><th class="ezker"><?php echo __('Ekintza')?></th><th class="ezker"><?php echo __('Iruzkina')?></th></tr>
   <?php foreach ($gertakaria->getIruzkinak() as $i => $iruzkina): ?>
   <tr><td class="iruzk_zerrenda" width=10% NOWRAP>
	<?php echo date("Y-m-d", strtotime($iruzkina->getCreated_at()));?>
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

        <br><h5><?php echo __('Iruzkina gehitu')?>:</h5>

        <?php echo $form['testua']->render(array('cols'=>$sf_user->getAttribute('zabalera')/10.6,'rows'=>4)); ?>
        <input type="submit" value="<?php echo __('Gehitu')?>" />

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
    <tr><th  class="ezker" colspan=4><?php echo __('Fitxategiak')?></th></tr>
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
        <tr><th class="ezker" colspan=3><h5><?php echo __('Fitxategia gehitu')?>:</h5></th></tr>
        <tr>
           <th class="ezker" colspan=3><div style="font-weight:normal">
                <?php echo __('Deskribapena')?>:<?php echo $form['deskribapena']->render(array('size'=>50));  ?>
                <?php echo __('Fitxategia')?>:<?php echo $form['fitxategia2']->render();  ?><input type="submit" value="<?php echo __('Gehitu')?>" /></th>
           </div>
        </tr>



	</form>
</th></tr>
</table>
<br><br>

<!-- Planoak: -->
<center>
<div id="plano_icon"><A href="#" onclick="mapaErakutsi();"><img src="<?php echo sprintf('/images/Planoa_%s.png', $sf_user->getCulture()); ?>"></a></div>
</center>
<div id="geolokalizazioa" style="display:block;visibility:hidden;">
<?php log_message('Planoak....', 'info'); ?>
<br><br>
<table class="planoa">
<thead>
<tr><th class="ezker"><?php echo __('Planoa')?></th><th class="eskuin"><A href="#" onclick="mapaErakutsi();"><img src="/images/Ezabatu.png"></a></th></tr>
</thead>
<tr><td colspan=2>
	<?php
	  $herria = sfConfig::get('app_herria');

	  $gMap = new GMap();
          $gMap->setZoom(15);
	  $gMap->setScroll('false');
	  $coord = $gMap->geocodeXml($herria);
          $gMap->setCenter($coord->getLat(), $coord->getLng());
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
	<?php if ($gertakaria->getKalea_id()) : ?>
		<?php
		  $kale = Doctrine::getTable('Kalea')->find($gertakaria->getKaleaId());

                  $helbidea = $kale->getGoogle().", ".$gertakaria->getKale_zbkia().$herria;

		  $puntua = $gMap->geocodeXml($helbidea);
		  $gMapMarker = new GMapMarker($puntua->getLat(),$puntua->getLng());
//gertakarian informazio leihoa
                  $info_window = new GMapInfoWindow('<div><b>'.__('ID').'</b>: '.$gertakaria->getId().'<br><b>'.__('Laburpena').':</b> '.$gertakaria->getLaburpena().'<br><b>'.__('Deskribapena').':</b><br><pre>'.$gertakaria->getDeskribapena().'</pre></div>');
                  $gMapMarker->addHtmlInfoWindow($info_window);

		  $gMap->addMarker($gMapMarker);
		  $k++;
		?>
    	<?php endif; ?>
		<?php if ($gertakaria->getEraikinaId() != null) :?>
			<?php
			$eraikina = $gertakaria->getEraikina();
			$gMapMarker = new GMapMarker($eraikina->getLatitudea(), $eraikina->getLongitudea(), array('title' => "'" . $eraikina->getIzena() . "'"));
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
	<tr><th class=ezker><?php echo __('Latitudea')?></th><th class=ezker><?php echo __('Longitudea')?></th><th class=ezker colspan=2></th>
        <?php foreach ($gertakaria->getKoordenadak() as $i => $puntua): ?>
		<tr><td class="iruzk_zerrenda"><?php echo $puntua->getLatitudea()?></td>
		<td class="iruzk_zerrenda"><?php echo $puntua->getLongitudea()?></td>
		<td class="iruzk_zerrenda"><?php echo $puntua->getTestua()?></td>

		<td class="iruzk_zerrenda" align=right>
			<?php if ($sf_user->hasCredential(array('admins', 'gerkud'), false)): ?>
			<a href="<?php echo url_for('geo/delete?id='.$puntua->getId())?>" ><img src="/images/Ezabatu.png"></A>
			<?php endif; ?>
		</td></tr>
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
	<th class=eskuin><input type="submit" value="<?php echo __('Gehitu')?>" /></th></tr>
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


