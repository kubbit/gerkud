<div>
	<script type="text/javascript"><!--
onload = function()
{
	IzkutatuFiltroak();
}
$(document).ready(function()
{
	$("#taula").tablesorter({sortList: [[0,0]],
	textExtraction: function(node)
	{
		if (node.hasAttribute('title'))
			return node.getAttribute('title');
		else
			return node.innerHTML;
	}});
}
);
function IzkutatuFiltroak()
{
	var taula = document.getElementById("datuak_taula");
	var tartea = document.getElementById("tartea");
	var saila = document.getElementById("saila");

	switch (Number(taula.value))
	{
		case 1:
			saila.style.display = '';
			tartea.style.display = '';
			break;
		case 2:
			saila.style.display = 'none';
			tartea.style.display = 'none';
			break;
		case 3:
			saila.style.display = '';
			tartea.style.display = 'none';
			break;
	}
}
	--></script>
	<form action="<?php echo url_for('datuak/index'); ?>" method="post" class="bilaketa_form hilarak">
		<div id="taula_mota">
			<label for="datuak[taula]"><?php echo __('Taula mota'); ?></label>
			<?php echo $datuakForm['taula']->render(array('onchange' => 'IzkutatuFiltroak()')); ?>
		</div>
		<div id="hasiera">
			<label for="datuak[hasiera]"><?php echo __('Hasiera'); ?></label>
			<?php echo $datuakForm['hasiera']->render(); ?>
		</div>
		<div id="amaiera">
			<label for="datuak[amaiera]"><?php echo __('Amaiera'); ?></label>
			<?php echo $datuakForm['amaiera']->render(); ?>
		</div>
		<div id="tartea">
			<label id="lb_datuak_tartea" for="datuak[Tartea]"><?php echo __('Tartea'); ?></label>
			<?php echo $datuakForm['tartea']->render(); ?>
		</div>
		<div id="saila">
			<label id="lb_datuak_saila" for="datuak[saila]"><?php echo __('Saila'); ?></label>
			<?php echo $datuakForm['saila']->render(); ?>
		</div>
		<div id="onartu">
			<label for="datuak[onartu]"></label>
			<input id="datuak[onartu]" type="submit" value="<?php echo __('Onartu')?>" />
		</div>
	</form>
<?php if ($taula != null): ?>
	<div class="taula">
		<p><?php echo $titulua ?></p>
		<table id="taula" class="tablesorter">
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
	</div>
<?php endif; ?>
</div>