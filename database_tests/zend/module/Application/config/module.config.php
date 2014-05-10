<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Zend\ServiceManager\ServiceLocatorInterface,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Adapter\Driver,
	JR\FrameworkComparison\Utils\Logger;

return array(
	'parameters' => array(
		'dbConnectionConfig' => array(
			'host' => '127.0.0.1',
			'database' => 'test',
			'username' => '',
			'password' => '',
			'options' => array(
				'buffer_results' => TRUE,
			),
		),
		'logger' => array(
			'dir' => __DIR__ . '/../../../../../JR/FrameworkComparison/_results/db',
		),
	),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'=> '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
		'factories' => array(
			'logger' => function (ServiceLocatorInterface $serviceManager) {
				$config = $serviceManager->get('config');
				$logger = new Logger($config['parameters']['logger']['dir']);
				return $logger;
			},
			'dbConnection' => function (ServiceLocatorInterface $serviceManager) {
				$config = $serviceManager->get('config');
				$connection = new Driver\Mysqli\Connection($config['parameters']['dbConnectionConfig']);
				return $connection;
			},
			'dbDriver' => function (ServiceLocatorInterface $serviceManager) {
				$driver = new Driver\Mysqli\Mysqli($serviceManager->get('dbConnection'));
				return $driver;
			},
			'dbAdapter' => function (ServiceLocatorInterface $serviceManager) {
				$adapter = new Adapter($serviceManager->get('dbDriver'));
				return $adapter;
			},
			'bookRepository' => function (ServiceLocatorInterface $serviceManager) {
//				$bookRepository = new \JR\FrameworkComparison\Model\Repositories\ZendDbBookRepository(
//					$serviceManager->get('dbAdapter'),
//					$serviceManager->get('logger')
//				);
				$bookRepository = new \JR\FrameworkComparison\Model\Repositories\ZendDbOopBookRepository(
					$serviceManager->get('dbAdapter'),
					$serviceManager->get('logger')
				);
				return $bookRepository;
			},
			'bookFacade' => function (ServiceLocatorInterface $serviceManager) {
				$bookRepository = $serviceManager->get('bookRepository');
				$bookFacade = new \JR\FrameworkComparison\Model\Facades\BookFacade($bookRepository);
				return $bookFacade;
			},
		),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
			'Application\Controller\Books' => 'Application\Controller\BooksController',
			'Application\Controller\Book' => 'Application\Controller\BookController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
