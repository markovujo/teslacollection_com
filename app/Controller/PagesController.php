<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Before filter
 * 
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->allow('*');
	}

/**
 * Displays a view
 *
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}

		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}

/**
 * About page
 * 
 * @return void
 */
	public function about() {
		$this->set('title_for_layout', 'About');
	}

/**
 * Gallery page
 * 
 * @return void
 */
	public function gallery() {
		$this->set('title_for_layout', 'Image Gallery');
		$images = $this->_getImages();
		$this->set('images', $images);
	}

/**
 * Directors page
 * 
 * @return void
 */
	public function directors() {
		$this->set('title_for_layout', 'Directors');
	}

/**
 * Contact page
 * 
 * @return void
 */
	public function contact() {
		$this->set('title_for_layout', 'Contact');
	}

/**
 * Get Images
 * 
 * @return array
 */
	protected function _getImages() {
		$images = array();

		$imageGlobPath = WWW_ROOT . '/images/gallery/*.jpg';
		foreach (glob($imageGlobPath) as $filename) {
			$images[] = array('filename' => basename($filename));
		}

		//die(debug($images));
		return $images;
	}
}
