<?php

namespace App\Presenters;

use Nette,
	App\Model,
	Nette\Diagnostics\Debugger,
	Nette\Database\Connection,
	Nette\Database\Context,
	Nette\Database\ResultSet;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	public function actionDefault()
	{
//		$connection = new Connection('mysql:host=127.0.0.1;dbname=test');
//		$context = new Context($connection);
//		$selection = $context->table('book');
		
//		foreach ($selection->fetchAll() as $book) {
//			echo $book->name . PHP_EOL;
//		}
//		
//		foreach ($selection->where(array('author' => 'Dan Brown')) as $book) {
//			echo $book->name . PHP_EOL;
//		}
		
//		$connection->onQuery[] = function (Connection $connection, $result) {
//			if ($result instanceof ResultSet) {
//				echo $result->getQueryString() . PHP_EOL;
//			}
//		};
//		
//		foreach ($selection as $book) {
//			echo $book->name . ':' . PHP_EOL;
//			foreach ($book->related('book_tag') as $bookTag) {
//				echo $bookTag->tag->name . PHP_EOL;
//			}
//			echo PHP_EOL;
//		}
	}
}