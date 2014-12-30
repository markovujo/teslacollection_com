<?php
App::uses('AdminAppController', 'Admin.Controller');
/**
 * Pages Controller
 *
 */
class PagesController extends AdminAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	//public $scaffold;
	var $uses = array('Page', 'ArticlesPage');
	
	public function __construct($id = false, $table = NULL, $ds = NULL)
	{
		$this->Model = $this->Page;
		parent::__construct($id, $table, $ds);
	}
	
	public function index()
	{
		$this->layout = 'admin';
	}

/**
 * 
 * Process Page upload
 */
	public function upload() {
		$errors = array();
		$page = array();
		
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$this->log($this->request->params['form'], 'requesting');
		
		if ($this->request->is('post')) {
			$article_id = $this->request['data']['article-id'];
			$article_text = $this->request['data']['article-text'];
			
			if(!empty($this->request->params['form'])) {
				$result = $this->_processUpload($this->request->params['form']);
				
				if($result['success']) {
					$this->Page->create();
					$page = $this->Page->save(array(
						'filename' => $result['filename'],
						'full_path' => $result['full_path'],
						'text' => $article_text,
						'status' => 'active'
					));
					
					if(!empty($page)) {
						$this->ArticlesPage->create();
						$this->ArticlesPage->save(array(
							'article_id' => $article_id,
							'page_id' => $page['Page']['id']
						));
					} else {
						$errors[] = 'Failed to save page!';
					}
				} else {
					$errors = array_merge($result['errors'], $errors);
				}
			} else {
				$errors[] = 'POST form param not found!';
			}
		} else {
			$errors[] = 'POST operation not used!';
		}
		
		return (json_encode(array(
			'success' => empty($errors),
			'errors' => $errors,
			'page' => $page
		)));
	}
	
/**
 * Process the Upload
 * @param array $check
 * @return boolean
 */
	protected function _processUpload($check = array()) {
		$errors = array();
		
		if (!empty($check['filename']['tmp_name'])) {
			if (!is_uploaded_file($check['filename']['tmp_name'])) {
				$errors[] = 'File not uploaded!';
			}
	
			//$filename = WWW_ROOT . $this->uploadDir . DS . Inflector::slug(pathinfo($check['filename']['name'], PATHINFO_FILENAME)).'.'.pathinfo($check['filename']['name'], PATHINFO_EXTENSION);
			$filename = $check['filename']['name'];
			$upload_path = APP . 'files/tesla_collection/Volume 24/';
			
			if (!file_exists($upload_path)) {
			    mkdir($upload_path, 0744, true);
			}
			
			$full_path = $upload_path . $filename;
			
			//$this->log($filename, 'processUpload');
			//$this->log($full_path, 'processUpload');
			
			if(empty($errors)) {
				$count = $this->Page->find('count', array(
					'conditions' => array(
						'Page.filename' => $filename
					),
					'contain' => false
				));
				
				if($count == 0) {
					if (!move_uploaded_file($check['filename']['tmp_name'], $full_path)) {
						$errors[] = 'Failed trying to move file from tmp folder.';
					}
				} else {
					$errors[] = 'Filename (' . $filename . ') already exists!';
				}
			}
		} else {
			$errors[] = 'Tmp name not set!';
		}
	
		return array(
			'success' => empty($errors),
			'errors' => $errors,
			'full_path' => $full_path,
			'filename' => $filename
		);
	}
}
