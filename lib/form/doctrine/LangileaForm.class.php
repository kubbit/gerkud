<?php

/**
 * Langilea form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LangileaForm extends BaseLangileaForm
{
	/**
	 * @see sfGuardUserForm
	 */
	public function configure()
	{
		$this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['updated_at'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['last_login'] = new sfWidgetFormInputHidden();

		$this->widgetSchema['password'] = new sfWidgetFormInputPassword();

		$this->widgetSchema['ohartaraztea_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'Ohartaraztea',
		));

		$this->widgetSchema['groups_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Saila'));

		parent::configure();
	}
}
