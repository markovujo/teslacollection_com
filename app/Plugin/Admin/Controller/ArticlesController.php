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
	var $uses = array('Article', 'ArticlesPage', 'Page');
	
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
		        	'Page' => array('fields' => array('id', 'filename', 'full_path', 'status')) 
		        ) 
			));

			//die(debug($article));
			if($article) {
				if(isset($article['Page']) && !empty($article['Page'])) {
					foreach($article['Page'] AS $page) {
						$response['records'][] = array('Page' => $page);
					}
				}
			}
		} else {
			$pages = $this->Page->find('all', array(
				'conditions' => array(
					'Page.filename like' => '%Volume 01 Page 042.jpg%'
				),
				'contain' => false
			));
			
			die(debug($this->params['data']));
			die(debug($pages));
			if($pages) {
				$response['records'] = $page;
			}
		}
		
		$response['success'] = empty($response['errors']);
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
		
		if($this->params['data']) {
			foreach($this->params['data'] AS $data) {
				if(isset($data['article_id']) && $data['article_id'] > 0 && isset($data['page_id']) && $data['page_id'] > 0){
					$pages = $this->ArticlesPage->find('all', array(
						'conditions' => array(
							'article_id' => $data['article_id'],
							'page_id' => $data['page_id']
						)
					));
					
					if($pages) {
						foreach($pages AS $page) {
							if($this->ArticlesPage->delete($page['ArticlesPage']['id'])) {
								$response['records']['ArticlesPage'] = $page['ArticlesPage']['id'];
							} else {
								$errors[] = $this->Model->validationErrors;
								$errors[] = $this->Model->invalidFields();
							}
						}
					}
				}
			}
		}
		
		$response['success'] = empty($response['errors']);
		return (json_encode($response));
	}
	
}
