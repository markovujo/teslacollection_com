<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

/**
 * Components
 * 
 * @var array 
 */
	public $components = array(
		'Acl',
		'Auth' => array(
			'loginRedirect' => array('plugin' => null, 'controller' => 'articles', 'action' => 'index'),
			'logoutRedirect' => array('plugin' => null, 'controller' => 'users', 'action' => 'login'),
			'authError' => "Sorry, you're not allowed to do that.",
			'authorize' => array('Controller')
		),
		'Session',
		'RequestHandler'
	);

/**
 * Before filter
 * 
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}

/**
 * isAuthorized Logic for ACL
 * 
 * @param array $user - User record
 * @return bool
 */
	public function isAuthorized($user = null) {
		return true;
	}

/**
 * Set up json response
 * 
 * @return void
 */
	protected function _setUpJsonResponse() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
	}

/**
 * Get All
 * 
 * @param array $params - Params array
 * @return void
 */
	public function getAll($params = null) {
		$conditions = array();
		$searchField = null;

		$this->Model = ClassRegistry::init($this->modelClass);

		App::uses('Sanitize', 'Utility');
		$start = !empty($this->params->query['start']) ? (int)$this->params->query['start'] : null;
		$limit = !empty($this->params->query['limit']) ? (int)$this->params->query['limit'] : null;
		$page = !empty($this->params->query['page']) ? (int)$this->params->query['page'] : null;

		$offset = null;
		if (!empty($this->params->query['page'])) {
			$offset = ((int)$this->params->query['page'] - 1) * $limit;
		}

		if (!empty($this->params->query['query'])) {
			$modelSearchFields = array(
				'filename',
				'name'
			);

			if (!empty($modelSearchFields)) {
				foreach ($modelSearchFields as $modelSearchField) {
					if ($this->Model->hasField($modelSearchField)) {
						$searchField = $modelSearchField;
					}
				}
			}

			if (!is_null($searchField)) {
				$query = Sanitize::escape($this->params->query['query']);
				$conditions['or'][] = array($this->modelClass . '.' . $searchField . ' LIKE' => "%$query%");
				$conditions['or'][] = array($this->modelClass . '.' . $searchField => $query);
			}
		} else {
			$page = null;
		}

		if (!empty($this->params->query['filter'])) {
			foreach ($this->params->query['filter'] as $filter) {
				if (isset($filter['data']['comparison'])) {
					$value = Sanitize::escape($filter['data']['value']);
					$fieldName = $model . '.' . $filter['field'];
					switch($filter['data']['comparison']) {
						case 'lte':
							$conditions[$fieldName . ' <='] = $value;
							break;
						case 'gte':
							$conditions[$fieldName . ' >='] = $value;
							break;
						case 'lt':
							$conditions[$fieldName . ' <='] = $value;
							break;
						case 'gt':
							$conditions[$fieldName . ' >='] = $value;
							break;
						case 'eq':
							$conditions[$fieldName] = $value;
							break;
						default:
							$conditions[$fieldName] = $value;
							break;
					}
				}
			}
		}

		$order = array($this->Model->name . '.id');
		if (!is_null($searchField)) {
			$order = array($this->Model->name . '.' . $searchField);
		}

		//die(debug($conditions));
		$records = $this->Model->find('all', array(
			'conditions' => $conditions,
			'contain' => false,
			'limit' => $limit,
			'offset' => $offset,
			'order' => $order
		));

		$totalCount = $this->Model->find('count');

		$results = array(
			'totalCount' => $totalCount,
			'recordCount' => count($records),
			'records' => $records
		);

		$this->_setUpJsonResponse();
		return (json_encode($results));
	}
}
