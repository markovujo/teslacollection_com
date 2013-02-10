<?php
App::uses('AdminAppController', 'Admin.Controller');
/**
 * Subjects Controller
 *
 */
class SubjectsController extends AdminAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	//public $scaffold;
	var $uses = array('Subject');
	
	public function __construct($id = false, $table = NULL, $ds = NULL)
	{
		$this->Model = $this->Subject;
		parent::__construct($id, $table, $ds);
	}
	
	public function index()
	{
		$this->layout = 'admin';
	}
}
