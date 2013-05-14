<?php

/**
 * eskaerak actions.
 *
 * @package    gerkud
 * @subpackage eskaerak
 * @author     Pasaiako Udala
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eskaerakActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$e = Doctrine_Core::getTable('Gertakaria')->getEskaerak();
		$this->eskaerak = $e->execute();
	}
}
