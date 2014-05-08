<?php

namespace Application\Controller;

use Zend\Debug\Debug,
	Zend\View\Model\ViewModel,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Adapter\Profiler\Profiler,
	Zend\Db\Adapter\Driver\Mysqli,
	Zend\Db\Sql\Sql,
	Zend\Db\Sql\Ddl,
	Zend\Form\Factory,
	Zend\Validator;

class IndexController extends BaseController
{
    public function indexAction()
    {
//		$connectionInfo = array(
//			'hostname' => '127.0.0.1', // localhost
//			'username' => '',
//			'password' => '',
//			'database' => 'test',
//		);
//		$connection = new Mysqli\Connection($connectionInfo);
//		$driver = new Mysqli\Mysqli($connection);
//		$profiler = new Profiler();
//		
//		$adapter = new Adapter($driver);
//		$adapter->setProfiler($profiler);
//		
//		
//		$statement = $adapter->query('SELECT * FROM book');
//		$results = $statement->execute();
//		
//		foreach ($results as $row) {
//			echo ($row['name']) . '<br>';
//		}
//		print_r($profiler->getLastProfile());
		
//		$sql = new Sql($adapter);
//		$select = $sql->select();
//		$select->from('book');
//		
//		$statement = $adapter->query($sql->getSqlStringForSqlObject($select));
//		$results = $statement->execute();
//		
//		foreach ($results as $row) {
//			echo $row['name'] . '<br>';
//		}
		
//		$ddl = new Ddl\CreateTable('my_temporary_table', TRUE);
//		$ddl->addColumn(new Ddl\Column\Integer('id', FALSE));
//		$ddl->addColumn(new Ddl\Column\Varchar('name', 255));
//		
//		$sql = new Sql($adapter);
//		$adapter->query($sql->getSqlStringForSqlObject($ddl), Adapter::QUERY_MODE_EXECUTE);
		
        return new ViewModel();
    }
}