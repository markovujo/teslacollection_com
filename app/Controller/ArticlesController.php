<?php
/**
 * Articles Controller
 */

App::uses('AppController', 'Controller');

/**
 * Article Controller
 *
 */
class ArticlesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Articles';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'Article',
		'Author',
		'Publication',
		'Subject'
	);

	public function index()
	{
		$selections = array(
			'author' => array()
			, 'publication' => array()
			, 'subject' => array()
		);
		
		$ids = array_keys($selections);
		if(!empty($ids)) {
			foreach($ids AS $id) {
				$Model = ucwords($id);
				$results = $this->$Model->find('all', array(
					'fields' => array(
						$Model . '.id'
						, $Model . '.name')
					, 'contain' => array()
					, 'order' => array($Model . '.name') 
				));
				
				$selections[$id]['ALL'] = '-- ALL --';
				if($results) {
					foreach($results AS $result) {
						$record_id = $result[$Model]['id'];
						$record_value = $result[$Model]['name'];
						
						$selections[$id][$record_id] = $record_value;
					}
				}
			}
		}
		
		$years = $this->Article->find('all', array(
			'fields' => array('Article.year')
			, 'group' => 'Article.year'
			, 'contain' => false
			, 'order' => array('Article.year')
		));
		
		$selections['year']['ALL'] = '-- ALL --';
		if($years) {
			foreach($years AS $year) {
				$id = $year['Article']['year'];
				$value = $year['Article']['year'];
				
				$selections['year'][$id] = $value;
			}
		}
		
		if(isset($this->data['ArticleSearch']) && !empty($this->data['ArticleSearch'])) {
			$search_results = $this->Article->search($this->data['ArticleSearch']);
			
			if(isset($search_results['criteria']) && !empty($search_results['criteria'])) {
				foreach($search_results['criteria'] AS $key => $ids) {
					if(isset($selections[$key])) {
						$new_values = array();
						foreach($ids AS $id) {
							if(isset($selections[$key][$id])) {
								$new_values[$id] = $selections[$key][$id];
							} else {
								$new_values[$id] = $id;
							}
						}
						$search_results['criteria'][$key] = $new_values;
					}
				}
			}
			
			//die(debug($search_results));
			$this->set('search_results', $search_results);
		}
		
		$this->set('selections', $selections);
	}
	
	public function search()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$search_results = array();
		
		$selections = array(
			'author' => array()
			, 'publication' => array()
			, 'subject' => array()
		);
		
		$ids = array_keys($selections);
		if(!empty($ids)) {
			foreach($ids AS $id) {
				$Model = ucwords($id);
				$results = $this->{$Model}->find('all', array(
					'fields' => array(
						$Model . '.id'
						, $Model . '.name')
					, 'contain' => array()
					, 'order' => array($Model . '.name') 
				));
				
				if($results) {
					foreach($results AS $result) {
						$record_id = $result[$Model]['id'];
						$record_value = $result[$Model]['name'];
						
						$selections[$id][$record_id] = $record_value;
					}
				}
			}
		}
		
		$years = $this->Article->find('all', array(
			'fields' => array('Article.year')
			, 'group' => 'Article.year'
			, 'contain' => false
			, 'order' => array('Article.year')
		));
		
		if($years) {
			foreach($years AS $year) {
				$id = $year['Article']['year'];
				$value = $year['Article']['year'];
				
				$selections['year'][$id] = $value;
			}
		}
		
		if(isset($this->data['ArticleSearch']) && !empty($this->data['ArticleSearch'])) {
			$search_results = $this->Article->search($this->data['ArticleSearch']);
			
			if(isset($search_results['criteria']) && !empty($search_results['criteria'])) {
				foreach($search_results['criteria'] AS $key => $ids) {
					if(isset($selections[$key])) {
						$new_values = array();
						foreach($ids AS $id) {
							if(isset($selections[$key][$id])) {
								$new_values[$id] = $selections[$key][$id];
							} else {
								$new_values[$id] = $id;
							}
						}
						$search_results['criteria'][$key] = $new_values;
					}
				}
			}
		}
		
		return (json_encode($search_results));
	}
	
	public function view($id = NULL)
	{
		if(!is_null($id) && $id > 0) {
			$article = $this->Article->find('first', array(
				'conditions' => array(
					'Article.id' => $id
				)
			));
			
			$this->set('article', $article);
		}
	}
	
	public function viewAll($articles)
	{
		$this->set('articles', $articles);
	}
	
	function viewByUrl($url) 
	{ 
	    $post = $this->findByUrl($url); 
	     
	    $this->set('article', $article);
	}
	
	/**
	 * Slug format
	 * 		articles/year/publication/author/article_slug
	 * @throws NotFoundException
	 */
	public function viewBySlug()
	{	
		$args = func_get_args();
		$last_arg = $args[count($args) - 1];
		
		$article = $this->Article->find('first', array(
			'conditions' => array('Article.url' => $last_arg
		)));
		
		if (!empty($article)) {
			$this->set('title_for_layout', $article['Article']['title']);
			$this->set('article', $article);
			$this->render('view');
		} else {
			$articles = array();
			
			$author = $this->Author->find('first', array(
				'conditions' => array('Author.url' => $last_arg),
				'contain' => false
			));
			
			if (!empty($author)) {
	      		$articles = $this->Article->search($conditions = array('author_id' => array($author['Author']['id'])));
	    	} else {
	    		$publication = $this->Publication->find('first', array(
					'conditions' => array('Publication.url' => $last_arg),
					'contain' => false
				));
				
				if (!empty($publication)) {
					$articles = $this->Article->search($conditions = array('publication_id' => array($publication['Publication']['id'])));
				} else {
					if(is_numeric($last_arg) && $last_arg > 0 && $last_arg < 9999) {
						$year = (int) $last_arg;
						$articles = $this->Article->search($conditions = array('year_id' => array($year)));
					}
				}
	    	}
	    	
	    	if(empty($articles)) {
	    		$this->redirect('/');
	    	} else {
	    		$this->set('criteria', $articles['criteria']);
	    		$this->set('articles', $articles['articles']);
	    	}
		}
	}
	
	function sitemap()
	{
	    $articles = $this->Article->find('all');
	
	    $this->set(compact('articles'));
	    $this->RequestHandler->respondAs('xml');
	}
}
  