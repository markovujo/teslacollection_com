<?php
App::uses('AdminAppController', 'Admin.Controller');

/**
 * Articles Controller
 *
 */
class ArticlesController extends AdminAppController {

/**
 * Index action
 * 
 * @return void
 */
	public function index() {
		$this->set('title_for_layout', 'Admin Panel');
	}
}
