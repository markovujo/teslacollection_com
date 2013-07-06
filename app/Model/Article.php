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
    
    public $hasAndBelongsToMany = array(
        'Subject' => array(
            'className' => 'Subject',
        )
        , 'Page' => array(
            'className' => 'Page',
        	'fields' => array('id', 'filename', 'full_path', 'status')
        )
    );
    
    public $actsAs = array('Containable');
    
	public function search($params)
	{
		$conditions = array();
		$joins = array();
		$group = array('Article.id');
		
		$fields = array(
			'Article.id',
			'Article.title',
			'Article.volume',
			'Article.page',
			'Article.date',
			'Article.year',
			'Article.range_text'
		);
		
		$contain = array(
			'Author' => array('fields' => array('id', 'name')),
			'Publication' => array('fields' => array('id', 'name')),
			'Subject' => array('fields' => array('id', 'name')),
			'Page' => array(
				'fields' => array('id', 'filename', 'ArticlesPage.id')
			),
		);
		
		$return = array(
			'criteria' => array()
		);
		
		if(isset($params['limit']) && !empty($params['limit'])) {
			$limit = (int) $params['limit'];
		} else {
			$limit = NULL;
		}
		
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
		
		if(isset($params['title_text']) && $params['title_text'] != '') {
			App::uses('Sanitize', 'Utility');
			$params['title_text'] = Sanitize::escape($params['title_text']);
			
			$conditions['Article.title LIKE'] = '%' . $params['title_text'] . '%';
			
			$return['criteria']['title_text'] = $params['title_text'];
		}
		
		if(isset($params['text_search']) && !empty($params['text_search'])) {
			App::uses('Sanitize', 'Utility');
			$params['text_search'] = Sanitize::escape($params['text_search']);
			
			$joins[] = array(
		     	'table' => 'articles_pages',
		    	'alias' => 'ArticlesPage',
		    	'type' => 'INNER',
		    	'conditions' => array(
		    		'Article.id = ArticlesPage.article_id'
		       	)
		    );
		    
		    $joins[] = array(
		     	'table' => 'pages',
		    	'alias' => 'Page',
		    	'type' => 'INNER',
		    	'conditions' => array(
		    		'ArticlesPage.page_id = Page.id'
		       	)
		    );
			
			$conditions[] = array( 
			   "MATCH(Page.text)  
			          AGAINST('" . $params['text_search'] . "' IN BOOLEAN MODE)" 
			);
			
			$return['criteria']['text_search'] = $params['text_search'];
		}
		
		$conditions['Article.status'] = 'active';
		
		
		$return['articles'] = $this->find('all', array(
			'conditions' => $conditions
			, 'contain' => $contain
			, 'joins' => $joins
			, 'group' => $group
			, 'fields' => $fields
			, 'limit' => $limit
		));
		
		/* DEBUGGING ::
		debug($params);
		debug($conditions);
		debug($joins);
		debug($return['articles']);
		die();
		*/
		
		//die(debug($return['articles']));
		//CAKEPHP CAN'T SORT BY filename FOR HABTM ASSOCIATED TABLE
		if(!empty($return['articles'])) {
			foreach($return['articles'] AS &$article) {
				if(isset($article['Page']) && !empty($article['Page'])) {
					$article['Page'] = Set::sort($article['Page'], '{n}.filename', 'asc');
				}
			}
		}
		
		//die(debug($return));
		return $return;
	}
}
?>