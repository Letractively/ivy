<?php

class index_controller extends ivy_controller {
	
	
	
public function index ()
{
	$object = new ivy_datasource('user');
	
	$object->select(null, array('FIRSTNAME'));

	echo '<pre>';
	print_r($object->data);
	echo '</pre>';
	
	$_POST['FIRSTNAME'] = 'test';
	$_POST['LASTNAME'] = 'test';
	$_POST['EMAIL'] = 'test';
	$_POST['UNKNOWNFIELD'] = 'unknown';
	
	$array = $_POST;

	//$object->insert();
	
}

public function t ()
{
	echo 't';
}

}
?>