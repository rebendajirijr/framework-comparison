<?php

namespace JR\FrameworkComparison\Model\Facades;

use JR\FrameworkComparison\Model\Repositories,
	JR\FrameworkComparison\Model\Entities;

/**
 * Description of BookFacade
 *
 * @author RebendaJiri
 */
class BookFacade implements IBookFacade
{
	/** @var Repositories\IBookRepository */
	private $bookRepository;
	
	/**
	 * @param Repositories\IBookRepository $bookRepository
	 */
	public function __construct(Repositories\IBookRepository $bookRepository)
	{
		$this->bookRepository = $bookRepository;
	}
	
	/*
	 * @inheritdoc
	 */
	public function findOneBook($id)
	{
		return $this->bookRepository->findById($id);
	}
	
	/*
	 * @inheritdoc
	 */
	public function findAllBooks()
	{
		return $this->bookRepository->findAll();
	}
}