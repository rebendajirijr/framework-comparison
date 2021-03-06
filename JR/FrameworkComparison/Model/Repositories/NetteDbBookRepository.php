<?php

namespace JR\FrameworkComparison\Model\Repositories;

use Nette\Database\Context,
	Nette\Database\Table\Selection,
	Nette\Database\ResultSet,
	Nette\Diagnostics\Debugger,
	JR\FrameworkComparison\Model\Entities,
	JR\FrameworkComparison\Utils\Logger;

/**
 * Description of NetteDbBookRepository
 *
 * @author RebendaJiri
 */
class NetteDbBookRepository implements IBookRepository
{
	/**
	 * @internal
	 * @var string
	 */
	const TABLE_NAME = 'book';
	
	/** @var Context */
	private $context;
	
	/** @var Logger */
	private $logger;
	
	/**
	 * @param Context $context
	 */
	public function __construct(Context $context, Logger $logger)
	{
		$this->context = $context;
		$this->logger = $logger;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findAll()
	{
		Debugger::timer('nette_db_books');
		$selection = $this->context->query('SELECT * FROM `' . static::TABLE_NAME . '`');
		$time = Debugger::timer('nette_db_books');
		
		$this->logger->logTime(Logger::TYPE_NETTE_DB_BOOKS, $time);
		
		$entities = $this->createAllEntities($selection);
		return $entities;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findById($id)
	{
		$id = (int) $id;
		Debugger::timer('nette_db_book');
		$selection = $this->context->queryArgs('SELECT * FROM `' . static::TABLE_NAME . '` WHERE `id` = ?', array(
			$id,
		));
		$time = Debugger::timer('nette_db_book');
		
		$this->logger->logTime(Logger::TYPE_NETTE_DB_BOOK, $time);
		
		$entity = $this->createOneEntity($selection);
		return $entity;
	}
	
	private function createAllEntities(ResultSet $resultSet)
	{
		$entities = array();
		foreach ($resultSet as $row) {
			$book = new Entities\Book();
			$book->id = $row->id;
			$book->name = $row->name;
			$book->author = $row->author;
			$book->datePublished = new \DateTime($row->date_published);
			$entities[] = $book;
		}
		return $entities;
	}
	
	private function createOneEntity(ResultSet $resultSet)
	{
		if (FALSE === ($row = $resultSet->fetch())) {
			return NULL;
		}
		
		$entity = new Entities\Book();
		$entity->id = $row->id;
		$entity->name = $row->name;
		$entity->author = $row->author;
		$entity->datePublished = new \DateTime($row->date_published);
		return $entity;
	}
}