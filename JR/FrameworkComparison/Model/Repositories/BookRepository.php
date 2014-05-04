<?php

namespace JR\FrameworkComparison\Model\Repositories;

use JR\FrameworkComparison\Model\Entities;

/**
 * Description of BookRepository
 *
 * @author RebendaJiri
 */
class BookRepository implements IBookRepository
{
	/** @var string */
	private $xmlFilename;
	
	/**
	 * @param string $xmlFilename
	 * @throws \InvalidArgumentException if given file not found
	 */
	public function __construct($xmlFilename)
	{
		if (!is_file($xmlFilename)) {
			throw new \InvalidArgumentException("Given file '{$xmlFilename}' does not exist.");
		}
		$this->xmlFilename = $xmlFilename;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findAll()
	{
		$xml = $this->parseFile($this->xmlFilename);
		$entities = $this->createAllEntities($xml);
		return $entities;
	}

	/*
	 * @inheritdoc
	 */
	public function findById($id)
	{
		$xml = $this->parseFile($this->xmlFilename);
		$entity = $this->createOneEntity($xml, $id);
		return $entity;
	}
	
	private function parseFile($filepath)
	{
		$xml = simplexml_load_file($filepath);
		if ($xml === FALSE) {
			throw new \InvalidArgumentException("Given file '{$filepath}' cannot be parsed.");
		}
		return $xml;
	}
	
	private function createAllEntities(\SimpleXMLElement $xml)
	{
		$entities = array();
		
		foreach ($xml->book as $bookElement) {
			$book = new Entities\Book();
			$book->id = (int) $bookElement['id'];
			$book->name = (string) $bookElement['name'];
			$book->author = (string) $bookElement['author'];
			$book->datePublished = new \DateTime($bookElement['date-published']);

			$entities[$book->id] = $book;
		}
		
		return $entities;
	}
	
	private function createOneEntity(\SimpleXMLElement $xml, $id)
	{
		$id = (int) $id;
		$result = $xml->xpath('//books/book[@id="' . $id . '"]');
		
		if (isset($result[0])) {
			$bookElement = $result[0];
			
			$book = new Entities\Book();
			$book->id = (int) $bookElement['id'];
			$book->name = (string) $bookElement['name'];
			$book->author = (string) $bookElement['author'];
			$book->datePublished = new \DateTime($bookElement['date-published']);
			
			return $book;
		}
		return NULL;
	}
}