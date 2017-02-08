<?php

$rootDir = dirname(dirname(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME')));

require_once( $rootDir . '/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('app', 'prod', false, $rootDir);
sfContext::createInstance($configuration)->dispatch();
