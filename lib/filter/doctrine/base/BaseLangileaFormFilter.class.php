<?php

/**
 * Langilea filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseLangileaFormFilter extends sfGuardUserFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['ohartaraztea_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ohartaraztea'), 'add_empty' => true));
    $this->validatorSchema['ohartaraztea_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ohartaraztea'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('langilea_filters[%s]');
  }

  public function getModelName()
  {
    return 'Langilea';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'ohartaraztea_id' => 'ForeignKey',
    ));
  }
}
