<?php

/**
 * @package    gerkud
 * @author     Kubbit Information Technology
 * @url        http://kubbit.com
 *
 */
class sfWidgetFormDataOrdua extends sfWidgetForm
{
	const HTML_DATA_FORMATOA = 'Y-m-d';
	const HTML_DATA_ORDUA_FORMATOA = 'Y-m-d\TH:i';

	protected function configure($options = array(), $attributes = array())
	{
		$this->addRequiredOption('type');
		$this->setOption('type', 'datetime');
	}

	public function render($name, $value = null, $attributes = array(), $errors = array())
	{
		switch ($this->getOption('type'))
		{
			case 'date':
				$mota = 'date';
				$this->setAttribute('placeholder', 'yyyy-mm-dd');
				break;
			case 'datetime':
				$mota = 'datetime-local';
				$this->setAttribute('placeholder', 'yyyy-mm-dd hh:nn');
				break;
			default:
				throw new InvalidArgumentException(sprintf('Type \'%s\' not supported by %s', $this->getOption('type'), get_class($this)));
				break;
		}
		$this->setAttribute('type', $mota);

		if ($value)
		{
			try
			{
				// si el valor no es un objeto, convertirlo en DateTime
				if (is_object($value))
					$data = $value;
				else
					$data = new DateTime($value);

				// evitar la correccion automatica de la fecha
				$errors = DateTime::getLastErrors();
				if ($errors['warning_count'] > 0)
					throw new Exception('Invalid date');

				switch ($this->getOption('type'))
				{
					case 'date':
						$data = $data->format(self::HTML_DATA_FORMATOA);
						break;
					case 'datetime':
						$data = $data->format(self::HTML_DATA_ORDUA_FORMATOA);
						break;
				}
			}
			catch (Exception $e)
			{
				// devolver el mismo valor introducido
				// si no se puede convertir a tipo DateTime
				$data = $value;
			}
		}
		else
			$data = "";

		return $this->renderTag('input', array_merge(array('name' => $name, 'value' => $data), $attributes));
	}
}
class sfWidgetFormData extends sfWidgetFormDataOrdua
{
	protected function configure($options = array(), $attributes = array())
	{
		parent::configure();

		$this->setOption('type', 'date');
	}
}
?>