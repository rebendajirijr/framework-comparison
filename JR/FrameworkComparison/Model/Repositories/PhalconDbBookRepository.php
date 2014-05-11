<?php

namespace JR\FrameworkComparison\Model\Repositories;

use JR\FrameworkComparison\Model\Entities,
	JR\FrameworkComparison\Utils\Logger,
	Nette\Diagnostics\Debugger,
	Phalcon\Db\AdapterInterface;

/**
 * Description of PhalconDbBookRepository
 *
 * @author RebendaJiri
 */
class PhalconDbBookRepository implements IBookRepository
{
	/** @var AdapterInterface */
	private $adapter;
	
	/** @var Logger */
	private $logger;
	
	/**
	 * @param AdapterInterface $adapter
	 * @param Logger $logger
	 */
	public function __construct(AdapterInterface $adapter, Logger $logger)
	{
		$this->adapter = $adapter;
		$this->logger = $logger;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findAll()
	{
		Debugger::timer('phalcon_db_books');
		$result = $this->adapter->query('SELECT * FROM `book`')->fetchAll();
		$time = Debugger::timer('phalcon_db_books');
		
		$this->logger->logTime(Logger::TYPE_PHALCON_DB_BOOKS, $time);
		
		$entities = $this->createAllEntities($result);
		return $entities;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findById($id)
	{
		$id = (int) $id;
		
		Debugger::timer('phalcon_db_book');
		$result = $this->adapter->query('SELECT * FROM `book` WHERE id = ?', array(
			$id,
		))->fetch();
		$time = Debugger::timer('phalcon_db_book');
		
		$this->logger->logTime(Logger::TYPE_PHALCON_DB_BOOK, $time);
		
		$entities = $this->createOneEntity($result);
		return $entities;
	}
	
	private function createAllEntities(array $rows)
	{
		$entities = array();
		foreach ($rows as $row) {
			$book = $this->createOneEntity($row);
			$entities[] = $book;
		}
		return $entities;
	}
	
	private function createOneEntity(array $row)
	{
		$entity = new Entities\Book();
		$entity->id = $row['id'];
		$entity->name = $row['name'];
		$entity->author = $row['author'];
		$entity->datePublished = new \DateTime($row['date_published']);
		return $entity;
	}
}