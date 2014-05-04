<?php

namespace JR\FrameworkComparison\Model\Facades;

use JR\FrameworkComparison\Model\Entities;

/**
 * @author RebendaJiri
 */
interface IBookFacade
{
	/**
	 * @return Entities\Book|NULL
	 */
	function findOneBook($id);
	
	/**
	 * @param int $id
	 * @return Entities\Book[]
	 */
	function findAllBooks();
}