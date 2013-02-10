<?php
/**
 * Subjectss Controller
 */

App::uses('AppController', 'Controller');

/**
 * Subjects Controller
 *
 */
class SubjectsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Subjects';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'Subject'
	);
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('*');
	}

	public function index()
	{
		
	}
}
  
