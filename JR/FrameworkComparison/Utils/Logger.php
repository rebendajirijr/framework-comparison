<?php

namespace JR\FrameworkComparison\Utils;

/**
 * Description of Logger
 *
 * @author RebendaJiri
 */
class Logger
{
//	const TYPE_ZEND_HOMEPAGE_CACHING = 'zend_homepage_caching';
//	const TYPE_ZEND_BOOKS_CACHING = 'zend_books_caching';
//	const TYPE_ZEND_BOOK_CACHING = 'zend_book_caching';
	const TYPE_ZEND_HOMEPAGE = 'zend_homepage';
	const TYPE_ZEND_BOOKS = 'zend_books';
	const TYPE_ZEND_BOOK = 'zend_book';
	
	const TYPE_NETTE_HOMEPAGE_CACHING = 'nette_homepage_caching';
	const TYPE_NETTE_BOOKS_CACHING = 'nette_books_caching';
	const TYPE_NETTE_BOOK_CACHING = 'nette_book_caching';
	const TYPE_NETTE_HOMEPAGE = 'nette_homepage';
	const TYPE_NETTE_BOOKS = 'nette_books';
	const TYPE_NETTE_BOOK = 'nette_book';
	
	const TYPE_PHALCON_HOMEPAGE_CACHING = 'phalcon_homepage_caching';
	const TYPE_PHALCON_BOOKS_CACHING = 'phalcon_books_caching';
	const TYPE_PHALCON_BOOK_CACHING = 'phalcon_book_caching';
	const TYPE_PHALCON_HOMEPAGE = 'phalcon_homepage';
	const TYPE_PHALCON_BOOKS = 'phalcon_books';
	const TYPE_PHALCON_BOOK = 'phalcon_book';
	
	/** @var stromg */
	private $logDirectory;
	
	public function __construct($logDirectory)
	{
		if (!is_dir($logDirectory)) {
			throw new \InvalidArgumentException("Given log directory '{$logDirectory}' not found.");
		}
		$this->logDirectory = rtrim($logDirectory, '/');
	}
	
	public function logTime($type, $time)
	{
		$filepath = $this->logDirectory . '/' . 'timelog.csv';
		
		if (FALSE === ($file = @fopen($filepath, 'a'))) {
			return FALSE;
		}
		
		if (FALSE == fputcsv($file, array(
			date('Y-m-d H:i:s'),
			$type,
			$time,
			memory_get_peak_usage(),
		))) {
			return FALSE;
		}
		
		return fclose($file);
	}
}