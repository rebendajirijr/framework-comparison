<?php

require_once __DIR__ . '/../../../JR/FrameworkComparison/Utils/Logger.php';
require_once __DIR__ . '/../../nette/vendor/nette/nette/Nette/Diagnostics/Debugger.php';

use JR\FrameworkComparison\Utils\Logger,
	Nette\Diagnostics\Debugger,
	JR\FrameworkComparison\Model\Repositories;

Debugger::timer('script_load');

$config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/../app/config/config.ini');

$loader = new \Phalcon\Loader();
$loader->registerDirs(
	array(
		__DIR__ . $config->application->controllersDir,
	)
);

$loader->registerNamespaces(array(
	'JR\FrameworkComparison' => __DIR__ . '/../../../JR/FrameworkComparison/',
	'JR\FrameworkComparison\Model' => __DIR__ . '/../../../JR/FrameworkComparison/Model/',
	'JR\FrameworkComparison\Model\Entities' => __DIR__ . '/../../../JR/FrameworkComparison/Model/Entities/',
	'JR\FrameworkComparison\Model\Facades' => __DIR__ . '/../../../JR/FrameworkComparison/Model/Facades/',
	'JR\FrameworkComparison\Model\Repositories' => __DIR__ . '/../../../JR/FrameworkComparison/Model/Repositories/',
));
$loader->register();

$di = new \Phalcon\DI\FactoryDefault();

$di->set('dispatcher', function () use ($di) {
	$eventsManager = $di->getShared('eventsManager');
	$dispatcher = new Phalcon\Mvc\Dispatcher();
	$dispatcher->setEventsManager($eventsManager);
	return $dispatcher;
});

$di->set('url', function () use ($config) {
	$url = new \Phalcon\Mvc\Url();
	$url->setBaseUri($config->application->baseUri);
	return $url;
});

$di->set('view', function () use ($config) {
	$view = new \Phalcon\Mvc\View();
	$view->setViewsDir(__DIR__ . $config->application->viewsDir);
	$view->registerEngines(array(
		'.volt' => 'volt',
	));
	return $view;
});

$di->set('volt', function ($view, $di) {
	$volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
	$volt->setOptions(array(
		'compiledPath' => '../cache/volt/'
	));
	return $volt;
}, TRUE);

$di->set('logger', function () use ($config) {
	$directory = $config['logger']['dir'];
	$logger = new Logger($directory);
	return $logger;
}, TRUE);

$di->set('db', function () use ($di, $config) {
	$dbConfig = array(
		'host' => $config['database']['host'],
		'dbname' => $config['database']['dbname'],
		'username' => $config['database']['username'],
		'password' => $config['database']['password'],
	);
	$adapter = new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig);
	return $adapter;
}, TRUE);

$di->set('modelManager', function () {
	$manager = new \Phalcon\Mvc\Model\Manager();
	return $manager;
}, TRUE);

$di->set('bookRepository', function () use ($di) {
	//$bookRepository = new Repositories\PhalconDbBookRepository($di->get('db'), $di->get('logger'));
	$bookRepository = new Repositories\PhalconDbOopBookRepository($di->get('modelManager'), $di->get('logger'));
	return $bookRepository;
}, TRUE);

$di->set('bookFacade', function () use ($di) {
	$bookRepository = $di->get('bookRepository');
	$bookFacade = new \JR\FrameworkComparison\Model\Facades\BookFacade($bookRepository);
	return $bookFacade;
}, TRUE);

$application = new \Phalcon\Mvc\Application();
$application->setDI($di);

echo $application->handle()->getContent();

$time = Debugger::timer('script_load');

//$logger = new Logger(__DIR__ . '/../../JR/FrameworkComparison/_results');
//$logger = new Logger(__DIR__ . '/../../JR/FrameworkComparison/_results/opcache');
//$logger->logTime(Logger::TYPE_PHALCON_HOMEPAGE_CACHING, $time);
//$logger->logTime(Logger::TYPE_PHALCON_BOOKS_CACHING, $time);
//$logger->logTime(Logger::TYPE_PHALCON_BOOK_CACHING, $time);
//$logger->logTime(Logger::TYPE_PHALCON_HOMEPAGE, $time);
//$logger->logTime(Logger::TYPE_PHALCON_BOOKS, $time);
//$logger->logTime(Logger::TYPE_PHALCON_BOOK, $time);