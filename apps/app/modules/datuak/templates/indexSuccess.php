<div>
	<form action="<?php echo url_for('datuak/index'); ?>" method="post" class="bilaketa_form hilarak">
		<div id="taula_mota">
			<label for="datuak_taula"><?php echo __('Taula mota'); ?></label>
			<?php echo $datuakForm['taula']->render(array('onchange' => 'IzkutatuFiltroak()')); ?>
		</div>
		<div id="hasiera">
			<label for="datuak_hasiera_year"><?php echo __('Hasiera'); ?></label>
			<?php echo $datuakForm['hasiera']->render(); ?>
		</div>
		<div id="amaiera">
			<label for="datuak_amaiera_year"><?php echo __('Amaiera'); ?></label>
			<?php echo $datuakForm['amaiera']->render(); ?>
		</div>
		<div id="tartea">
			<label id="lb_datuak_tartea" for="datuak_tartea"><?php echo __('Tartea'); ?></label>
			<?php echo $datuakForm['tartea']->render(); ?>
		</div>
		<div id="saila">
			<label id="lb_datuak_saila" for="datuak_saila"><?php echo __('Saila'); ?></label>
			<?php echo $datuakForm['saila']->render(); ?>
		</div>
		<div id="onartu">
			<label for="datuak_onartu"></label>
			<input id="datuak_onartu" type="submit" value="<?php echo __('Onartu')?>" />
		</div>
	</form>
<?php if ($taula != null): ?>
	<table id="taula" class="taula tablesorter">
		<caption><?php echo $titulua ?></caption>
		<thead>
			<tr>
	<?php for ($i = 0; $i < count($goiburuak); $i++): ?>
				<th title="<?php echo $argibideak[$i] ?>"><?php echo $goiburuak[$i] ?></th>
	<?php endfor; ?>
			</tr>
		</thead>
		<tbody>
	<?php for ($i = 0; $i < count($datuak); $i++): ?>
			<tr>
		<?php foreach ($datuak[$i] as $datu): ?>
			<?php
				if(is_numeric($datu))
					echo "<td>" . round($datu, 2) . "</td>";
				else
					echo "<td title='" . $i . "'>" . $datu . "</td>";
			?>
		<?php endforeach; ?>
			</tr>
	<?php endfor; ?>
		</tbody>
		<tfoot>
			<tr>
	<?php foreach ($oina AS $oin): ?>
				<td>
		<?php
			if(is_numeric($oin))
				echo round($oin, 2);
			else
				echo $oin;
		?>
				</td>
	<?php endforeach; ?>
			</tr>
		</tfoot>
	</table>
<?php endif; ?>
</div>