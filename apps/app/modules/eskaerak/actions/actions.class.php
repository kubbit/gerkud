<?php

/**
 * eskaerak actions.
 *
 * @package    gerkud
 * @subpackage eskaerak
 * @author     Pasaiako Udala
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class eskaerakActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$e = Doctrine_Core::getTable('Gertakaria')->getEskaerak();
		$this->eskaerak = $e->execute();

		$this->zutabeakConfig = sfConfig::get('app_zutabeak_eskaerak');
		$this->zutabeak = array();
		$this->eskaerenZutabeakSortu();

		$this->datuak = $this->eskaerenDatuakSortu($this->eskaerak);
	}

	public function eskaerenZutabeakSortu()
	{
		foreach ($this->zutabeakConfig as $bakoitza)
		{
			$zutabea = new stdClass();
			switch($bakoitza)
			{
				case 'id':
					$zutabea->izena = __('Id');
					$zutabea->klasea = 'id';
					break;
				case 'laburpena':
					$zutabea->izena = __('Laburpena');
					$zutabea->klasea = 'laburpena';
					break;
				case 'klasea':
					$zutabea->izena = __('Klasea');
					$zutabea->klasea = 'klasea';
					break;
				case 'mota':
					$zutabea->izena = __('Mota');
					$zutabea->klasea = 'mota';
					break;
				case 'azpimota':
					$zutabea->izena = __('Azpimota');
					$zutabea->klasea = 'azpimota';
					break;
				case 'abisuanork':
					$zutabea->izena = __('Abisua nork');
					$zutabea->klasea = 'abisuanork';
					break;
				case 'egoera':
					$zutabea->izena = __('Egoera');
					$zutabea->klasea = 'egoera';
					break;
				case 'saila':
					$zutabea->izena = __('Saila');
					$zutabea->klasea = 'saila';
					break;
				case 'langilea':
					$zutabea->izena = __('Langilea');
					$zutabea->klasea = 'langilea';
					break;
				case 'barrutia':
					$zutabea->izena = __('Barrutia');
					$zutabea->klasea = 'barrutia';
					break;
				case 'auzoa':
					$zutabea->izena = __('Auzoa');
					$zutabea->klasea = 'auzoa';
					break;
				case 'kalea':
					$zutabea->izena = __('Kalea');
					$zutabea->klasea = 'kalea';
					break;
				case 'kale_zbkia':
					$zutabea->izena = __('Zbk.');
					$zutabea->klasea = 'kale_zbkia';
					break;
				case 'deskribapena':
					$zutabea->izena = __('Deskribapena');
					$zutabea->klasea = 'deskribapena';
					break;
				case 'ixte_data':
					$zutabea->izena = __('Ixte data');
					$zutabea->klasea = 'ixte_data';
					break;
				case 'hasiera_aurreikusia':
					$zutabea->izena = __('Hasiera aurreikusia');
					$zutabea->klasea = 'hasiera_aurreikusia';
					break;
				case 'amaiera_aurreikusia':
					$zutabea->izena = __('Amaiera aurreikusia');
					$zutabea->klasea = 'amaiera_aurreikusia';
					break;
				case 'lehentasuna':
					$zutabea->izena = '';
					$zutabea->klasea = 'lehentasuna';
					break;
				case 'jatorrizkosaila':
					$zutabea->izena = __('Jatorrizko saila');
					$zutabea->klasea = 'jatorrizkosaila';
					break;
				case 'eraikina':
					$zutabea->izena = __('Eraikina');
					$zutabea->klasea = 'eraikina';
					break;
				case 'created_at':
					$zutabea->izena = __('Irekiera');
					$zutabea->klasea = 'created_at';
					break;
				case 'updated_at':
					$zutabea->izena = __('Aldatuta');
					$zutabea->klasea = 'updated_at';
					break;
				case 'eraikinakalea':
					$zutabea->izena = __('Kalea') . ' / ' . __('Eraikina');
					$zutabea->klasea = 'eraikinakalea';
					break;
			}
			array_push($this->zutabeak, $zutabea);
		}
	}

	public function eskaerenDatuakSortu($cursor)
	{
		$datuak = array();

		foreach ($cursor as $fila)
		{
			$ilara = new stdClass();
			$ilara->estekaId = $fila->getId();
			$ilara->datuak = array();

			foreach ($this->zutabeakConfig as $bakoitza)
			{
				$balioa = '';
				switch($bakoitza)
				{
					case 'id':
						$balioa = $fila->getId();
						break;
					case 'laburpena':
						$balioa = $fila->getLaburpena();
						break;
					case 'klasea':
						$balioa = $fila->getKlasea();
						break;
					case 'mota':
						$balioa = $fila->getMota();
						break;
					case 'azpimota':
						$balioa = $fila->getAzpimota();
						break;
					case 'abisuanork':
						$balioa = $fila->getAbisuaNork();
						break;
					case 'egoera':
						$balioa = $fila->getEgoera();
						break;
					case 'saila':
						$balioa = $fila->getSaila();
						break;
					case 'langilea':
						$balioa = $fila->getLangilea();
						break;
					case 'barrutia':
						$balioa = $fila->getBarrutia();
						break;
					case 'auzoa':
						$balioa = $fila->getAuzoa();
						break;
					case 'kalea':
						$balioa = $fila->getKalea();
						break;
					case 'kale_zbkia':
						$balioa = $fila->getKaleZbkia();
						break;
					case 'deskribapena':
						$balioa = $fila->getDeskribapena();
						break;
					case 'ixte_data':
						$balioa = date(sfConfig::get('app_data_formatoa'), strtotime($fila->getIxteData()));
						break;
					case 'hasiera_aurreikusia':
						$balioa = $fila->getHasieraAurreikusia();
						break;
					case 'amaiera_aurreikusia':
						$balioa = $fila->getAmaieraAurreikusia();
						break;
					case 'lehentasuna':
						switch ($fila->getLehentasunaId())
						{
							case 1:
								$balioa = '';
								break;
							case 2:
								$balioa = '!';
								break;
							case 3:
								$balioa = '!!';
								break;
							default:
								$balioa = '';
								break;
						}
						break;
					case 'jatorrizkosaila':
						$balioa = $fila->getJatorrizkoSaila();
						break;
					case 'eraikina':
						$balioa = $fila->getEraikina();
						break;
					case 'created_at':
						$balioa = date(sfConfig::get('app_data_formatoa'), strtotime($fila->getCreatedAt()));
						break;
					case 'updated_at':
						$balioa = date(sfConfig::get('app_data_formatoa'), strtotime($fila->getUpdatedAt()));
						break;
					case 'eraikinakalea':
						if ($fila->getEraikinaId())
						{
							$balioa = $fila->getEraikina();
						}
						else if ($fila->getKaleaId())
						{
							$balioa = $fila->getKalea() . ', ' . $fila->getKaleZbkia();
						}
						else
						{
							$balioa = '';
						}
						break;
				}
				$ilara->datuak[$bakoitza] = $balioa;
			}
			array_push($datuak, $ilara);
		}
		return $datuak;
	}
}