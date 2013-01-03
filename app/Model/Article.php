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
    		'order' => 'filename'
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
		$group = array('Article.id');
		
		$contain = array(
			'Author' => array('fields' => array('id', 'name')),
			'Publication' => array('fields' => array('id', 'name')),
			'ArticlePage' => array('fields' => array('id', 'filename', 'title')),
			'Subject' => array('fields' => array('id', 'name')),
		);
		
		$return = array(
			'criteria' => array()
		);
		
		if(isset($params['author_id']) && !empty($params['author_id'])) {
			if(!in_array('ALL', $params['author_id'])) {
				$conditions['Author.id'] = (array) $params['author_id'];
				$return['criteria']['author'] = $params['author_id'];
			}
		}
		
		if(isset($params['publication_id']) && !empty($params['publication_id'])) {
			if(!in_array('ALL', $params['publication_id'])) {
				$conditions['Publication.id'] = (array) $params['publication_id'];
				$return['criteria']['publication'] = $params['publication_id'];
			}
		}
		
		if(isset($params['subject_id']) && !empty($params['subject_id'])) {
			if(!in_array('ALL', $params['subject_id'])) {
				$conditions['ArticlesSubject.subject_id'] = (array) $params['subject_id'];
				$joins[] = array(
			     	'table' => 'articles_subjects',
			    	'alias' => 'ArticlesSubject',
			    	'type' => 'LEFT',
			    	'conditions' => array(
			    		'Article.id = ArticlesSubject.article_id'
			       	)
			    );
			    $return['criteria']['subject'] = $params['subject_id'];
			}
		}
		
		if(isset($params['year_id']) && !empty($params['year_id'])) {
			if(!in_array('ALL', $params['year_id'])) {
				$conditions['Article.year'] = (array) $params['year_id'];
				$return['criteria']['year'] = $params['year_id'];
			}
		}
		
		if(isset($params['text_search']) && !empty($params['text_search'])) {
			# Sanitize the query 
			App::uses('Sanitize', 'Utility');
			$params['text_search'] = Sanitize::escape($params['text_search']);
			
			$conditions[] = array( 
			   "MATCH(ArticlePage.title, ArticlePage.text)  
			          AGAINST('" . $params['text_search'] . "' IN BOOLEAN MODE)" 
			);
			
			$joins[] = array(
		     	'table' => 'article_pages',
		    	'alias' => 'ArticlePage',
		    	'type' => 'INNER',
		    	'conditions' => array(
		    		'Article.id = ArticlePage.article_id'
		       	)
		    );
			
			$return['criteria']['text_search'] = $params['text_search'];
		}
		
		$return['articles'] = $this->find('all', array(
			'conditions' => $conditions
			, 'contain' => $contain
			, 'joins' => $joins
			, 'group' => $group
		));

		/* DEBUGGING :: 
		debug($params);
		debug($conditions);
		debug($joins);
		debug($return);
		die();
		*/
		return $return;
	}
}
?>