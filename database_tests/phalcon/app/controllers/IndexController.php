<?php

use Phalcon\Db\Adapter\Pdo\Mysql,
	Phalcon\Db\Column,
	Phalcon\Events\Manager,
	Phalcon\Db\Profiler;

class IndexController extends BaseController
{
	public function indexAction()
	{
//		$profiler = new Profiler();
//		
//		$eventsManager = new Manager();
//		$eventsManager->attach('db:beforeQuery', function ($event, $mysql) use ($profiler) {
//			$profiler->startProfile($mysql->getSQLStatement());
//			var_dump('before query: ' . $mysql->getSQLStatement());
//		});
//		$eventsManager->attach('db:afterQuery', function ($event, $mysql) use ($profiler) {
//			$profiler->stopProfile();
//			var_dump('after query: ' . $mysql->getSQLStatement());
//		});
//		
//		$mysql = new Mysql(array(
//			'host' => '127.0.0.1', // localhost
//			'dbname' => 'test',
//		));
//		$mysql->setEventsManager($eventsManager);
//		
//		$books = $mysql->query('SELECT * FROM `book`');
//		
//		var_dump($profiler->getLastProfile()->getTotalElapsedSeconds());
		
//		foreach ($books->fetchAll() as $book) {
//			echo $book['name'] . PHP_EOL;
//		}
		
//		$mysql->insert(
//			// název tabulky
//			'book',
//				
//			// hodnoty
//			array(
//				6,
//				'My book',
//				'John Doe',
//				date('Y-m-d'),
//			),
//				
//			// názvy sloupců
//			array(
//				'id',
//				'name',
//				'author',
//				'date_published',
//			)
//		);
		
//		$mysql->createTable(
//			'test_table',
//			'test',
//			array(
//				'columns' => array(
//					new Column(
//						'id',
//						array(
//							'type' => Column::TYPE_INTEGER,
//							'notNull' => TRUE,
//							'unsigned' => TRUE,
//							'primary' => TRUE,
//							'autoIncrement' => TRUE,
//						)
//					),
//					new Column(
//						'name',
//						array(
//							'type' => Column::TYPE_VARCHAR,
//							'size' => 255,
//							'notNull' => TRUE,
//						)
//					)
//				),
//			)
//		);
//		exit;
	}
}