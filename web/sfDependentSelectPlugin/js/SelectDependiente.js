/*!
 *
 * This file is part of the sfDependentSelect package.
 * (c) 2010 Sergio Flores <sercba@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *******************************************************************************
 *
 * 2013/05/23 - Rewritten by Kubbit Information Technology (http://kubbit.com)
 *
 * There was a wrong assumption in the ordering of object lists in the code,
 * and all browsers have changed behaviour since then.
 * This caused an incorrect sorting of the list items:
 *
 * http://code.google.com/p/v8/issues/detail?id=164
 * http://wiki.ecmascript.org/doku.php?id=strawman:enumeration
 */
var SelectDependiente = function(config)
{
	if (this.instancias[config.id] instanceof SelectDependiente)
		return this.instancias[config.id];

	this.instancias[config.id] = this;

	defecto =
	{
		id:          '',
		opciones:    {},
		dependiente: '',
		vacio:       false,
		ajax:        false,
		cache:       true,
		url:         '',
		params:      {},
		varref:      '_ref',
		varsoloref:  '_solo_ref'
	};

	for (var item in defecto)
		this[item] = typeof config[item] === 'undefined' ? defecto[item] : config[item];

	this.select = document.getElementById(this.id);

	if (typeof this.dependiente === 'string' && this.dependiente.length > 0)
	{
		this.dependiente = document.getElementById(this.dependiente);

		if (!this.dependiente.lista)
			this.dependiente.lista = new Array();

		this.dependiente.lista.push(this);

		this.dependiente.onchange = function()
		{
			for (var i in this.lista)
				this.lista[i].cambio(this.value);
		};

		this.cambio(this.dependiente.value);
	}

	return this;
};

SelectDependiente.prototype.instancias = [];

SelectDependiente.prototype.cambio = function(valor)
{
	this.limpiar();
	for (var iGrupo in this.opciones)
	{
		var grupo = this.opciones[iGrupo];
		if (grupo.id == valor)
		{
			this.generarLista(grupo);
			break;
		}
	}
};

SelectDependiente.prototype.generarLista = function(grupo)
{
	for (var iOpcion in grupo.list)
	{
		var opcion = grupo.list[iOpcion];
		this.agregarOpcion(opcion.id, opcion.value);
	}
};

SelectDependiente.prototype.agregarOpcion = function(valor, texto)
{
	var opcion = document.createElement('option');
	opcion.text = texto;
	opcion.value = valor;

	try
	{
		this.select.add(opcion, null);
	}
	catch(ex)
	{
		this.select.add(opcion);
	}
};

SelectDependiente.prototype.limpiar = function()
{
	while (this.select.options.length)
		this.select.remove(0);

	if (this.vacio !== false)
		this.agregarOpcion('', this.vacio);
};

SelectDependiente.prototype.seleccionar = function(valor)
{
	this.cambio(this.dependiente.value);
	this.select.value = valor;
};
