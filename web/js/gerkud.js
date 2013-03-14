function erakutsiEzkutatuBilaketa()
{
	var erakutsiBilaketa = document.getElementById('erakutsiBilaketa');
	var bilaketa = document.getElementById('bilaketa');

	if (bilaketa.style.display == 'none')
	{
		bilaketa.style.display = 'inherit';
		erakutsiBilaketa.style.display = 'none';
	}
	else
	{
		bilaketa.style.display = 'none';
		erakutsiBilaketa.style.display = 'inherit';
	}
}
function erakutsiEzkutatuAurreratua()
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

onload = function()
{
	var erakutsiBilaketa = document.getElementById('erakutsiBilaketa');
	if (erakutsiBilaketa)
	{
		erakutsiBilaketa.onclick = function()
		{
			erakutsiEzkutatuBilaketa();
		}
	}
	var ezkutatuBilaketa = document.getElementById('ezkutatuBilaketa');
	if (ezkutatuBilaketa)
	{
		ezkutatuBilaketa.onclick = function()
		{
			erakutsiEzkutatuBilaketa();
		}
	}

	// Datuak modulua
 	IzkutatuFiltroak();
	EzarriTableSorter();
};
function EzarriTableSorter()
{
	$("#taula").tablesorter({sortList: [[0,0]],
	textExtraction: function(node)
	{
		if (node.hasAttribute('title'))
			return node.getAttribute('title');
		else
			return node.innerHTML;
	}});
};
function IzkutatuFiltroak()
{
	var taula = document.getElementById("datuak_taula");
	var tartea = document.getElementById("tartea");
	var saila = document.getElementById("saila");

	if (!taula)
		return;

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
