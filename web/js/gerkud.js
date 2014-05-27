var puntuBerria = null;
var infoLeihoa = null;

function click_coord(event)
{
	if (!google || !map)
		return;

	if (puntuBerria !== null)
	{
		// ezabatu aurreko puntua
		puntuBerria.setMap(null);
		puntuBerria = null;

		return;
	}

	var puntua = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
	puntuBerria = new google.maps.Marker
	({
			position: puntua,
			map: map,
			icon: 'http://chart.googleapis.com/chart?chst=d_map_xpin_icon_withshadow&chld=pin_star|glyphish_location|ff6600|ffff66'
	});

	infoLeihoa = new google.maps.InfoWindow();
	google.maps.event.addListener(infoLeihoa, 'closeclick', function()
	{
		// ezabatu puntua leihoa ixterakoan
		puntuBerria.setMap(null);
		puntuBerria = null;
	});
	google.maps.event.addListener(infoLeihoa, 'domready', function()
	{
		document.getElementById('geo_latitudea').value = event.latLng.lat();
		document.getElementById('geo_longitudea').value = event.latLng.lng();
		document.getElementById('geo_testua').focus();
	});

	infoLeihoa.setContent(puntuBerriaForm);
	infoLeihoa.open(map, puntuBerria);
}

onload = function()
{
	orriak();

	erakutsiMenua();
	erakutsiEkintzak();
	erakutsiErroreak();

	// Datuak modulua
 	IzkutatuFiltroak();
	EzarriTableSorter();

	estekakSortu();
	autofocus();
};

function erakutsiErroreak()
{
	var erroreak = document.getElementById('erroreak');
	if (!erroreak)
		return;

	erroreak.setAttribute('class', 'erroreak');

	var zerrenda = erroreak.getElementsByTagName("li");
	for (var i = 0; i < zerrenda.length; i++)
	{
		var erroreaId = zerrenda[i].getAttribute('title');
		var eremua = document.getElementById(erroreaId);
		if (!eremua)
			continue;

		eremua.className += " " + 'errorea';
	}

	// IE8-an erroreak izkutatu denbora pasatzean
	setTimeout(function()
	{
		erroreak.setAttribute('style', 'display: none');
	}, 5 * 1000);
}

function erakutsiMenua()
{
	var botoia = document.getElementById('navIreki');
	var menua = document.getElementById('nav');
	if (!botoia || !menua)
		return;

	botoia.innerHTML = '<img src="/images/asc.gif" alt="Menua ireki" />';
	botoia.onclick = function()
	{
		if (menua.style.display === '' || menua.style.display === 'none')
		{
			menua.style.display = 'block';
			botoia.innerHTML = '<img src="/images/desc.gif" alt="Menua ireki" />';
		}
		else
		{
			menua.removeAttribute('style');
			botoia.innerHTML = '<img src="/images/asc.gif" alt="Menua itxi" />';
		}
	};
}

function erakutsiEkintzak()
{
	var botoia = document.getElementById('ekintzakIreki');
	var menua = document.getElementById('ekintzak');
	if (!botoia || !menua)
		return;

	botoia.innerHTML = '<img src="/images/desc.gif" alt="Ekintzak ireki" />';
	botoia.onclick = function()
	{
		if (menua.style.display === '' || menua.style.display === 'none')
		{
			menua.style.display = 'block';
			botoia.innerHTML = '<img src="/images/asc.gif" alt="Ekintzak ireki" />';
		}
		else
		{
			menua.removeAttribute('style');
			botoia.innerHTML = '<img src="/images/desc.gif" alt="Ekintzak itxi" />';
		}
	};
}

function EzarriTableSorter()
{
	$("#taula").tablesorter({sortList: [[0,0]]});
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

/*
 * Tauletan <tr> hilara osoa estekan bihurtu lehen <td>-ak esteka badu
 */
function estekakSortu()
{
	var trs = document.getElementsByTagName('tr');

	for (var i = 0; i < trs.length; i++)
	{
		var tr = trs[i];
		if (tr.children.length > 0 && tr.children[0].tagName.toLowerCase() === 'td')
		{
			var td = tr.children[0];
			if (td.children.length > 0 && td.children[0].tagName.toLowerCase() === 'a')
			{
				var a = td.children[0];
				tr.href = a.getAttribute('href');

				// kurtsorea aldatzeko klasea ezarri
				tr.className += ' esteka';

				// klik egiterakoan esteka ireki
				tr.onclick = function()
				{
					window.location = this.href;
				};
			}
		}

	}
}

/*
 * Internet Explorer-en bertsio zaharretan autofocus atributoa erabiltzeko
 */
function autofocus()
{
	// begiratu ea arakatzaileak HTML5-ko 'autofocus' atributoa duen
	var input = document.createElement('input');
	if ('autofocus' in input)
		return;

	var elements = ['input', 'textarea'];
	for (var iElement = 0; iElement < elements.length; iElement++)
	{
		var inputs = document.getElementsByTagName(elements[iElement]);

		for (var i = 0; i < inputs.length; i++)
		{
			if (inputs[i].getAttribute('autofocus'))
			{
				inputs[i].focus();
				return;
			}
		}
	}
}

var GERTAKARI_ORRIAK = new Array('gertakaria', 'iruzkina', 'fitxategiak', 'erlazioak', 'historikoa', 'planoa');

window.onhashchange = function()
{
	var aukeratuta;
	if (window.location.hash)
		aukeratuta = window.location.hash.substring(1);

	var aukeratutakoOrria = document.getElementById('tab' + aukeratuta);
	erakutsiEzkutatuOrriak(aukeratutakoOrria);
};

function orriak()
{
	var orriak = document.getElementById('orriak');
	if (!orriak)
		return;

	for (var iOrria = 0; iOrria < GERTAKARI_ORRIAK.length; iOrria++)
	{
		var orria = document.getElementById('tab' + GERTAKARI_ORRIAK[iOrria]);
		orria.onclick = function()
		{
			erakutsiEzkutatuOrriak(this);
		};
	}

	var aukeratuta = '#' + GERTAKARI_ORRIAK[0];;
	if (window.location.hash)
		aukeratuta = window.location.hash;
	window.location = aukeratuta;
	window.onhashchange();
}
function erakutsiEzkutatuOrriak(aukeratuta)
{
	if (!aukeratuta)
		return;

	for (var iOrria = 0; iOrria < GERTAKARI_ORRIAK.length; iOrria++)
	{
		var tab = document.getElementById('tab' + GERTAKARI_ORRIAK[iOrria]);
		var orria = document.getElementById('eduk' + GERTAKARI_ORRIAK[iOrria]);
		if (GERTAKARI_ORRIAK[iOrria] === aukeratuta.title)
		{
			tab.setAttribute('data-aukeratuta', 'true');
			orria.style.display = 'block';
		}
		else
		{
			tab.setAttribute('data-aukeratuta', 'false');
			orria.style.display = 'none';
		}
	}

	if (aukeratuta.title === 'planoa' && window.initialize)
	{
		initialize();
		google.maps.event.trigger(map, 'resize');
	}

	window.location = '#' + aukeratuta.title;
}