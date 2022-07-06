<?php

/**
 * Iruzkina
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    gerkud
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class Iruzkina extends BaseIruzkina
{
	public function getGertakaria()
	{
		$q = Doctrine_Query::create()
		 ->from('Gertakaria g')
		 ->where('g.id = ?', $this->getGertakariaId());

		return $q->execute();
	}

	public function getSaila($sailaId)
	{
		$q = Doctrine_Query::create()
		 ->from('Saila s')
		 ->where('s.id = ?', $sailaId);

		return $q->execute();
	}

	public function save(Doctrine_Connection $conn = null)
	{
		$conn = $conn ? $conn : Doctrine_Core::getTable('Iruzkina')->getConnection();
		$conn->beginTransaction();
		try
		{
			$aldaketak = $this->state() !== Doctrine_Record::STATE_CLEAN;

			$ret = parent::save($conn);
			$conn->commit();

			if ($aldaketak)
				$this->ohartarazi();

			return $ret;
		}
		catch (Exception $e)
		{
//			$conn->rollBack();
			throw $e;
		}
	}

	protected function ohartarazi()
	{
		$gertakariak = $this->getGertakaria();
		$gertakaria = $gertakariak[0];

		$ekintza = __('Aldaketa');
		$aldaketa = '';
		$egoera_aldaketa = true;
		switch ($this->getEkintzaId())
		{
			case 1: //Iruzkina
				$ekintza = __('Iruzkina');
				$aldaketa = $this->getTestua();
				$egoera_aldaketa = false;
				break;
			case 2: //Esleipena
				$aldaketa = $this->getTestua();
				break;
			case 4: //Fitxategia
				$aldaketa = $this->getTestua();
				$egoera_aldaketa = false;
				break;
			case 3: //Berrirekitzea
				$aldaketa = __('Berrireki da');
				break;
			case 5: //Egoera aldatzea
				$aldaketa = __('%egoera% egoeran jarri da', array('%egoera%' => $gertakaria->getEgoera()));
				break;
			case 6: //Ixtea
				$aldaketa = __('Itxita');
				$gertakaria->ohartaraziKontaktua();
				break;
			default:
				return;
		}

		// mezu bikoiztuak ez bidaltzeko (adb. esleitzerakoan bi aldiz sartzen da funtzio honetan)
		if (empty($aldaketa))
			return;

		$langilea = $this->getLangilea();
		$nori = $gertakaria->getAbisuaNori($langilea, $egoera_aldaketa);
		$mezua = $gertakaria->mezuaSortu(Gertakaria::TXANTILOIA_FITXATEGIA_LANGILEAK, $langilea, $ekintza, $aldaketa);
		$gaia = sprintf('[%s #%d] %s (%s)', __('Gertakaria'), $gertakaria->getId(), $gertakaria->getLaburpena(), $this->getEkintza());

		$gertakaria->mezuaBidali($nori, $gaia, $mezua, true);
	}
}
