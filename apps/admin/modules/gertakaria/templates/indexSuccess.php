<?php use_helper('Javascript','GMap') ?>
<?php use_helper('Pagination'); ?>
<center>
<br>

<form action="<?php echo url_for('gertakaria/index'); ?>" method="post" class="bilaketa_form" >
<h2 align=left>Gertakarien bilaketa</h2>
<br>
<div style="display:block">
  <table width=95%>
  <tr><td valign=top class="eskuin" width=24%>Kodea:</td><td class="ezker"><?php echo $filter['id']->render(array('size'=>5)); ?></td></tr>
  <tr><td valign=top class="eskuin" width=24%>Sartu bilatu nahi duzun testua:</td><td class="ezker"><?php echo $filter['librea']->render(array('size'=>75)); ?></td></tr>

  </table>
</div>
<div id="aurreratua" style="display:none">
  <table  width=95% >
  <tr><td valign=top class="eskuin" width=24%>Klasea:</td><td class="ezker"><?php echo $filter['klasea_id']->render(); ?></td></tr>
  <tr><td valign=top class="eskuin" width=24%>Egoera:</td><td class="ezker"><?php echo $filter['egoera_id']->render(); ?></td></tr>
  <tr><td valign=top class="eskuin">Saila:</td><td class="ezker"><?php echo $filter['saila_id']->render(); ?></td></tr>
  <tr><td valign=top class="eskuin">Mota/Azpimota:</td><td class="ezker"><?php echo $filter['mota_id']->render(); ?><?php echo $filter['azpimota_id']->render(); ?></td></tr>
  <tr><td valign=top class="eskuin">Helbidea:</td>
	<td class="ezker">
		<?php $filter->setDefault('barrutia_id','Donibane'); ?>
		<?php echo $filter['barrutia_id']->render(); ?>
		<?php echo $filter['kalea_id']->render(); ?>
		<?php echo $filter['kale_zbkia']->render(array('size'=>5)); ?>
	</td>
  </tr>
  <tr><td valign=top class="eskuin" width=24%>Eraikina:</td><td class="ezker"><?php echo $filter['eraikina_id']->render(); ?></td></tr>

  <tr><td valign=top class="eskuin" width=24%>Jatorrizko Saila:</td><td class="ezker"><?php echo $filter['jatorrizkoSaila_id']->render(); ?></td></tr>
	<?php $filter->setDefault ('mapa',0); ?>
<!--
  <tr><td valign=top class="eskuin" width=24%>Erakutsi emaitzak planoan </td><td class="ezker"><?php //echo $filter['mapa']->render(); 
?></td></tr>
-->

  </table>
</div>
<table width=95%>
<tr><td colspan=2 align=right><input name="filter" type="submit" value="Bilatu" /></td></tr>
</table>
<div id="arrunta" style="display:block">
  <h4 style="cursor:hand; cursor:pointer;" onclick="erakutsiEzkutatu();">Bilaketa aurreratua...</h4>
</div>
<div id="aurreratuaB" style="display:none">
  <h4 style="cursor:hand; cursor:pointer;" onclick="erakutsiEzkutatu();">Bilaketa arrunta...</h4>
</div>
</form><br>
</div>
<br><br>


<!--ESKAERAK-->
<center>
<table width=90% class="zerrenda">
  <thead>
    <tr><td colspan=5><b><?php echo count($eskaerak) ?> eskaera topatu dira:</b></td>
  </thead>
  <tbody>
    <tr>
      <th class=ezker>Kodea</th>
      <th class=ezker>Irekitze data</th>
      <th class=ezker>Mota</th>
      <th class=ezker>Laburpena</th>
      <th class=ezker>Egoera</th>
      <th class=ezker><!--Azkenekoz aldatua--></th>
    </tr>
    <?php foreach ($eskaerak as $eskaera): ?>
    <tr <?php echo 'id="lehen1"';?> >
      <td><a href="<?php echo url_for('gertakaria/show?id='.$eskaera->getId()) ?>"><?php echo $eskaera->getId() ?></a></td>
      <td><a href="<?php echo url_for('gertakaria/show?id='.$eskaera->getId()) ?>"><?php echo $eskaera->getCreatedAt() ?></a></td>
      <td><a href="<?php echo url_for('gertakaria/show?id='.$eskaera->getId()) ?>"><?php echo $eskaera->getMota() ?></a></td>
      <td class="ezker"><a href="<?php echo url_for('gertakaria/show?id='.$eskaera->getId()) ?>"><?php echo $eskaera->getLaburpena() ?></a></td>
