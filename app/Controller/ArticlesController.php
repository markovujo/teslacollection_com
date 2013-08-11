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
	
	function viewByUrl($url) 
	{ 
	    $post = $this->findByUrl($url); 
	     
	    $this->set('article', $article);
	}
	
	/**
	 * Slug format
	 * year/publication/author/article
	 * @throws NotFoundException
	 */
	public function viewBySlug()
	{
		// Get n parameters from url (1)
		$args = func_get_args();
		$last_arg = $args[count($args) - 1];
		
		// Check if this is an article (2)
		$article = $this->Article->find('first', array(
			'conditions' => array('Article.slug' => $last_arg
		));
		
		if (!empty($article)) {
			$this->set('article', $article);
			$this->render('view');
		}
		
		// Check if this is an author (2)
		$category = $this->Category->find('first', array(
			'conditions' => array('Category.slug' => $last_arg
		));
		
		if (!empty($category)) {
      		$this->set('category', $category);
      		$this->render('category');
    	}

    	// Page not found
    	if (empty($article) and empty($category)) {
			throw new NotFoundException();
    	}
	}
}
  