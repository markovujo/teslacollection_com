<?php
App::uses('AdminAppController', 'Admin.Controller');
/**
 * Authors Controller
 *
 */
class AuthorsController extends AdminAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	//public $scaffold;
	
	public function index()
	{
		$this->layout = 'admin';
	}
}
