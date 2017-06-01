<?php

$rootDir = dirname(dirname(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME')));

require_once $rootDir . '/lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';

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
}
