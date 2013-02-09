<?php
App::uses('AdminAppController', 'Admin.Controller');
/**
 * Articles Controller
 *
 */
class ArticlesController extends AdminAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	//public $scaffold;
	var $uses = array('Article', 'ArticlePages', 'Page');
	
	public function __construct($id = false, $table = NULL, $ds = NULL)
	{
		$this->Model = $this->Article;
		parent::__construct($id, $table, $ds);
	}
	
	public function index()
	{
		$this->layout = 'admin';
	}
	
	public function getArticlePages($article_id = null) {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$response = array(
			'success' => true,
			'errors' => array(),
			'records' => array()
		);
		
		if(!is_null($article_id) && $article_id > 0) {
			$article = $this->Model->find('first', array(
				'conditions' => array(
					'Article.id' => $article_id
				),
		        'contain' => array( 
		        	'Page' => array('fields' => array('filename', 'full_path', 'status')) 
		        ) 
			));

			if($article) {
				if(isset($article['Page']) && !empty($article['Page'])) {
					$response['records']['Page'] = $article['Page'];
				}
			}
		}
		
		return (json_encode($response));
	}
	
	public function deleteArticlePageLink() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$response = array(
			'success' => true,
			'errors' => array(),
			'records' => array()
		);
		
		die(debug($this->params['data']));
		if($this->params['data']) {
			foreach($this->params['data'] AS $id) {
				if($this->ArticlesPage->delete($id)) {
					$response['records']['ArticlesPage'] = $id;
				} else {
					$errors[] = $this->Model->validationErrors;
					$errors[] = $this->Model->invalidFields();
				}
			}
		}
		
		return (json_encode($response));
	}
	
}
