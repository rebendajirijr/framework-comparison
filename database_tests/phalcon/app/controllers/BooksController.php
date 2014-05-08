<?php

use JR\FrameworkComparision\Model\Entities;

/**
 * Description of BooksController
 *
 * @author RebendaJiri
 */
class BooksController extends BaseController
{
	/** @var JR\FrameworkComparision\Model\Facades\IBookFacade */
	private $bookFacade;
	
	/** @var Entities\Book[] */
	private $books;
	
	public function initialize()
	{
		$this->bookFacade = $this->getDI()->get('bookFacade');
	}
	
	public function indexAction()
	{
		$this->books = $this->bookFacade->findAllBooks();
		$this->view->books = $this->books;
	}
}