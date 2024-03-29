<?php
/**
 * Router module for Ivy framework
 *
 * @file: $Id: ivy.php 22 2013-10-20 07:59:32Z jamesrandell@me.com $
 *
 * Project Name : Project Description
 *
 * @project Ivy Framework 4
 * @package Controller
 * @version: 4.0
 * @subpackage Ivy
 * @author $Author: jamesrandell@me.com $
 * @copyright $Copyright$
 * @version $Revision: 22 $
 * @lastrevision $Date: 2013-10-20 08:59:32 +0100 (Sun, 20 Oct 2013) $
 * @modifiedby $LastChangedBy: jamesrandell@me.com $
 * @lastmodified $LastChangedDate: 2013-10-20 08:59:32 +0100 (Sun, 20 Oct 2013) $
 * @license $License$
 * @filesource $URL: https://ivy.googlecode.com/svn/trunk/ivy/core/controller/ivy.php $
 */

/**
 * The full path of the orininal site location
 */
define('SITEPATH', dirname($_SERVER['SCRIPT_FILENAME']));

/**
 * Start the timer
 */
define('TIMER', microtime());

/**
 * define error reporting levels
 */

define('E_USER_SLOWSCRIPT', 1048);


/**
 * When classes are called autoload the files they're held in
 * 
 * @param string $class_name Name of the classes
 */
function __autoload($class_name) {

	$parts = explode('/', $_SERVER['SCRIPT_NAME']);
	$file = explode('.', $parts[sizeof($parts)-1]);

	$directories = array (
		'application/' . $file[0] . '/controller/',
		'core/templating/',
		'core/controller/',
		'core/connecter/'
	);
	
	foreach ($directories as $directory) {
		if (is_file($directory.$class_name . '.php')) {
			require_once $directory . $class_name . '.php';
			return;
		}
	}
}


/**
 * Main Ivy class, first to be called from the application file
 * 
 * First class to be instatiated. Deals with configuration and setting up the system 
 * for first time use. Loads site configuration, site extensions and adds data to 
 * the registry.
 */  
class ivy {

/**
 * name of the invoked class
 * 
 * @access	protected
 * @var		string
 */
protected $controller = 'index';
	
/**
 * name of the invoked method
 * 
 * @access	protected
 * @var		string
 */
protected $action = 'index';


/**
 * Sets up the URI components for the framework
 * 
 * Stores default query parts, and breaks up the PATH_INFO information
 * in the $_SERVER array to figure out what controller and action the 
 * borwser wants.
 * 
 * @access public
 * @return void
 */
public function __construct ()
{echo 4;
	/*
	 * stores the seperate query parts
	 */
	(array) $queryParts = array(
		0	=>	'index',
		1	=>	'index'
	);

	
	/*
	 * lets get the name of the file being called, this will be the 
	 * name of the site we're calling
	 */
	$parts = explode('/', $_SERVER['SCRIPT_NAME']);
	$file = explode('.', $parts[sizeof($parts)-1]);

	$this->application = $file[0];


	if (isset($_SERVER['PATH_INFO'])) {
		$queryParts = explode('/', $_SERVER['PATH_INFO']);
	}
	

	/**
	 * assign the path
	 */
	$this->path = dirname($_SERVER['SCRIPT_FILENAME']) . '';

	/**
	 * assign controller
	 */
	if (isset($queryParts[1])) {
		$this->controller = $_GET['controller'] = $queryParts[1];
	}
	
	/**
	 * assign action
	 */
	if (isset($queryParts[2])) {
		$this->action = $_GET['action'] = $queryParts[2];
	}

	/**
	 * we find the last value after the 2nd on and assign it to s
	 */
	if (isset($queryParts[3])) {
		echo $this->s = $_GET['s'] = $queryParts[3];
	}
}


/**
 * Returns what file extension a file is
 * 
 * Figures out what file type the model is so we can load it.
 * Runs through from PHP then XML
 * 
 * @param string $pathFileName Name of the file to check
 * @access public
 * @return string
 */
public static function fileExt ($pathFileName)
{
	if (file_exists($pathFileName . '.php') !== false) {
		return 'php';
	} else if (file_exists($pathFileName . '.htm') !== false) {
		return 'htm';
	} else if (file_exists($pathFileName . '.xml') !== false) {
		return 'xml';
	}
	
	/*
	 * if nothing matches then return false
	 */
	return false;
}



/**
 * called from the index file, this instantiates the correct controller
 *
 * @access public
 * @return void
 */
public function loader ()
{
	/**
	 * name of the controller class to use
	 */
	(string) $class = $this->controller . '_controller';
	
	/**
	 * controller object to load
	 */
	(object) $controller = '';
	
	/**
	 * local var for the action
	 */
	(string) $action = $this->action;
	
	(array) $array = array ();
	
	
	require_once $this->path . '/application/' . $this->application . '/controller/' . $this->controller . '.php';
	
	/**
	 * call the class giving it access to the registry
	 */
	$controller = new $class();//new $class($this->registry);
	
	/**
	 * is the method/action callable?
	 */
	if (is_callable(array($controller, $this->action)) === false) {
		trigger_error('The method: <strong>' . $this->action . '</strong> was not found ');
		$this->action = 'index';
	}
		
	/**
	 *  Pass the name of the class, not a declared handler 
	 */
	if (isset($_GET)) {
		$this->get = $_GET;
	}

	/**
	 * run the method/action
	 */
	$controller->{$this->action}();
}

}
?>