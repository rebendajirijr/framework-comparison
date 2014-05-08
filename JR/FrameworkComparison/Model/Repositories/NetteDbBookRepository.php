<?php

namespace JR\FrameworkComparison\Model\Repositories;

use Nette\Database\Context,
	Nette\Database\Table\Selection,
	JR\FrameworkComparison\Model\Entities;

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
	
	/**
	 * @param Context $context
	 */
	public function __construct(Context $context)
	{
		$this->context = $context;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findAll()
	{
		$selection = $this->context->table(static::TABLE_NAME)->fetchAll();
		$entities = $this->createAllEntities($selection);
		return $entities;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findById($id)
	{
		$id = (int) $id;
		$selection = $this->context->table(static::TABLE_NAME)->where(array(
			 'id' => $id,
		))->fetch();
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
	
	private function createOneEntity(Selection $selection)
	{
		$entity = new Entities\Book();
		$entity->id = $selection->id;
		$entity->name = $selection->name;
		$entity->author = $selection->author;
		$entity->datePublished = new \DateTime($row->date_published);
		return $entity;
	}
}