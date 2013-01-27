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
	var $uses = array('Publication');
	
	public function __construct($id = false, $table = NULL, $ds = NULL)
	{
		$this->Model = $this->Publication;
		parent::__construct($id, $table, $ds);
	}
	
	public function index()
	{
		$this->layout = 'admin';
	}
}
