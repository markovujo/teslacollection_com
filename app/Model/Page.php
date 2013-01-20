<?php 
class Page extends AppModel 
{
	public $hasAndBelongsToMany = array(
        'Article' => array(
            'className' => 'Article',
        )
    );
    
    public $actsAs = array('Containable');
}
?>