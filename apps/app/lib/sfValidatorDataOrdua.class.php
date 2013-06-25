<?php

/**
 * @package    gerkud
 * @author     Kubbit Information Technology
 * @url        http://kubbit.com
 *
 */
class sfValidatorDataOrdua extends sfValidatorDateTime
{
	const DATA_FORMATOA = '~^(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})((T|\s)(?P<hour>\d{2}):(?P<minute>\d{2}))?$~';
	const DATA_FORMATO_ERROREA = 'Data formatoa ez da zuzena (uuuu-hh-ee oo:mm)';

	protected function configure($options = array(), $messages = array())
	{
		parent::configure();

		$this->addMessage('bad_format', self::DATA_FORMATO_ERROREA);

		$this->addOption('date_format', self::DATA_FORMATOA);
	}
}
