<?php

namespace JR\FrameworkComparison\Model\Entities;

use Phalcon\Mvc\Model;

/**
 * This entity emulates primary Book entity
 * in terms of Phalcon\Mvc\Model.
 *
 * @author RebendaJiri
 */
class PhalconDbBook extends Model
{
	/** @var int */
	public $id;
	
	/** @var string */
	public $name;
	
	/** @var string */
	public $author;
	
	/** @var \DateTime */
	public $datePublished;
	
	public function __set($property, $value)
	{
		if ($property == 'date_published') {
			$this->datePublished = new \DateTime($value);
		} else {
			parent::__set($property, $value);
		}
	}
	
	public function getSource()
	{
		return 'book';
	}
}