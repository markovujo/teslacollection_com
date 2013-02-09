<?php
App::uses('AdminAppController', 'Admin.Controller');
/**
 * Pages Controller
 *
 */
class PagesController extends AdminAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	//public $scaffold;
	var $uses = array('Page');
	
	public function __construct($id = false, $table = NULL, $ds = NULL)
	{
		$this->Model = $this->Page;
		parent::__construct($id, $table, $ds);
	}
	
	public function index()
	{
		$this->layout = 'admin';
	}
}
