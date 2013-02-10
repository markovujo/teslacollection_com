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
	
	function initDB() {
        $group = & $this->User->Group;
        //Allow Striker to everything
        $group->id = 1;
        $this->Acl->allow($group, 'controllers');
 
        /* Allow midfielder add/edit/view scores and edit/view users.
         * but they can't add users or group
         */
 
        $group->id = 2;
        $this->Acl->deny($group, 'controllers');
        $this->Acl->allow($group, 'controllers/Scores/index');
        $this->Acl->allow($group, 'controllers/Users/index');
        $this->Acl->allow($group, 'controllers/Scores/add');
        $this->Acl->allow($group, 'controllers/Scores/edit');
        $this->Acl->allow($group, 'controllers/Scores/view');
        $this->Acl->allow($group, 'controllers/Users/edit');
        $this->Acl->allow($group, 'controllers/Users/view');
        $this->Acl->allow($group, 'controllers/Users/logout');
 
        /*
         * Allow defender to view score and view users only
         */
        $group->id = 3;
        $this->Acl->deny($group, 'controllers');
        $this->Acl->allow($group, 'controllers/Scores/index');
        $this->Acl->allow($group, 'controllers/Users/index');
        $this->Acl->allow($group, 'controllers/Scores/view');
        $this->Acl->allow($group, 'controllers/Users/view');
        $this->Acl->allow($group, 'controllers/Users/logout');
    }
}
