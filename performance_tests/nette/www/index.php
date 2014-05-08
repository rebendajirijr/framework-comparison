<?php

require_once __DIR__ . '/../../../JR/FrameworkComparison/Utils/Logger.php';
require_once __DIR__ . '/../vendor/nette/nette/Nette/Diagnostics/Debugger.php';

use JR\FrameworkComparison\Utils\Logger,
	Nette\Diagnostics\Debugger;

Debugger::timer('script_load');

$container = require __DIR__ . '/../app/bootstrap.php';
$container->getService('application')->run();

$time = Debugger::timer('script_load');

//$logger = new Logger(__DIR__ . '/../../JR/FrameworkComparison/_results');
//$logger = new Logger(__DIR__ . '/../../JR/FrameworkComparison/_results/opcache');
//$logger->logTime(Logger::TYPE_NETTE_HOMEPAGE_CACHING, $time);
//$logger->logTime(Logger::TYPE_NETTE_BOOKS_CACHING, $time);
//$logger->logTime(Logger::TYPE_NETTE_BOOK_CACHING, $time);
//$logger->logTime(Logger::TYPE_NETTE_HOMEPAGE, $time);
//$logger->logTime(Logger::TYPE_NETTE_BOOKS, $time);
//$logger->logTime(Logger::TYPE_NETTE_BOOK, $time);