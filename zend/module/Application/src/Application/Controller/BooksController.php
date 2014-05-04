<?php

namespace Application\Controller;

use JR\FrameworkComparison\Model\Entities;

/**
 * Description of BooksController
 *
 * @author RebendaJiri
 */
class BooksController extends BaseController
{
	/** @var JR\FrameworkComparison\Model\Facades\IBookFacade */
	private $bookFacade;
	
	/** @var Entities\Book[] */
	private $books;
	
	public function indexAction()
	{
		$this->bookFacade = $this->serviceLocator->get('bookFacade');
		
		$this->books = $this->bookFacade->findAllBooks();
		
		return new \Zend\View\Model\ViewModel(array(
			'books' => $this->books,
		));
	}
}