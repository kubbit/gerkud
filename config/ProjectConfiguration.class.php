<?php

require_once __DIR__ . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';

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
