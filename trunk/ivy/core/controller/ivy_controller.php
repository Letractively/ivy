<?php
/**
 * Top level controller class, instantiates all required classes for the called controller
 * 
 * The Controller deals with some base functionality that can be used by child
 * controllers
 * 
 * @author James Randell <james.randell@ivyframework.com>
 * @version 4.0.1
 * @package	Core
 * 
 * @todo need to list a lot of the methods this class will have
 */

abstract class ivy_controller 
{
	
/**
 * Local stylesheet declaration
 */
protected $stylesheet = '';

/**
 * Global stylesheet declaration
 */
public $globalstylesheet = '';

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


protected $collar = '';


public function __construct ()
{
	$this->display = new ivy_display();
}


/**
 * Declare abstract function
 * 
 * All controllers will have an index method defined
 */
abstract function index ();






}
?>