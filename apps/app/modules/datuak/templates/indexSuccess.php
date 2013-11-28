<div>
	<form action="<?php echo url_for('datuak/index'); ?>" method="post" class="bilaketa_form hilarak">
		<div id="taula_mota">
			<label for="datuak_taula"><?php echo __('Taula mota'); ?></label>
			<?php echo $datuakForm['taula']->render(array('autofocus' => 'autofocus', 'onchange' => 'IzkutatuFiltroak()')); ?>
			<span class="errorea"><?php echo __($datuakForm['taula']->getError()); ?></span>
		</div>
		<div id="hasiera">
			<label for="datuak_hasiera"><?php echo __('Hasiera'); ?></label>
			<?php echo $datuakForm['hasiera']->render(); ?>
			<span class="errorea"><?php echo __($datuakForm['hasiera']->getError()); ?></span>
		</div>
		<div id="amaiera">
			<label for="datuak_amaiera"><?php echo __('Amaiera'); ?></label>
			<?php echo $datuakForm['amaiera']->render(); ?>
			<span class="errorea"><?php echo __($datuakForm['amaiera']->getError()); ?></span>
		</div>
		<div id="tartea">
			<label id="lb_datuak_tartea" for="datuak_tartea"><?php echo __('Tartea'); ?></label>
			<?php echo $datuakForm['tartea']->render(); ?>
			<span class="errorea"><?php echo __($datuakForm['tartea']->getError()); ?></span>
		</div>
		<div id="saila">
			<label id="lb_datuak_saila" for="datuak_saila"><?php echo __('Saila'); ?></label>
			<?php echo $datuakForm['saila']->render(); ?>
			<span class="errorea"><?php echo __($datuakForm['saila']->getError()); ?></span>
		</div>
		<div id="jatorrizkosaila">
			<label id="lb_datuak_jatorrizkosaila" for="datuak_jatorrizkosaila"><?php echo __('Jatorrizko Saila'); ?></label>
			<?php echo $datuakForm['jatorrizkosaila']->render(); ?>
			<span class="errorea"><?php echo __($datuakForm['jatorrizkosaila']->getError()); ?></span>
		</div>
		<div id="onartu">
			<label for="datuak_onartu"></label>
			<input id="datuak_onartu" type="submit" value="<?php echo __('Onartu')?>" />
		</div>
	</form>
<?php if (isset($taula)): ?>
	<table id="taula" class="taula tablesorter">
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
	</table>
<?php endif; ?>
</div>