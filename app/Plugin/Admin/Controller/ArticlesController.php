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
	
	public function index()
	{
		$Articles = $this->Article->find('all');
		
		$this->layout = 'admin';
		$this->set('Articles', $Articles);
	}
}
