<?php

class index_controller extends ivy_controller {
	
	
	
public function index ()
{
	$object = new ivy_datasource('user');
	
	//$object->select(null, array('FIRSTNAME'));
	
	$_POST['FIRSTNAME'] = 'test';
	$_POST['UNKNOWNFIELD'] = 'unknown';
	
	$array = $_POST;
	
	$object->insert();
	
}


}
?>