<?php

/**
 * Erlazioak form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ErlazioakForm extends BaseErlazioakForm
{
	public function configure()
	{
		$this->setWidgets(array
		(
			'id' => new sfWidgetFormInputHidden(),
			'hasiera_id' => new sfWidgetFormInput(),
			'amaiera_id' => new sfWidgetFormInput(),
			'erlazio_mota_id' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => $this->getRelatedModelName('ErlazioMota'),
				'add_empty' => '--'
			)),
			'langilea_id' => new sfWidgetFormInput(),
			'ekintza_id' => new sfWidgetFormInput()
		));

		$this->setValidators(array
		(
			'id' => new sfValidatorChoice(array
			(
				'choices' => array($this->getObject()->get('id')),
				'empty_value' => $this->getObject()->get('id'),
				'required' => false
			)),
			'hasiera_id' => new sfValidatorString(array('required' => false)),
			'amaiera_id' => new sfValidatorString(array('required' => false)),
			'erlazio_mota_id' => new sfValidatorDoctrineChoice(array
			(
				'model' => $this->getRelatedModelName('ErlazioMota'),
				'required' => false
			)),
			'langilea_id' => new sfValidatorString(array('required' => false)),
			'ekintza_id' => new sfValidatorString(array('required' => false))
		));

		$this->widgetSchema->setNameFormat('erlazioak[%s]');

		$this->validatorSchema->setPostValidator
		(
			new sfValidatorCallback(array('callback' => array($this, 'postValidate')))
		);
	}

	public function postValidate($validator, $values)
	{
		$erlazioMotaId = '1';

		$sql = 'SELECT DISTINCT hasiera_id AS gertakaria_id FROM '
		 . '(SELECT hasiera_id FROM erlazioak WHERE amaiera_id = :gertakariaId and erlazio_mota_id = :erlazioMotaId'
		 . ' UNION ALL SELECT amaiera_id FROM erlazioak WHERE hasiera_id = :gertakariaId and erlazio_mota_id = :erlazioMotaId)'
		 . ' erlazioak order by gertakaria_id desc';
		$cn = Doctrine_Manager::getInstance()->connection();
		$cmd = $cn->prepare($sql);
		$parametroak = array
		(
			':gertakariaId' => $values['hasiera_id'],
			':erlazioMotaId' => $erlazioMotaId
		);
		$cmd->execute($parametroak);
		$erlazionatutakoak = $cmd->fetchAll(PDO::FETCH_COLUMN, 0);
		$cmd->closeCursor();
		$erlazioak = $erlazionatutakoak;

		if ($values['ekintza_id'] == 0)
		{
			if (!in_array($values['amaiera_id'], $erlazioak))
			{
				$error = new sfValidatorError($validator, __('Ezin da erlazio hau ezabatu'));
				throw new sfValidatorErrorSchema($validator, array('amaiera_id' => $error));
			}
		}
		elseif ($values['ekintza_id'] == 1)
		{
			$erlazioAmaiera = Doctrine_Core::getTable('Gertakaria')->find(array($values['amaiera_id']));

			if (in_array($values['amaiera_id'], $erlazioak) OR $erlazioAmaiera == null OR $values['amaiera_id'] == $values['hasiera_id'])
			{
				$error = new sfValidatorError($validator, __('Ezin da erlazio hau sortu'));
				throw new sfValidatorErrorSchema($validator, array('amaiera_id' => $error));
			}
		}

		return $values;
	}
}
