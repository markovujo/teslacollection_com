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
			$result = $this->Article->search($this->data['ArticleSearch']);
			$this->set('articles', $result['articles']);
			$this->set('criteria', $result['criteria']);
		}
		
		$this->set('selections', $selections);
	}
}
  