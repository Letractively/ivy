<?php
/**
 * Connector for MySQL 5
 * 
 * Takes the query parts from ivy_database nd recompiles them to generate a MySQL 5 
 * query that the database understands. The response is fed back to the database
 * controller, through the dictionary again before making it back to the calling
 * controller
 * 
 * $Date$
 * $Author$
 * 
 * $Revision$
 * 
 * @package Connecter
 * @version 4.0
 */

/**
 * MySQL datasource connecter
 *
 * @todo class specification, make an interface too
 */
class mysql {

/**
 * Contains reference to the current object.
 *
 * @access	public
 * @var		object
 */
public static $instance;

/**
 * Array of datasource connection details
 * 
 * As this is a singleton, we only have one instance of this class, so
 * for multiple different datasources of the same type we append an array
 * to hold the different details.
 * 
 * @access public
 * @var array
 */
private $connection = array ();


/**
 * Takes the datasource part of the model array
 * 
 * @access public
 * @return void
 * @param array $datasourceDetail
 */
public function __construct ($datasourceDetail)
{
	$this->connection = mysql_connect($datasourceDetail['datasource']['server'], 
							$datasourceDetail['datasource']['username'], 
							$datasourceDetail['datasource']['password']);

	$this->server = $datasourceDetail['datasource']['server'];
	$this->query['table'] = $datasourceDetail['table']['title'];
	/*
	 * connection to the server failed
	 */
	if (!$this->connection) {
	    die('Could not connect to "' . $this->server . '": ' . mysql_error());
	}
	
	
	if (!mysql_select_db($datasourceDetail['datasource']['datasource'])) {
		die('No such datasource "' . $this->server . '": ' . mysql_error());
	}
}

public function query ($query)
{
	if (isset($_GET['debug'])) {
		echo '<p>' . $query . '</p>';
	}
	
	$result = mysql_query($query) or die(mysql_error());
    if (!$result){
        $err = mysql_error();
        die($err);
    }
    
    /*
     * check for status return and not data
     */
    if (is_bool($result)) {
    	return $result;
    }
    
    if (isset($result)) {
    	
    	while ($line = mysql_fetch_assoc($result)) {
			$row[] = $line;
		}
			
		mysql_free_result($result);

		if (isset($row)) {
			$result = $row;
		}
    }
    

    
    return $result;
}

/**
 * Runs a select query on the database
 * 
 * Builds the select query based on what ivy_datasource passes to the mysql
 * class.
 * 
 * @access public
 * @return array
 * @param string $where The where part of our SQL statement
 * @param array $array A list of fields to get from the query
 */
public function select ($where = null, $array = null)
{
	$this->query['verb'] = 'SELECT ';
	
	foreach ($this->query['field'] as $key => &$value) {
		$value = $this->query['table'] . '.' . $value;
	}
	
	$query = $this->query['verb'] . ' ' . implode(', ', $this->query['field']) . ' FROM ' .
		$this->query['table'];

	return $this->query($query);
}

/**
 * 
 * @todo handle multiple row inserts
 */
public function insert ()
{
	$this->query['verb'] = 'INSERT ';
	
foreach ($this->query['data'] as $key => $value) {
		
	}
	
	$query = $this->query['verb'] . ' INTO ' . $this->query['table'] . ' SET ';
	
	foreach ($this->query['data'][0] as $key => $value) {
		$query .= $key . ' = "' . $value . '", ';
	}
	
	$query = rtrim($query, ', ');
	
	return $this->query($query);
}
}
?>