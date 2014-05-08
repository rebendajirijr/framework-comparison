<?php

namespace Application\Controller;

use JR\FrameworkComparison\Model\Entities;

/**
 * Description of BookController
 *
 * @author RebendaJiri
 */
class BookController extends BaseController
{
	/** @var JR\FrameworkComparison\Model\Facades\IBookFacade */
	private $bookFacade;
	
	/** @var Entities\Book */
	private $book;
	
	public function indexAction()
	{
		if (!($id = $this->getRouteParameter('id'))) {
			throw new \Exception('Unknown book ID.');
		}
		$this->bookFacade = $this->serviceLocator->get('bookFacade');	
		
		if (NULL === ($this->book = $this->bookFacade->findOneBook($id))) {
			 throw new \Exception("Book with ID '{$id}' not found.");
		}
		
		return new \Zend\View\Model\ViewModel(array(
			'book' => $this->book,
		));
	}
}