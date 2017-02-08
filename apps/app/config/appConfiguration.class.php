<?php

class appConfiguration extends sfApplicationConfiguration
{
	public function configure()
	{
		require_once($this->getConfigCache()->checkConfig('config/defaults/gerkud.yml'));

		if (file_exists(sprintf('%s/gerkud.yml', sfConfig::get('sf_config_dir'))))
			require_once($this->getConfigCache()->checkConfig('config/gerkud.yml'));
	}
}
