<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Description of BaseController
 *
 * @author RebendaJiri
 */
abstract class BaseController extends AbstractActionController
{
	/**
	 * Returns route parameter value.
	 * 
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	protected function getRouteParameter($name, $default = NULL)
	{
		return $this->getEvent()->getRouteMatch()->getParam($name,  $default);
	}
}
