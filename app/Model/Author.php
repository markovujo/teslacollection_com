<?php 
class Author extends AppModel {

	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
		)
	);

	public $actsAs = array('Containable');
}