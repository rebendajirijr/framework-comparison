<?php

namespace JR\FrameworkComparison\Model\Repositories;

use JR\FrameworkComparison\Model\Entities,
	JR\FrameworkComparison\Utils\Logger,
	Nette\Diagnostics\Debugger,
	Phalcon\Mvc\Model\ManagerInterface;

/**
 * Description of PhalconDbOopBookRepository
 *
 * @author RebendaJiri
 */
class PhalconDbOopBookRepository implements IBookRepository
{
	/**
	 * @internal
	 * @var string
	 */
	const PHALCON_DB_BOOK_ENTITY_CLASS = 'JR\FrameworkComparison\Model\Entities\PhalconDbBook';
	
	/** @var ManagerInterface */
	private $manager;
	
	/** @var Logger */
	private $logger;
	
	public function __construct(ManagerInterface $managerInterface, Logger $logger)
	{
		$this->manager = $managerInterface;
		$this->logger = $logger;
	}
	
	public function findAll()
	{
		Debugger::timer('phalcon_db_oop_books');
		$builder = $this->manager->createBuilder();
		$rows = $builder->from(static::PHALCON_DB_BOOK_ENTITY_CLASS)->getQuery()->execute();
		$time = Debugger::timer('phalcon_db_oop_books');
		
		$this->logger->logTime(Logger::TYPE_PHALCON_DB_OOP_BOOKS, $time);
		
		return $rows;
	}

	public function findById($id)
	{
		$id = (int) $id;
		
		Debugger::timer('phalcon_db_oop_book');
		$builder = $this->manager->createBuilder();
		$rows = $builder->from(static::PHALCON_DB_BOOK_ENTITY_CLASS)->where('id = :id:', array(
			'id' => $id,
		))->getQuery()->execute();
		
		$time = Debugger::timer('phalcon_db_oop_book');
		
		$this->logger->logTime(Logger::TYPE_PHALCON_DB_OOP_BOOK, $time);
		
		if (isset($rows[0])) {
			return $rows[0];
		}
		return NULL;
	}
}