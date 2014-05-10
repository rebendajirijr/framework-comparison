<?php

namespace JR\FrameworkComparison\Model\Repositories;

use JR\FrameworkComparison\Model\Entities,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Adapter\Driver\ResultInterface,
	Zend\Db\Sql\Sql,
	Nette\Diagnostics\Debugger,
	JR\FrameworkComparison\Utils\Logger;

/**
 * Description of ZendDbOopBookRepository
 *
 * @author RebendaJiri
 */
class ZendDbOopBookRepository implements IBookRepository
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
	
	/**
	 * @param Adapter $adapter
	 * @param Logger $logger
	 */
	public function __construct(Adapter $adapter, Logger $logger)
	{
		$this->adapter = $adapter;
		$this->logger = $logger;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findAll()
	{
		Debugger::timer('zend_db_oop_books');
		$sql = new Sql($this->adapter);
		$select = $sql->select(static::TABLE_NAME);
		$result = $this->adapter->query($sql->getSqlStringForSqlObject($select))->execute();
		$time = Debugger::timer('zend_db_oop_books');
		
		$this->logger->logTime(Logger::TYPE_ZEND_DB_OOP_BOOKS, $time);
		
		$entities = $this->createAllEntities($result);
		return $entities;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findById($id)
	{
		$id = (int) $id;
		
		Debugger::timer('zend_db_oop_book');
		$sql = new Sql($this->adapter);
		$select = $sql->select(static::TABLE_NAME)
			->where(array(
				'id' => $id,
			));
		$result = $this->adapter->query($sql->getSqlStringForSqlObject($select))->execute();
		$time = Debugger::timer('zend_db_oop_book');
		
		$this->logger->logTime(Logger::TYPE_ZEND_DB_OOP_BOOK, $time);
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
		if (NULL === ($row = $result->current())) {
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