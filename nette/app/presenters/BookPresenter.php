<?php

namespace App\Presenters;

use Nette,
	Nette\Application\BadRequestException,
	JR\FrameworkComparison\Model\Entities;

/**
 * Description of BookPresenter
 *
 * @author RebendaJiri
 */
class BookPresenter extends BasePresenter
{
	/**
	 * @persistent
	 * @var int
	 */
	public $id;
	
	/**
	 * @inject
	 * @var JR\FrameworkComparison\Model\Facades\IBookFacade
	 */
	public $bookFacade;
	
	/** @var Entities\Book */
	private $book;
	
	protected function startup()
	{
		parent::startup();
		
		if (!($this->id = $this->getParameter('id'))) {
			throw new BadRequestException('Unknown book id.');
		}
		if (NULL === ($this->book = $this->bookFacade->findOneBook($this->id))) {
			throw new BadRequestException("Book with ID '{$this->id}' not found.");
		}
	}
	
	protected function beforeRender()
	{
		parent::beforeRender();
		
		$this->template->book = $this->book;
	}
}