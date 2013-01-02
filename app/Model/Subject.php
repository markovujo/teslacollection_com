<?php 
class Subject extends AppModel 
{
	public $hasAndBelongsToMany = array(
        'Article' => array(
            'className' => 'Article',
        )
    );
    
    public $actsAs = array('Containable');
}
?>