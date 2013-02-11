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
class AppController extends Controller 
{	
	public $components = array(
        'Acl',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'articles', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'articles', 'action' => 'index'),
			'authError' => "Sorry, you're not allowed to do that.",
			'authorize' => array('Controller')
        ),
        'Session',
        'RequestHandler'
    );
    
    public function beforeFilter() 
    { 
       $this->Auth->allow('*');
    } 
        
    public function isAuthorized($user = null) 
    { 
    	return true; 
   	} 
		
	public function getAll($params = NULL)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$model = substr($this->name, 0, -1);
		$Model = $this->{$model};
		$conditions = array();
		$search_field = NULL;
			
		
		App::uses('Sanitize', 'Utility');
		
		if (!empty($this->params->query['start'])) {
			$start = (int) $this->params->query['start'];
		} else {
			$start = null;
		}
		
		if (!empty($this->params->query['limit'])) {
			$limit = (int) $this->params->query['limit'];
		} else {
			$limit = null;
		}
		
		if (!empty($this->params->query['page'])) {
			$page = (int) $this->params->query['page'];
		} else {
			$page = null;
		}
		
		if (!empty($this->params->query['page'])) {
			$offset = ((int) $this->params->query['page'] - 1) * $limit;
		} else {
			$offset = null;
		}
		
		if (!empty($this->params->query['query'])) {
			$model_search_fields = array(
				'filename',
				'name'
			);
			
			if(!empty($model_search_fields)) {
				foreach($model_search_fields AS $model_search_field) {
					if($Model->hasField($model_search_field)) {
						$search_field = $model_search_field;
					}
				}
			}
			
			if(!is_null($search_field)) {
				$query = Sanitize::escape($this->params->query['query']);
				$conditions['or'][] = array($model . '.' . $search_field . ' LIKE' => "%$query%");
				$conditions['or'][] = array($model . '.' . $search_field => $query);
			}
		} else {
			$page = null;
		}
		
		if (!empty($this->params->query['filter'])) {
			foreach($this->params->query['filter'] AS $filter) {
				if(isset($filter['data']['comparison'])) {
					$value = Sanitize::escape($filter['data']['value']);
					$field_name = $model . '.' . $filter['field'];
					switch($filter['data']['comparison']) {
						case 'lte':
							$conditions[$field_name . ' <='] = $value;
							break;
						case 'gte':
							$conditions[$field_name . ' >='] = $value;
							break;
						case 'lt':
							$conditions[$field_name . ' <='] = $value;
							break;
						case 'gt':
							$conditions[$field_name . ' >='] = $value;
							break;
						case 'eq':
							$conditions[$field_name] = $value;
							break;
						default:
							$conditions[$field_name] = $value;
							break;
					}
				}
			}
		}
		
		$order = array($this->Model->name . '.id');
		if(!is_null($search_field)) {
			$order = array($this->Model->name . '.' . $search_field);
		}
		
		//die(debug($conditions));
		$records = $Model->find('all', array(
			'conditions' => $conditions,
			'contain' => false,
			'limit' => $limit, 
			'offset' => $offset,
			'order' => $order
		));
		
		$totalCount = $Model->find('count');
		
		$results = array(
			'totalCount' => $totalCount,
			'recordCount' => count($records),
			'records' => $records
		);
		
		return (json_encode($results));
	}
}
