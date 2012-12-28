<?php 
class Author extends AppModel 
{
	public $hasMany = array(
        'Article' => array(
            'className'  => 'Article',
        )
    );
}
?>