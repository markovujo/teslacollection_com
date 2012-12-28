<?php 
class ArticlePage extends AppModel 
{
	public $belongsTo = array(
        'Article' => array(
            'className'    => 'Article',
            'foreignKey'   => 'article_id'
        ),
    );
}
?>