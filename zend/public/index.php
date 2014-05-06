<?php
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

require_once __DIR__ . '/../../JR/FrameworkComparison/Utils/Logger.php';
require_once __DIR__ . '/../../nette/vendor/nette/nette/Nette/Diagnostics/Debugger.php';

use JR\FrameworkComparison\Utils\Logger,
	Nette\Diagnostics\Debugger;

$time = Debugger::timer('script_load');

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();

$time = Debugger::timer('script_load');

//$logger = new Logger(__DIR__ . '/../../JR/FrameworkComparison/_results');
//$logger = new Logger(__DIR__ . '/../../JR/FrameworkComparison/_results/opcache');
//$logger->logTime(Logger::TYPE_ZEND_HOMEPAGE, $time);
//$logger->logTime(Logger::TYPE_ZEND_BOOKS, $time);
//$logger->logTime(Logger::TYPE_ZEND_BOOK, $time);