<?php

namespace JR\FrameworkComparison\Model\Entities;

/**
 * Description of Book
 *
 * @author RebendaJiri
 */
class Book extends Entity
{
	/** @var string */
	public $name;
	
	/** @var string */
	public $author;
	
	/** @var \DateTime */
	public $datePublished;
}