<?php $kol=$eskaera->getEgoeraKolorea(); ?>
      <td <?php echo "bgcolor='".$kol[0]->getKolorea()."'"; ?>><a href="<?php echo url_for('gertakaria/show?id='.$eskaera->getId()) ?>">
<?php echo $eskaera->getEgoera() ?></a></td>
      <td><a href="<?php //echo url_for('gertakaria/show?id='.$eskaera->getId()) ?>"><?php //echo $eskaera->getUpdatedAt() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</center>



<br><br>
<!-- ZERRENDA -->
<center>
<table width=90% class="zerrenda">
  <thead>
    <tr><td colspan=5><b><?php echo count($pager->getCountQuery()) ?> gertakari topatu dira:</b></td>
    <td align=right NOWRAP><a class="boton" href="<?php echo url_for('gertakaria/new') ?>">Gertakaria Sortu</a></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th class=ezker>Kodea</th>
      <th class=ezker>Irekitze data</th>
      <th class=ezker>Mota</th>
      <th class=ezker>Laburpena</th>
      <th class=ezker>Egoera</th>
<!--      <th>Langilea</th> -->
      <th class=ezker>Azkenekoz aldatua</th>
    </tr>
    <?php //foreach ($gertakarias as $gertakaria): ?>
    <?php foreach ($pager->getResults() as $gertakaria): ?>
    <tr <?php echo 'id="lehen'.$gertakaria->getLehentasunaId().'"';?> >
      <td><a href="<?php echo url_for('gertakaria/show?id='.$gertakaria->getId()) ?>"><?php echo $gertakaria->getId() ?></a></td>
      <td><a href="<?php echo url_for('gertakaria/show?id='.$gertakaria->getId()) ?>"><?php echo $gertakaria->getCreatedAt() ?></a></td>
      <td><a href="<?php echo url_for('gertakaria/show?id='.$gertakaria->getId()) ?>"><?php echo $gertakaria->getMota() ?></a></td>
      <td class="ezker"><a href="<?php echo url_for('gertakaria/show?id='.$gertakaria->getId()) ?>"><?php echo $gertakaria->getLaburpena() ?></a></td>
<?php $kol=$gertakaria->getEgoeraKolorea(); ?>
      <td <?php echo "bgcolor='".$kol[0]->getKolorea()."'"; ?>><a href="<?php echo url_for('gertakaria/show?id='.$gertakaria->getId()) ?>">
<?php echo $gertakaria->getEgoera() ?></a></td>
<!--      <td><?php //if ($gertakaria->getLangileaId()) {echo $gertakaria->getLangilea();} ?></td> -->
      <td><a href="<?php echo url_for('gertakaria/show?id='.$gertakaria->getId()) ?>"><?php echo $gertakaria->getUpdatedAt() ?></a></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
	<tr><td colspan=5 align=right>
<!--	    <a id="berria" href="<?php //echo url_for('gertakaria/new') ?>">Gertakaria sortu</a> -->
	</td><td align=right>
            <a class="boton" href="<?php echo url_for('gertakaria/new') ?>">Gertakaria Sortu</a>
	</td></tr>
  </tfoot>
</table>
<?php echo pager_navigation($pager, 'gertakaria/index') ?>

</center>



<!-- <a name="mapa"></a> -->
<!-- <a target=_blank href="<?php //echo url_for('gertakaria/mapa?page='.$pager->getPage()); ?>">proba</a> -->




<br><br>
<!-- MAPA orri berri batean irekitzeko. Helbidea begiratu behar da! -->
<center>
<a href="#" <?php echo 'onClick=window.open("gertakaria/mapa?page='.$pager->getPage().
//                                url_for('/gertakaria/mapa?page='.$pager->getPage()).
                                '","Planoa","width=800,height=600,scroll=yes")';
                                ?> ><img src="/images/Planoa.png"></a>
</center>

