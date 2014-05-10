<?php

namespace JR\FrameworkComparison\Model\Repositories;

use JR\FrameworkComparison\Model\Entities,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Adapter\Driver\ResultInterface,
	Nette\Diagnostics\Debugger,
	JR\FrameworkComparison\Utils\Logger;

/**
 * Description of ZendDbBookRepository
 *
 * @author RebendaJiri
 */
class ZendDbBookRepository implements IBookRepository
{
	/**
	 * @internal
	 * @var string
	 */
	const TABLE_NAME = 'book';
	
	/** @var Adapter */
	private $adapter;
	
	/** @var Logger */
	private $logger;
	
	public function __construct(Adapter $adapter, Logger $logger)
	{
		$this->adapter = $adapter;
		$this->logger = $logger;
	}
	
	public function findAll()
	{
		Debugger::timer('zend_db_log_all');
		$result = $this->adapter->query('SELECT * FROM `' . static::TABLE_NAME . '`')->execute();
		$time = Debugger::timer('zend_db_log_all');
		
		$this->logger->logTime(Logger::TYPE_ZEND_DB_BOOKS, $time);
		
		$entities = $this->createAllEntities($result);
		return $entities;
	}

	public function findById($id)
	{
		$id = (int) $id;
		Debugger::timer('zend_db_log_one');
		$result = $this->adapter->createStatement('SELECT * FROM `' . static::TABLE_NAME . '` WHERE `id` = ?', array(
			$id
		))->execute();
		$time = Debugger::timer('zend_db_log_one');
		
		$this->logger->logTime(Logger::TYPE_ZEND_DB_BOOK, $time);
				
		$entity = $this->createOneEntity($result);
		return $entity;
	}
	
	private function createAllEntities(ResultInterface $result)
	{
		$entities = array();
		foreach ($result as $row) {
			$book = new Entities\Book();
			$book->id = $row['id'];
			$book->name = $row['name'];
			$book->author = $row['author'];
			$book->datePublished = new \DateTime($row['date_published']);
			$entities[] = $book;
		}
		return $entities;
	}
	
	private function createOneEntity(ResultInterface $result)
	{
		$row = $result->current();
		if ($row === NULL) {
			return NULL;
		}
		$entity = new Entities\Book();
		$entity->id = $row['id'];
		$entity->name = $row['name'];
		$entity->author = $row['author'];
		$entity->datePublished = new \DateTime($row['date_published']);
		return $entity;
 	}
}