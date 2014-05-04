<?php

namespace JR\FrameworkComparison\Model\Repositories;

use JR\FrameworkComparison\Model\Entities;

/**
 * @author RebendaJiri
 */
interface IBookRepository
{
	/**
	 * @return Entities\Book|NULL
	 */
	function findById($id);
	
	/**
	 * @return Entities\Book[]
	 */
	function findAll();
}