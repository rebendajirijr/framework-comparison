<?php

namespace JR\FrameworkComparison\Model\Repositories;

use Nette\Database\Context,
	Nette\Database\Table\Selection,
	Nette\Database\Table\ActiveRow,
	Nette\Diagnostics\Debugger,
	JR\FrameworkComparison\Model\Entities,
	JR\FrameworkComparison\Utils\Logger;

/**
 * Description of NetteDbOopBookRepository
 *
 * @author RebendaJiri
 */
class NetteDbOopBookRepository implements IBookRepository
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
		Debugger::timer('nette_db_oop_books');
		$selection = $this->context->table(static::TABLE_NAME)->fetchAll();
		$time = Debugger::timer('nette_db_oop_books');
		
		$this->logger->logTime(Logger::TYPE_NETTE_DB_OOP_BOOKS, $time);
		
		$entities = $this->createAllEntities($selection);
		return $entities;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findById($id)
	{
		$id = (int) $id;
		Debugger::timer('nette_db_oop_book');
		$selection = $this->context->table(static::TABLE_NAME)->where(array(
			 'id' => $id,
		))->fetch();
		$time = Debugger::timer('nette_db_oop_book');
		
		$this->logger->logTime(Logger::TYPE_NETTE_DB_OOP_BOOK, $time);
		
		$entity = $this->createOneEntity($selection);
		return $entity;
	}
	
	private function createAllEntities(array $selection)
	{
		$entities = array();
		foreach ($selection as $row) {
			$book = new Entities\Book();
			$book->id = $row->id;
			$book->name = $row->name;
			$book->author = $row->author;
			$book->datePublished = new \DateTime($row->date_published);
			$entities[] = $book;
		}
		return $entities;
	}
	
	private function createOneEntity(ActiveRow $row)
	{
		$entity = new Entities\Book();
		$entity->id = $row->id;
		$entity->name = $row->name;
		$entity->author = $row->author;
		$entity->datePublished = new \DateTime($row->date_published);
		return $entity;
	}
}