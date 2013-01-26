<?php
App::uses('AdminAppController', 'Admin.Controller');
/**
 * Publications Controller
 *
 */
class PublicationsController extends AdminAppController {

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
