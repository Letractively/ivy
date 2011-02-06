<?php

class index_controller extends ivy_controller {
	
	
	
public function index ()
{
	$object = new ivy_datasource('user');
	$object->select(null, array('FIRSTNAME'));
}


}
?>