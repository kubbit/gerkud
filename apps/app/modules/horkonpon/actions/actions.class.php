<?php

/**
 * horkonpon actions.
 *
 * @package    gerkud
 * @subpackage horkonpon
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class horkonponActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$erantzuna = array();

		try
		{
			if (!$request->isMethod(sfRequest::POST))
				throw new Exception('Ez da informaziorik jaso');

			$json = $request->getParameter('datuak');

			$array = json_decode($json, true);
			if ($array === NULL)
				throw new Exception(sprintf('Mezua ez da zuzena: %s', $json));

			$pasahitza = $request->getParameter('pasahitza');
			$confPasahitza = sfConfig::get('app_horkonpon_pasahitza');
			if ($confPasahitza && $confPasahitza !== $pasahitza)
				throw new Exception('Atzipena ukatuta');

			$this->gertakaria = new Gertakaria();
			$this->gertakaria->setHerritarrena(true);

			$mota = sfConfig::get('app_gerkud_hiritarrena_mota_id');
			if ($mota !== NULL)
				$this->gertakaria->setMotaId($mota);

			$klasea = sfConfig::get('app_gerkud_hiritarrena_klasea_id');
			if ($klasea !== NULL)
				$this->gertakaria->setKlaseaId($klasea);

			$erabiltzaileDatuak = array();
			if (array_key_exists('izena', $array))
				array_push($erabiltzaileDatuak, $array['izena']);
			if (array_key_exists('telefonoa', $array))
				array_push($erabiltzaileDatuak, $array['telefonoa']);
			if (array_key_exists('posta', $array))
				array_push($erabiltzaileDatuak, $array['posta']);

			$this->gertakaria->setAbisuaNork(implode(', ', $erabiltzaileDatuak));
			if (array_key_exists('oharrak', $array))
			{
				$this->gertakaria->setLaburpena($array['oharrak']);
				$this->gertakaria->setDeskribapena($this->gertakaria->getLaburpena());
			}

			$langilea = null;
			$this->gertakaria->setLangilea($langilea);

			if (count($erabiltzaileDatuak) > 0)
			{
				$kontaktua = new Kontaktua();
				$kontaktua->setIzena($array['izena']);
				$kontaktua->setPosta($array['posta']);
				$kontaktua->setTelefonoa($array['telefonoa']);

				if (array_key_exists('ohartarazi', $array) && $array['ohartarazi'])
					$kontaktua->setOhartarazi($array['ohartarazi']);

				if (array_key_exists('hizkuntza', $array))
					$kontaktua->setHizkuntza($array['hizkuntza']);

				$this->gertakaria->setKontaktua($kontaktua);
			}

			if (array_key_exists('gps', $array))
			{
				$this->geo = new Geo();
				$this->geo->setGertakaria($this->gertakaria);
				$this->geo->setGeometriaId(1);
				$this->geo->setLatitudea($array['gps']['latitudea']);
				$this->geo->setLongitudea($array['gps']['longitudea']);
				$this->geo->setZehaztasuna($array['gps']['zehaztasuna']);

				if (array_key_exists('helbidea', $array))
				{
					$this->geo->setTestua($array['helbidea']);

					$kalea = Doctrine_Core::getTable('Kalea')->getKaleaGoogle($array['helbidea']);
					if ($kalea)
					{
						$this->gertakaria->setKalea($kalea);
						if ($kalea->getBarrutiaId())
							$this->gertakaria->setBarrutiaId($kalea->getBarrutiaId());
						if ($kalea->getAuzoaId())
							$this->gertakaria->setAuzoaId($kalea->getAuzoaId());
					}
				}

				$this->geo->save();
			}

			if (array_key_exists('argazkia', $array))
			{
				$this->fitxategia = new Fitxategia();
				$this->fitxategia->setGertakaria($this->gertakaria);
				$this->fitxategia->setFitxategia($array['argazkia']['izena']);
				$this->fitxategia->setEdukia($array['argazkia']['edukia']);
				$this->fitxategia->setLangilea($langilea);
				$this->fitxategia->save();
			}

			$this->gertakaria->save();

			$erantzuna['kodea'] = $this->gertakaria->getId();
		}
		catch (Exception $e)
		{
			$erantzuna['kodea'] = -1;
			$erantzuna['mezua'] = $e->getMessage();
		}

		echo json_encode($erantzuna);

		return;
	}
}
