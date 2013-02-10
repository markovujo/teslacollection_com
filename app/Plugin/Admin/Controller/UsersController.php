<?php
App::uses('AdminAppController', 'Admin.Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AdminAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
	
	var $uses = array('User');
	
	public function __construct($id = false, $table = NULL, $ds = NULL)
	{
		$this->Model = $this->User;
		parent::__construct($id, $table, $ds);
	}
	
	public function beforeFilter() {
	    parent::beforeFilter();
	    
	    //$this->Auth->allow('*');
	}
}
