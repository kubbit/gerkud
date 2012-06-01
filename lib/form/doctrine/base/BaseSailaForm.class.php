<?php

/**
 * Saila form base class.
 *
 * @method Saila getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSailaForm extends sfGuardGroupForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('saila[%s]');
  }

  public function getModelName()
  {
    return 'Saila';
  }

}
