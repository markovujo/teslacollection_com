<?php
/**
 * Users Controller
 */

App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Users Controller
 *
 */
class UsersController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Users';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'User'
	);

/**
 * Login
 * 
 * @return void
 */
	public function login() {
		if ($this->Session->read('Auth.User')) {
			$this->set('user_info', $this->Session->read('Auth.User'));
		}

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect('/admin/');
			} else {
				$this->Session->setFlash('Your username or password was incorrect.');
			}
		}
	}

/**
 * Logout
 * 
 * @return void
 */
	public function logout() {
		$this->Session->setFlash('Good-Bye');
		$this->redirect($this->Auth->logout());
	}
}
