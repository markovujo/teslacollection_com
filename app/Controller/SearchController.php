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
		'Article',
		'Author',
		'Publication',
		'Subject'
	);
	
	public function index()
	{
		
	}
	
	public function term()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
	
		$search_results = array();
	
		return (json_encode($search_results));
	}
}
  
