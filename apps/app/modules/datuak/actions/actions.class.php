<?php

/**
 * Erabilera Datuak.
 *
 * @package    gerkud
 * @subpackage datuak
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class datuakActions extends sfActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$this->datuakForm = new DatuakForm();
		if (!$request->isMethod(sfRequest::POST))
			return;

		$this->processForm($request, $this->datuakForm);
	}
	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if (!$form->isValid())
			return;

		// definidas en lib/form/DatuakForm.class.php, puestas aquí para la traducción
		$tarteak = array(__('Urteak'), __('Hilabeteak'), __('Asteak'), __('Egunak'));

		$this->formularioa = $request->getParameter('datuak');

		$this->hasiera = $this->formularioa['hasiera'];
		if (!$this->hasiera)
			$this->hasiera = null;

		$this->amaiera = $this->formularioa['amaiera'];
		if (!$this->amaiera)
			$this->amaiera = null;

		$this->taula = $this->formularioa['taula'];
		$this->tartea = $this->formularioa['tartea'];
		$this->saila = $this->formularioa['saila'];
		$this->jatorrizkosaila = $this->formularioa['jatorrizkosaila'];

		// volver a asignar a los campos los valores recibidos
		$this->datuakForm->setDefault('taula', $this->taula);
		$this->datuakForm->setDefault('hasiera', $this->hasiera);
		$this->datuakForm->setDefault('amaiera', $this->amaiera);
		$this->datuakForm->setDefault('tartea', $this->tartea);
		$this->datuakForm->setDefault('saila', $this->saila);
		$this->datuakForm->setDefault('jatorrizkosaila', $this->jatorrizkosaila);

		if ($this->tartea == 0)
			$this->tartea = null;
		if ($this->saila == 0)
			$this->saila = null;
		if ($this->jatorrizkosaila == 0)
			$this->jatorrizkosaila = null;

		switch ($this->taula)
		{
			case 1:
				$this->titulua = __('Dataren arabera');
				$this->goiburuak = array(__('Data-tartea'), __('Berriak'), __('Irekiak'), __('Baztertuak'), __('Ebatziak'), __('Ebatzien egun batazbestekoa'));
				$this->argibideak = array
				(
					'',
					__('Denbora tartean sortutako gertakari berriak'),
					__('Denbora tartean irekiak zeuden gertakariak'),
					__('Denbora tartean baztertu ziren gertakariak'),
					__('Denbora tartean ebaztu ziren gertakariak'),
					__('Denbora tartean ebaztutako gertakarien batazbestekoa')
				);
				$this->getDatuak();
				break;
			case 2:
				$this->titulua = __('Sailaren arabera');
				$this->goiburuak = array(__('Saila'), __('Irekiak'), __('Ebatziak'), __('Ebatzien egun batazbestekoa'));
				$this->argibideak = array
				(
					'',
					__('Sail bakoitzeko irekita dauden gertakariak'),
					__('Sail bakoitzeko ebatziak dauden gertakariak'),
					__('Sail bakoitzeko ebaztutako gertakarien egun batazbestekoa')
				);
				$this->getDatuak();
				break;
			case 3:
				$this->titulua = __('Egun desbiderapenaren arabera');
				$this->goiburuak = array(__('Egunak'), __('Iraupenekoa (zkia.)'), __('Iraupenekoa (%)'), __('Hasierakoa (zkia.)'), __('Hasierakoa (%)'), __('Ebazterakoa (zkia.)'), __('Ebazterakoa (%)'));
				$this->argibideak = array
				(
					'',
					__('Egun-tarte horretan desbideratzen diren gertakari kopurua (aurrez ikusitako iraupenarekiko)'),
					__('Egun-tarte horretan desbideratzen diren gertakarien portzentaia (aurrez ikusitako iraupenarekiko)'),
					__('Egun-tarte horretan desbideratzen diren gertakari kopurua (aurrez ikusitako hasiera datarekiko)'),
					__('Egun-tarte horretan desbideratzen diren gertakarien portzentaia (aurrez ikusitako hasiera datarekiko)'),
					__('Egun-tarte horretan desbideratzen diren gertakari kopurua (aurrez ikusitako ebazpen datarekiko)'),
					__('Egun-tarte horretan desbideratzen diren gertakarien portzentaia (aurrez ikusitako ebazpen datarekiko)')
				);
				$this->getDatuak();
				break;
			case 4:
				$this->titulua = __('Jatorrizko sailaren arabera');
				$this->goiburuak = array(__('Saila'), __('Irekiak'), __('Ebatziak'), __('Ebatzien egun batazbestekoa'));
				$this->argibideak = array
				(
					'',
					__('Sail bakoitzeko irekita dauden gertakariak'),
					__('Sail bakoitzeko ebatziak dauden gertakariak'),
					__('Sail bakoitzeko ebaztutako gertakarien egun batazbestekoa')
				);
				$this->getDatuak();
				break;
		}
	}
	public function getDatuak()
	{
		$sql = "CALL estatistikak(:hasiera, :amaiera, :taula, :tartea, :saila, :jatorrizkosaila, :hizkuntza)";

		$cn = Doctrine_Manager::getInstance()->connection();
		$cmd = $cn->prepare($sql);

		$parametroak = array
		(
			':hasiera' => $this->hasiera,
			':amaiera' => $this->amaiera,
			':taula' => $this->taula,
			':tartea' => $this->tartea,
			':saila' => $this->saila,
			':jatorrizkosaila' => $this->jatorrizkosaila,
			':hizkuntza' => $this->getUser()->getCulture()
		);
		$cmd->execute($parametroak);

		// obtener datos con indices numericos
		$this->datuak = $cmd->fetchAll(PDO::FETCH_NUM);
		$cmd->closeCursor();

		// sacar ultima fila y ponerla como pie para los totales
		$this->oina = array_pop($this->datuak);
		$this->oina[key($this->oina)] = __('Totala');
	}
}
?>
