<?php

/**
 * Gertakaria form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GertakariaForm extends BaseGertakariaForm
{
  public function configure()
  {


        $this->widgetSchema['barrutia_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Barrutia',
                'add_empty' => '--',
                ));
/*default context does not exist arazoa gertatzen denerako komentatu */
        $this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'Kalea',
                    'depends'   => 'Barrutia',
                    'add_empty' => '--',
		    'order_by' => array('izena','asc')
                ));
/* */
        $this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Klasea',
                'add_empty' => '--',
                ));
/* */
        $this->widgetSchema['mota_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Mota',
                'add_empty' => '--',
                'query'     => Doctrine::getTable('Mota')->createQuery('m')->leftJoin('m.Translation mt')->orderBy('mt.izena ASC')
                ));

        $this->widgetSchema['laburpena'] = new sfWidgetFormTextarea(array(
                ));

        $this->widgetSchema['deskribapena'] = new sfWidgetFormTextarea(array(
                ));

	$this->validatorSchema['deskribapena'] = new sfValidatorString(array('required' => true));


/*default context does not exist arazoa gertatzen denerako komentatu */
        $this->widgetSchema['azpimota_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'Azpimota',
                    'depends'   => 'Mota',
                    'add_empty' => '--',
//                    'order_by' => array('izena','asc')
                ));
/* */


        $this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'Eraikina',
                    'depends'   => 'Barrutia',
                    'add_empty' => '--',
                ));



/*
        $this->widgetSchema['saila_id'] = new sfWidgetFormDoctrineChoice(array(
                  'model'     => 'Saila',
//                'model'     => ' sf_Guard_Group',
                  'add_empty' => 'Aukeratu saila',
		  'order_by' => array('name','asc')
                ));

        $this->widgetSchema['langilea_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Langilea',
                'add_empty' => 'Aukeratu Langilea',
                ));
*/

/*
        $this->widgetSchema['langilea'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'Langilea',
                'depends'   => 'Saila',
                'add_empty' => 'Aukeratu langilea',
                ));
*/


        $this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Klasea',
                'add_empty' => '--',
                'query'     => Doctrine::getTable('Klasea')->createQuery('k')->leftJoin('k.Translation kt')->orderBy('kt.izena ASC')
                ));
/*
        $this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Eraikina',
                'add_empty' => 'Aukeratu eraikina',
                'order_by' => array('izena','asc')
                ));
*/

	$this->widgetSchema['hasiera_adieraz'] = new sfWidgetFormI18nDate(array
	(
		'culture' => sfContext::getInstance()->getUser()->getCulture()
	));
	$this->widgetSchema['amaiera_adieraz'] = new sfWidgetFormI18nDate(array
	(
		'culture' => sfContext::getInstance()->getUser()->getCulture()
	));

/*default context does not exist arazoa gertatzen denerako komentatu */
     $urteak = range(2000, date ("Y"));
     if (sfContext::getInstance()->getConfiguration()->getApplication()=='es')
     {
        $this->widgetSchema['ixte_data'] = new sfWidgetFormI18nDate(array(
                'culture' =>'es',
                'format' => '%year%/%month%/%day%',
                'years' => array_combine($urteak, $urteak),
                'label' => 'Ixte data',
        ));

     } else
     {
        $this->widgetSchema['ixte_data'] = new sfWidgetFormI18nDate(array(
                'culture' =>'eu',
                'format' => '%year%/%month%/%day%',
                'years' => array_combine($urteak, $urteak),
                'label' => 'Ixte data',
        ));
     }
        unset(
              $this['created_at'], $this['updated_at']
        );
/* */
	$this->validatorSchema->setPostValidator
	(
		new sfValidatorCallback(array('callback' => array($this, 'postValidate')))
	);
  }

public function postValidate($validator, $values)
{
	if ($this->getObject()->getCreatedAt() == null)
		$sortze_data = date("Y-m-d");
	else
		$sortze_data = strftime("%Y-%m-%d", strtotime($this->getObject()->getCreatedAt()));

	if ($values["hasiera_adieraz"] != null && strtotime($values["hasiera_adieraz"]) < strtotime($sortze_data))
	{
		$error = new sfValidatorError($validator, "Hasiera data ezin da sortzerakoa baino lehenagokoa izan");
		throw new sfValidatorErrorSchema($validator, array('hasiera_adieraz' => $error));
	}

	if ($values["amaiera_adieraz"] != null && strtotime($values["amaiera_adieraz"]) < strtotime($values["hasiera_adieraz"]))
	{
		$error = new sfValidatorError($validator, "Amaiera data ezin da hasierakoa baino lehenagokoa izan");
		throw new sfValidatorErrorSchema($validator, array('amaiera_adieraz' => $error));
	}
	return $values;
}
}
