function erakutsiEzkutatuBilaketa()
{
	var bilaketa = document.getElementById('bilaketa');
	if (!bilaketa)
		return;

	if (bilaketa.style.display === 'none')
	{
		bilaketa.style.display = 'inherit';

		// kodean fokoa jarri
		var kodea = document.getElementById('gertakaria_filters_id');
		if (kodea)
			kodea.focus();
	}
	else
		bilaketa.style.display = 'none';

	// orri aldaketa saihestu
	if (event.preventDefault)
		event.preventDefault();
	else
		event.returnValue = false;
}
function erakutsiEzkutatuAurreratua()
{
	if (document.getElementById('aurreratua').style.display === 'none')
	{
		document.getElementById('aurreratua').style.display = 'block';
		document.getElementById('arrunta').style.display = 'none';
		document.getElementById('aurreratuaB').style.display = 'block';
	}
	else if (document.getElementById('aurreratua').style.display === 'block')
	{
		document.getElementById('aurreratua').style.display = 'none';
		document.getElementById('arrunta').style.display = 'block';
		document.getElementById('aurreratuaB').style.display = 'none';
	}
}

function mapaErakutsi()
{
	if (document.getElementById('geolokalizazioa').style.display === 'none')
	{
		document.getElementById('geolokalizazioa').style.display = 'block';
		document.getElementById('plano_icon').style.display = 'none';

		if (map === null)
			initialize();
		google.maps.event.trigger(map, 'resize');
	}
	else if (document.getElementById('geolokalizazioa').style.display === 'block')
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
		};
	}
	var ezkutatuBilaketa = document.getElementById('ezkutatuBilaketa');
	if (ezkutatuBilaketa)
	{
		// kodean fokoa jarri
		var kodea = document.getElementById('gertakaria_filters_id');
		if (kodea)
			kodea.focus();

		ezkutatuBilaketa.onclick = function()
		{
			erakutsiEzkutatuBilaketa();
		};
	}

	var erakutsiPlanoa = document.getElementById('erakutsiPlanoa');
	if (erakutsiPlanoa)
	{
		erakutsiPlanoa.onclick = function()
		{
			mapaErakutsi();
		};
	}
	var ezkutatuPlanoa = document.getElementById('ezkutatuPlanoa');
	if (ezkutatuPlanoa)
	{
		ezkutatuPlanoa.onclick = function()
		{
			mapaErakutsi();
		};
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
	var jatorrizkosaila = document.getElementById("jatorrizkosaila");
	var aukera = document.getElementById("datuak_jatorrizkosaila");

	if (!taula)
		return;

	switch (Number(taula.value))
	{
		case 1:
			saila.style.display = '';
			tartea.style.display = '';
			jatorrizkosaila.style.display = '';
			break;
		case 2:
			saila.style.display = 'none';
			tartea.style.display = 'none';
			jatorrizkosaila.style.display = '';
			break;
		case 3:
			saila.style.display = '';
			tartea.style.display = 'none';
			jatorrizkosaila.style.display = '';
			break;
		case 4:
			saila.style.display = '';
			tartea.style.display = 'none';
			jatorrizkosaila.style.display = 'none';
			break;
	}
}
