<?php
/**
 * High level API for dealing with datasources (DB's, files etc)
 * 
 * Top level API for all ivy sites. This gives the user access to methods 
 * such as select, insert, update and delete, as well as the ability to 
 * create and drop datasource components (tables, fields, files, directories
 * via the lower level connecter APIs). 
 * 
 * $Date$
 * $Author$
 * 
 * $Revision$
 * 
 * @package Controller
 * @version 4.0
 */

/**
 * Universal datasource API
 * 
 * Allows you to connect to anything we have a connector for
 * 
 * @todo need to list a lot of the methods this class will have
 */
class datasource {

/**
 * The data from the model file, in array notation
 * 
 * @access private
 * @var array
 */
private $model = array ();

/**
 * Holes data from select queries
 * 
 * @access public
 * @var array
 */
public $data = array ();

/**
 * Tells the API what model file to load
 * 
 * Gives the object a model file to play with so we know what datasource
 * we are connecting to, what type it is, and use the right connector to
 * query the datasource.
 * 
 * @access	public
 * @return	void
 * @param	string	$model	Name of the model file to load
 * @todo	er, build perhaps?
 */
public function __construct ($model)
{
	/*
	 * figure out where this model file is
	 */
	$this->_loadModel($model);
	
	/*
	 * lets start of the whole datasource process of
	 */
	$this->_initiate();
	
}

/**
 * Look at the model file
 * 
 * Finds the model file then assigns it's contents to the local _model property
 * 
 * @param string $fileName Name of the model to load
 * @access private
 * @return array
 */
private function _loadModel ($fileName)
{
	
	/*
	 * full path and name of the file to look for, without extension
	 */
	(string) $pathFileName = 'application/' . SITE . '/model/' . $fileName;

	/*
	 * lets find out what file type it is
	 */
	(string) $model = $pathFileName . '.' . ivy::fileExt($pathFileName);
	echo $model;
	/*
	 * The name of the data called from the model file is in $array
	 */
	(array) $array = array();
	
	
	require_once($model);
	return $this->model = $array;
}

/**
 * Starts looking at all the model details
 * 
 * Finds out what type of datasource this is, loads up the correct connecter,
 * then tries to connect to it
 * 
 * @access private
 * @return array
 */
private function _initiate ()
{
	$datasourceType = $this->model['datasource']['type'];
	$this->datasource = new $datasourceType($this->model);
	//$this->datasource->
	
}

/**
 * Runs a select statement through the connector
 * 
 * This selects, gets or just finds information from the chosen datasource in
 * the model. We keep this method generic so we can pass it to the connector 
 * for proper query building
 * 
 * @access public
 * @return array
 * @param string $where The where part of our SQL statement
 * @param array $array A list of fields to get from the query
 */
public function select ($where = null, $array = null)
{
	
	$this->datasource->query['field'] = $this->_fieldExist($array);
	
	$this->data = $this->datasource->select();
}

/**
 * Uses the connector to run queries depending on it's functionality
 * 
 * the __call is used to utilise all of a connectors methods. This is so we 
 * don't have to maintain the ivy_datasource file every time a connector 
 * introduces a new method
 * 
 * @access public
 * @return object
 */
public function __call ($method, $parameters) 
{
	//$this->datasource->
}

/**
 * Runs an insert statment through the connector
 * 
 * By default this looks at the $_POST array for it's information. Wraps up
 * the details and sends it to the datasource connector speficified in the 
 * model
 * 
 * @access public
 * @return bool
 * @param array $array Array of data to insert to the database
 */
public function insert (array $array = null)
{
	/*
	 * check if were passing an array, if not then use what's in $_POST.
	 * and if nothing is there then return false
	 */
	if ($array) {
		
	} else if ($_POST) {
		$array = $_POST;
	} else {
		return false;
	}
	
	/*
	 * figure out if this is an array of rows, or just one
	 */
	if (isset($array[0])) {
		foreach ($array as $key => $data) {
			$this->datasource->query['data'][] = $this->_fieldExist($data);
		}
	} else {
		$this->datasource->query['data'][0] = $this->_fieldExist($array);
	}
	

	$this->datasource->insert();
}

/**
 * Looks at the fields we want to see if they exist in the model
 * 
 * The calling method has the option to choose what fields they want from the 
 * datasources table, this method checks that if they have asked for specific 
 * ones, then do they exist in the model? We strip out any fields that don't.
 * 
 * @access private
 * @return array
 * @param array $array List of the fields to check
 */
private function _fieldExist ($array = null)
{
	/*
	 * if the array is empty then return all the fields
	 */
	if (!$array) {
		return array_keys($this->model['field']);
	}
	
	/*
	 * we loop through the model to find required fields, include those then 
	 * compare with what the user wants
	 */
	foreach ($this->model['field'] as $field => $data) {
		/*
		 * are there any required fields?
		 */
		if (isset($data['back']['required'])) {
			$result[$field] = $field;
		}
		
		/*
		 * loop through the user field array to check those fields against the 
		 * model
		 */
		foreach ($array as $key) {
			if ($field == $key) {
				$result[$field] = $field;
			}
		}
 	}
 	
 	return $result;
}
}