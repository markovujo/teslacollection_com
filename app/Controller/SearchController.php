<?php
/**
 * Search Controller
 */

App::uses('AppController', 'Controller');

/**
 * Search Controller
 *
 */
class SearchController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Search';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'Search'
	);
	
	public function index()
	{
		if(isset($this->request->query['q'])) {
			$query = $this->request->query['q'];
			
			$this->Search->searchByQuery($query);
		} else {
			return $this->redirect(
					array('controller' => 'articles', 'action' => 'index')
			);
		}
	}
	
	public function autocomplete()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
	
		$search_results = array();
	
		return (json_encode($search_results));
	}
}
  
