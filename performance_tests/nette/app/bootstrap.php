<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../vendor/others')
	->addDirectory(__DIR__ . '/../../../JR')
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');

$container = $configurator->createContainer();

return $container;