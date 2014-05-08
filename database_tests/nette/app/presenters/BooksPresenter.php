<?php

namespace App\Presenters;

use Nette,
	JR\FrameworkComparison\Model\Entities;

/**
 * Description of BooksPresenter
 *
 * @author RebendaJiri
 */
class BooksPresenter extends BasePresenter
{
	/**
	 * @inject
	 * @var JR\FrameworkComparison\Model\Facades\IBookFacade
	 */
	public $bookFacade;
	
	/** @var Entities\Book[] */
	private $books;
	
	public function actionDefault()
	{
		$this->books = $this->bookFacade->findAllBooks();
	}
	
	public function renderDefault()
	{
		$this->template->books = $this->books;
	}
}