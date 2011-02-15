<?php

$array = array (
	'field'	=> array (
		'USERID'	=> array (
			'front'		=> array (
				'title'		=>	'User id',
				'type'		=>	'hidden',
			),
			'back'		=> array (
				'size'		=>	10,
				'required'	=>	'y',
				'type'		=>	'int',
				'auto'		=>	'y',
			)
		),
		'FIRSTNAME'	=> array (
			'front'		=> array (
				'title'		=>	'Firstname',
				'type'		=>	'text',
			),
			'back'		=> array (
				'type'		=>	'var',
				'required'	=>	'y',
				'size'		=>	40
			),
		),
		'LASTNAME'	=> array (
			'front'		=> array (
				'title'		=>	'Lastname',
				'type'		=>	'text',
			),
			'back'		=> array (
				'type'		=>	'var',
				'required'	=>	'y',
				'size'		=>	40
			),
		),
		'EMAIL'	=> array (
			'front'		=> array (
				'title'		=>	'EMail',
				'type'		=>	'text',
				'class'		=>	'email_check'
			),
			'back'		=> array (
				'type'		=>	'var',
				'required'	=>	'y',
				'size'		=>	55
			),
		),
	),
	'table'	=> array (
		'title'		=>	'USER',
		'pk'		=>	array('USERID')
	),
	
	'datasource'	=> array (
		'type'		=>	'mysql',
		'server'	=>	'localhost',
		'datasource'=>	'test',
		'username'	=>	'root',
		'password'	=>	'',
	)
);
?>
