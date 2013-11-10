<?php
/**
 * SVN FILE: $Id: Ivy_Router.php 19 2008-10-02 07:56:39Z shadowpaktu $
 *
 * Project Name : Project Description
 *
 * @package className
 * @subpackage subclassName
 * @author $Author: shadowpaktu $
 * @copyright $Copyright$
 * @version $Revision: 19 $
 * @lastrevision $Date: 2008-10-02 08:56:39 +0100 (Thu, 02 Oct 2008) $
 * @modifiedby $LastChangedBy: shadowpaktu $
 * @lastmodified $LastChangedDate: 2008-10-02 08:56:39 +0100 (Thu, 02 Oct 2008) $
 * @license $License$
 * @filesource $URL: https://ivy.svn.sourceforge.net/svnroot/ivy/Ivy_Router.php $
 */
 
class router {
	private $args = array();
	
	public $navigation;
	
	private $get = array ();
	
	private $controller = 'index';
	
	private $action = 'index';
	
function __construct () {

	(array) $parserArray = array ();
	(array) $array = array ();
	(int) $ivyadmin = 0;

	$this->getController();

	if (is_readable(SITEPATH . '/application/' . SITE . '/controller/' . $this->controller . '.php')) {			
		$this->path = SITEPATH . '/application/' . SITE . '/controller';
	} else if (is_readable(SITEPATH . '/application/' . SITE . '/controller/' . $this->controller . '.php')) {
			$this->path = SITEPATH . '/application/' . SITE . '/controller';
	} else if (is_readable('core/controller/' . $this->controller . '.php')) {
			$this->path = 'controller';
	} else {
		header("HTTP/1.0 404 Not Found");
		echo 'controller/' . $this->controller . '.php' . '<br />';
		die ('404 Not Found');			
	}
}
	
/**
 *
 * @load the controller
 *
 * @access public
 * @return void
 */
public function loader () {
	(string) $class = $this->controller;
	(object) $controller = '';
	(string) $action = '';
	(array) $array = array ();

	require $this->path . '/' . $this->controller . '.php';

	/*** a new controller class instance ***/
	$controller = new $class($array);

	if ($this->action == 'index') {
		return;
	}
	
	/*** check if the action is callable ***/
	if (is_callable(array($controller, $this->action)) === false) {
		$action = 'index';
		$this->action = 'index';
	} else {
		$action = $this->action;
	}
		
	/* Pass the name of the class, not a declared handler */
	if (isset($this->get)) {
		$array = $this->get;
	}

	/*** run the action ***/echo 1;
	$controller->$action($array);
}


/**
 *
 * @get the controller
 *
 * @access private
 *
 * @return void
 *
 */
private function getController () {
	$controller = (string) '';
	$action = (string) '';
	$getArray = array ();
	$otherArray = array ();
	$this->action = 'index';
		
	/**
	 * new part as of April 20th 2010
	 * 
	 * checks the PATH_INFO section of the SERVER global to fingure out the controller
	 * and action, instead og $_GET variables
	 *
	 * July 2011 - edited to allow better URI mapping
	 */
	if (isset($_SERVER['QUERY_STRING'])) {
		$queryParts = explode('/', $_SERVER['QUERY_STRING']);


		/**
		 * check for a start slash and remove the empty value is there is one
		 */
		if (!$queryParts[0]) {
			array_shift($queryParts);
		}
		
		/**
		 * assign controller
		 */
		$this->controller = $_GET['controller'] = (isset($queryParts[0])) ? $queryParts[0] : 'index';
		array_shift($queryParts);

		/**
		 * assign action
		 */
		$this->action = $_GET['action'] = (isset($queryParts[0])) ? $queryParts[0] : 'index';
		array_shift($queryParts);

		/**
		 * we find the remaining values and assign them
		 */
		foreach ($queryParts as $key => $value) {
			if ($key === 0 && is_numeric($value)) {
				$this->s = $_GET['s'] = $value;
			}

			$temp = $key + 1;
			$this->{$temp} = $_GET[$temp] = $value;

			if ($value == 'ajax') {
				$_GET['ajax'] = 'ajax';
			}
		}
	} else {
		if (isset($_GET['controller']) && !empty($_GET['controller'])) {
			$this->controller = $_GET['controller'];
		}

		if (isset($_GET['action']) && !empty($_GET['action'])) {
			$this->action = $_GET['action'];
		}
	}

	$this->get = $_GET;
	$this->get['controller'] = $this->controller;
	$this->get['action'] = $this->action;
	$otherArray['dateViewed'] = time();
	$otherArray['controller'] = $this->controller;
	$otherArray['action'] = $this->action;

	if (isset($_SERVER['REQUEST_URI'])) {
		$otherArray['script'] = basename($_SERVER['REQUEST_URI']);
		$fullname = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	} else {
		$fullname = $_SERVER['SCRIPT_NAME'];
	}

	if (!isset($arr['referer'])) {
		$otherArray['referer'] = $fullname;
	}

	if (isset($_SERVER['HTTP_REFERER'])) {
		$arr['referer'] = $_SERVER['HTTP_REFERER'];

		if ($fullname != $_SERVER['HTTP_REFERER']) {
			$otherArray['referer'] = $_SERVER['HTTP_REFERER'];
		} else {
			$otherArray['referer'] = $arr['referer'];
		}
	} else {
		$arr['referer'] = '';
	}
}
}
?>