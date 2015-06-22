<?php
/**
 * Authors Controller
 */

App::uses('AppController', 'Controller');

/**
 * Authors Controller
 *
 */
class AuthorsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Authors';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'Author'
	);

/**
 * Before filter logic
 * 
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
}
