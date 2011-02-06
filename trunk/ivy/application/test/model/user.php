<?php

$array = array (
	'field'	=> array (
		'USERID'	=> array (
			'front'		=> array (
				'title'		=>	'Collar / user name',
				'type'		=>	'text',
			),
			'back'		=> array (
				'size'		=>	55,
				'required'	=>	'y',
				'unique'	=>	'y',
				'type'		=>	'var',
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
				'size'		=>	40
			),
		),
	),
	'table'	=> array (
		'title'		=>	'USER',
		'pk'		=>	array('USERID'),
		'auto'		=>	0
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
