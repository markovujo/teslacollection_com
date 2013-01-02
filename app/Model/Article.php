<?php 
class Article extends AppModel 
{
	public $belongsTo = array(
        'Author' => array(
            'className'    => 'Author',
            'foreignKey'   => 'author_id'
        ),
        'Publication' => array(
            'className'    => 'Publication',
            'foreignKey'   => 'publication_id'
        )
    );
    
    public $hasMany = array(
        'ArticlePage' => array(
            'className'  => 'ArticlePage',
        )
    );
    
    public $hasAndBelongsToMany = array(
        'Subject' => array(
            'className' => 'Subject',
        )
    );
    
    public $actsAs = array('Containable');
    
	public function search($params)
	{
		$conditions = array();
		$joins = array();
		
		$contain = array(
			'Author' => array('fields' => array('id', 'name')),
			'Publication' => array('fields' => array('id', 'name')),
			'ArticlePage' => array('fields' => array('id', 'filename')),
			'Subject' => array('fields' => array('id', 'name')),
		);
		
		if(isset($params['author_id']) && !empty($params['author_id'])) {
			$conditions['Author.id'] = (array) $params['author_id'];
		}
		
		if(isset($params['publication_id']) && !empty($params['publication_id'])) {
			$conditions['Publication.id'] = (array) $params['publication_id'];
		}
		
		if(isset($params['subject_id']) && !empty($params['subject_id'])) {
			$conditions['ArticlesSubjects.subject_id'] = (array) $params['subject_id'];
			$joins[] = array(
		     	'table' => 'articles_subjects',
		    	'alias' => 'ArticlesSubjects',
		    	'type' => 'LEFT',
		    	'conditions' => array(
		    		'Article.id = ArticlesSubjects.article_id'
		       	)
		    );
		}
		
		if(isset($params['year_id']) && !empty($params['year_id'])) {
			$conditions['Article.year'] = (array) $params['year_id'];
		}
		
		$results = $this->find('all', array(
			'conditions' => $conditions
			, 'contain' => $contain
			, 'joins' => $joins
		));
		
		//debug($params);
		//die(debug($results));
		return $results;
	}
}
?>