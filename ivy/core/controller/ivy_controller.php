<?php
/**
 * Top level controller class, instantiates all required classes for the called controller
 * 
 * The Controller deals with some base functionality that can be used by child
 * controllers
 * 
 * $Date$
 * $Author$
 * 
 * $Revision$
 * 
 * @package Controller
 * @version 4.0
 * 
 * @todo need to list a lot of the methods this class will have
 */

/**
 * Parent controller for all applications
 * 
 * Gives all application controllers access to some global methods 
 * and properties (such as user, datasource and error information
 */
abstract class ivy_controller 
{
	
/**
 * Local stylesheet declaration
 * 
 * @access protected
 * @var string
 */
protected $stylesheet = '';

/**
 * Global stylesheet declaration
 * 
 * @access protected
 * @var string
 */
protected $globalstylesheet = '';

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
 * Current user
 * 
 * @access protected
 * @var string
 */
protected $collar = '';


/**
 * Gives the application controllers something to use
 * 
 * @access public
 * @return void
 */
public function __construct ()
{
	$this->display = new ivy_display();
}


/**
 * Declare abstract function
 * 
 * All controllers will have an index method defined
 * 
 * @access public
 * @return void
 */
abstract public function index ();

}
?>