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
	var $uses = array('Article', 'ArticlesPage', 'ArticlesSubject', 'Page');
	
	public function __construct($id = false, $table = NULL, $ds = NULL)
	{
		$this->Model = $this->Article;
		parent::__construct($id, $table, $ds);
	}
	
	public function beforeFilter() {
	    parent::beforeFilter();
	
	    //$this->Auth->allow();
	}
	
	public function index()
	{
		$this->layout = 'admin';
	}
	
	public function addAssociations($type = 'Page') {
		
	}
	
	public function getAssociations($type = 'Page', $article_id) {
		
	}
	
	public function deleteAssociations($type = 'Page') {
		
	}
}
