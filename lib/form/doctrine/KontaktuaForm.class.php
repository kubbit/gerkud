<?php

/**
 * Kontaktua form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class KontaktuaForm extends BaseKontaktuaForm
{
	public function configure()
	{
		$configDerrigorrezkoak = sfConfig::get('app_gerkud_derrigorrezkoak');
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$this->validatorSchema['izena'] = new sfValidatorString(array
		(
			'required' => (in_array('kontaktua_izena', $configDerrigorrezkoak)) ? true : false
		));
		$this->validatorSchema['abizenak'] = new sfValidatorString(array
		(
			'required' => (in_array('kontaktua_abizenak', $configDerrigorrezkoak)) ? true : false
		));
		$this->validatorSchema['nan'] = new sfValidatorString(array
		(
			'required' => (in_array('kontaktua_nan', $configDerrigorrezkoak)) ? true : false
		));
		$this->validatorSchema['posta'] = new sfValidatorString(array
		(
			'required' => (in_array('kontaktua_posta', $configDerrigorrezkoak)) ? true : false
		));
		$this->validatorSchema['telefonoa'] = new sfValidatorString(array
		(
			'required' => (in_array('kontaktua_telefonoa', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['ohartarazi'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'KontaktuaOhartaraztea',
			'add_empty' => '--',
			'query' => Doctrine_Core::getTable('KontaktuaOhartaraztea')->createQuery('k')
				->leftJoin('k.Translation t WITH t.lang = ?', $culture)
				->orderBy('isnull(k.ordena), k.ordena, t.modua ASC'),
			'order_by' => array('modua', 'ASC')
		));

		$this->validatorSchema['ohartarazi'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'KontaktuaOhartaraztea',
			'required' => (in_array('kontaktua_ohartarazi', $configDerrigorrezkoak)) ? true : false
		));

		$this->validatorSchema->setPostValidator
		(
			new sfValidatorCallback(array('callback' => array($this, 'postValidate')))
		);
	}

	public function postValidate($validator, $values)
	{
		if ($values["nan"] != null && !$this->balidatuNAN($values["nan"]))
		{
			$error = new sfValidatorError($validator, "NAN ez da zuzena");
			throw new sfValidatorErrorSchema($validator, array('nan' => $error));
		}

		if ($values["posta"] != null && !$this->balidatuPosta($values["posta"]))
		{
			$error = new sfValidatorError($validator, "Posta elektronikoa ez da zuena");
			throw new sfValidatorErrorSchema($validator, array('posta' => $error));
		}

		return $values;
	}

	protected function balidatuNAN($nan)
	{
		$ONARTUTAKO_HIZKIAK = 'TRWAGMYFPDXBNJZSQVHLCKE';

		if (strlen($nan) != 9)
			return false;

		$nan = strtoupper($nan);

		$hizkia = substr($nan, -1, 1);
		$zkia = substr($nan, 0, 8);

		// Atzerritarren NAN
		$zkia = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $zkia);

		$hondarra = $zkia % 23;
		$hizki_zuzena = substr($ONARTUTAKO_HIZKIAK, $hondarra, 1);

		if ($hizki_zuzena != $hizkia)
			return false;

		return true;
	}

	protected function balidatuPosta($posta)
	{
		return filter_var($posta, FILTER_VALIDATE_EMAIL);
  	}
}
