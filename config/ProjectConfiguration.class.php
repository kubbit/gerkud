<?php

require_once dirname(__FILE__) . '/../lib/symfony/autoload/sfCoreAutoload.class.php';

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
	public function setup()
	{
		$this->enablePlugins('sfDoctrinePlugin');
		$this->enablePlugins('sfDependentSelectPlugin');
		$this->enablePlugins('sfDoctrineGuardPlugin');
		$this->enablePlugins('sfProtoculousPlugin');
		$this->enablePlugins('bhLDAPAuthPlugin');
		$this->enablePlugins('sfTCPDFPlugin');
	}

	static protected $zendLoaded = false;

	static public function registerZend()
	{
		if (self::$zendLoaded)
			return;

		set_include_path(get_include_path() . PATH_SEPARATOR. '../lib/');

		require_once '../lib/Zend/Loader/Autoloader.php';

		Zend_Loader_Autoloader::getInstance();

		self::$zendLoaded = true;
	}
}
