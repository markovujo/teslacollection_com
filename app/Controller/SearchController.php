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
	public $uses = array();

	public function index()
	{
		$this->layout = 'responsive';
		
		$search_results = array();
		
		return (json_encode($search_results));
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
  
