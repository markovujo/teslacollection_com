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
	var $components = array('RequestHandler');
		
	public function getAll($params = NULL)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$model = substr($this->name, 0, -1);
		$conditions = array();
		
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
			App::uses('Sanitize', 'Utility');
			$query = Sanitize::escape($this->params->query['query']);
			$conditions['or'][] = array($model . '.name LIKE' => "%$query%");
			$conditions['or'][] = array($model . '.name' => $query);
			
		} else {
			$page = null;
		}
		
		$records = $this->{$model}->find('all', array(
			'conditions' => $conditions,
			'contain' => false,
			'limit' => $limit, 
			'offset' => $offset
		));
		
		$results = array(
			'totalCount' => count($records),
			'records' => $records
		);
		
		return (json_encode($results));
	}
}
