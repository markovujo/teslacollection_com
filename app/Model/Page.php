<?php 
class Page extends AppModel {

	public $hasAndBelongsToMany = array(
		'Article' => array(
			'className' => 'Article',
			'fields' => array(),
		)
	);

	public $actsAs = array('Containable');
}