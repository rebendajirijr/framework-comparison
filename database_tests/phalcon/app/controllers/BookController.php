<?php

use JR\FrameworkComparision\Model\Entities;

/**
 * Description of BookController
 *
 * @author RebendaJiri
 */
class BookController extends BaseController
{	
	/** @var JR\FrameworkComparision\Model\Facades\IBookFacade */
	private $bookFacade;
	
	/** @var Entities\Book */
	private $book;
	
	public function initialize()
	{
		$this->bookFacade = $this->getDI()->get('bookFacade');
	}
	
	public function indexAction($id)
	{
		$this->initializeBook($id);
	}
	
	protected function initializeBook($id)
	{
		if (NULL === ($this->book = $this->bookFacade->findOneBook($id))) {
			throw new \Exception("Book with ID '{$this->id}' not found.");
		}
		
		$this->view->book = $this->book;
	}
}