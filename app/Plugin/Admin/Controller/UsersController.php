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
	
	/*
	public function initDB() {
	    $group = $this->User->Group;
	    //Allow admins to everything
	    $group->id = 1;
	    $this->Acl->allow($group, 'controllers');
	
	    
	    //allow managers to posts and widgets
	    $group->id = 2;
	    $this->Acl->deny($group, 'controllers');
	    $this->Acl->allow($group, 'controllers/Articles');
	    $this->Acl->allow($group, 'controllers/Authors');
	    $this->Acl->allow($group, 'controllers/Pages');
	    $this->Acl->allow($group, 'controllers/Publications');
	    $this->Acl->allow($group, 'controllers/Subjects');
	    $this->Acl->allow($group, 'controllers/Users');
	
	    //allow users to only add and edit on posts and widgets
	    //$group->id = 3;
	    //$this->Acl->deny($group, 'controllers');
	    //$this->Acl->allow($group, 'controllers/Posts/add');
	    //$this->Acl->allow($group, 'controllers/Posts/edit');
	    //$this->Acl->allow($group, 'controllers/Widgets/add');
	    //$this->Acl->allow($group, 'controllers/Widgets/edit');
	    
	    //we add an exit to avoid an ugly "missing views" error message
	    echo "all done";
	    exit;
	}
	*/
	
	/*
	public function index()
	{
		$this->layout = 'admin'; 
	}
	*/
}
