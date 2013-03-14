<?php

/**
 * Iruzkina form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IruzkinaForm extends BaseIruzkinaForm
{
  public function configure()
  {
	$culture = sfContext::getInstance()->getUser()->getCulture();

	$this->widgetSchema['saila_id'] = new sfWidgetFormDoctrineChoice(array(
		'model' => 'Saila',
		'add_empty' => false,
		'query'     => Doctrine::getTable('Saila')->createQuery('s')
		                                         ->select('s.id, t.name')
		                                         ->leftJoin('s.Translation t WITH t.lang = ?', $culture)
		                                         ->orderBy('t.name ASC')
	));

        $this->validatorSchema['saila_id'] = new sfValidatorString(array(
            'required'   => false
        ));

        $this->widgetSchema['testua']= new sfWidgetFormTextarea();

	unset(
              $this['created_at'], $this['updated_at']
        );


        $this->widgetSchema['gertakaria_id'] = new sfWidgetFormTextarea();


  }


  public function updateTestuaColumn($value)
  {
//haz lo que sea con $value
//	$this['testua']=$value;
//      $this->getWidget('testua')->setAttribute('value', $balioa);
      return $value;
  }


}
