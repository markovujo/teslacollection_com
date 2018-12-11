<?php
/**
 * Images Controller
 */

App::uses('AppController', 'Controller');

/**
 * Images Controller
 *
 */
class ImagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Images';

/**
 * Index 
 * 
 * @return void
 */
	public function index() {
		$this->set('layout_no_script', true);
	}

	public function search() {

	}
}
