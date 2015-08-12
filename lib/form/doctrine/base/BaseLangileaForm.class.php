<?php

/**
 * Langilea form base class.
 *
 * @method Langilea getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseLangileaForm extends sfGuardUserForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['ohartaraztea_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ohartaraztea'), 'add_empty' => true));
    $this->validatorSchema['ohartaraztea_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ohartaraztea'), 'column' => 'id', 'required' => false));

    $this->widgetSchema->setNameFormat('langilea[%s]');
  }

  public function getModelName()
  {
    return 'Langilea';
  }

}
