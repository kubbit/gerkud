<?php if($datuakForm->hasErrors() || $datuakForm->hasGlobalErrors()): ?>
<ul id="erroreak">
	<?php foreach($datuakForm->getGlobalErrors() as $name => $error): ?>
	<li><?php echo $name; ?>: <?php echo $error; ?></li>
	<?php endforeach; ?>

	<?php foreach($datuakForm->getErrorSchema()->getErrors() as $name => $error): ?>
	<li title="<?php echo $name; ?>"><?php echo __($error); ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<form class="panela" action="<?php echo url_for('datuak/index'); ?>" method="post">
	<fieldset>
		<fieldset>
			<div id="taula_mota" class="field">
				<label for="datuak_taula"><?php echo __('Taula mota'); ?></label>
				<?php echo $datuakForm['taula']->render(array('autofocus' => 'autofocus', 'onchange' => 'IzkutatuFiltroak()')); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="hasiera" class="field">
				<label for="datuak_hasiera"><?php echo __('Hasiera'); ?></label>
				<?php echo $datuakForm['hasiera']->render(); ?>
			</div>
			<div id="amaiera" class="field">
				<label for="datuak_amaiera"><?php echo __('Amaiera'); ?></label>
				<?php echo $datuakForm['amaiera']->render(); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="tartea" class="field">
				<label id="lb_datuak_tartea" for="datuak_tartea"><?php echo __('Tartea'); ?></label>
				<?php echo $datuakForm['tartea']->render(); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="saila" class="field">
				<label id="lb_datuak_saila" for="datuak_saila"><?php echo __('Saila'); ?></label>
				<?php echo $datuakForm['saila']->render(); ?>
			</div>
		</fieldset>
		<fieldset>
			<div id="jatorrizkosaila" class="field">
				<label id="lb_datuak_jatorrizkosaila" for="datuak_jatorrizkosaila"><?php echo __('Jatorrizko Saila'); ?></label>
				<?php echo $datuakForm['jatorrizkosaila']->render(); ?>
			</div>
		</fieldset>
	</fieldset>
	<input id="datuak_onartu" type="submit" class="botoia" value="<?php echo __('Onartu')?>" />
</form>
<?php if (isset($taula)): ?>
<table id="taula" class="tablesorter">
	<caption><?php echo $titulua ?></caption>
	<thead>
		<tr>
	<?php for ($i = 0; $i < count($goiburuak); $i++): ?>
			<th title="<?php echo $argibideak[$i] ?>"><?php echo $goiburuak[$i] ?></th>
	<?php endfor; ?>
		</tr>
	</thead>
	<tfoot>
		<tr>
	<?php for ($i = 0; $i < count($oina); $i++): ?>
			<td title="<?php echo $goiburuak[$i]?>"><?php echo is_numeric($oina[$i]) ? round($oina[$i], 2) : $oina[$i]; ?></td>
	<?php endfor; ?>
		</tr>
	</tfoot>
	<tbody>
	<?php for ($iLerro = 0; $iLerro < count($datuak); $iLerro++): ?>
		<tr>
		<?php for ($iZutabe = 0; $iZutabe < count($datuak[$iLerro]); $iZutabe++): ?>
<?php
$dataLerro = '';
if ($iZutabe === 0)
	$dataLerro = sprintf('data-lerro="%s"', $iLerro);

if (is_numeric($datuak[$iLerro][$iZutabe]))
	$datua = round($datuak[$iLerro][$iZutabe], 2);
else
	$datua = $datuak[$iLerro][$iZutabe];
?>
			<td title="<?php echo $goiburuak[$iZutabe]; ?>" <?php echo $dataLerro; ?>><?php echo $datua; ?></td>
		<?php endfor; ?>
		</tr>
	<?php endfor; ?>
	</tbody>
</table>
<?php endif; ?>
