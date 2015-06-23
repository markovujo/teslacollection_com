<?php
/**
 * AdminAppController Controller
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

class AdminAppController extends AppController {

/**
 * View layout
 * 
 * @var string 
 */
	public $layout = 'admin';

/**
 * Before filter logic
 * 
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->deny('*');
	}

/**
 * isAuthorized logic
 * 
 * @param type $user - User record
 * @return bool 
 */
	public function isAuthorized($user = null) {
		if (isset($user['group_id']) && $user['group_id'] == 1) {
			return true;
		} else {
			return false;
		}
	}

/**
 * Set up response
 * 
 * @return void
 */
	private function __setUpResponse() {
		return array(
			'success' => true,
			'errors' => array(),
			'records' => array(
				$this->modelClass => array()
			)
		);
	}

/**
 * Get association key
 * 
 * @param string $type - Association type
 * @return string
 */
	private function __getAssociationKey($type) {
		return strtolower($type) . '_id';
	}

/**
 * Get association model
 * 
 * @param string $type - Association type
 * @return Model
 */
	private function __getAssociationModel($type) {
		return ClassRegistry::init('Articles' . $type);
	}

/**
 * Save all action
 * 
 * @return void
 */
	public function saveAll() {
		$response = $this->__setUpResponse();

		$this->Model = ClassRegistry::init($this->modelClass);
		if (!empty($this->params->data)) {
			foreach ($this->params->data as $data) {
				if (isset($data['id']) && $data['id'] > 0) {
					if ($this->Model->save($data)) {
						$response['records'][$this->Model->alias] = $data;
					} else {
						$errors[] = $this->Model->validationErrors;
						$errors[] = $this->Model->invalidFields();
					}
				} else {
					$data['status'] = isset($data['status']) ? $data['status'] : 'active';
					$this->Model->create();
					if ($this->Model->save($data)) {
						$response['records'][$this->Model->alias] = $data;
					} else {
						$errors[] = $this->Model->validationErrors;
						$errors[] = $this->Model->invalidFields();
					}
				}
			}
		}

		$this->_setUpJsonResponse();
		return (json_encode($response));
	}

/**
 * Delete action
 * 
 * @return void
 */
	public function delete() {
		$response = $this->__setUpResponse();

		$this->Model = ClassRegistry::init($this->modelClass);
		if ($this->params['data']) {
			foreach ($this->params['data'] as $id) {
				if ($this->Model->delete($id)) {
					$response['records'][$this->Model->alias] = $id;
				} else {
					$errors[] = $this->Model->validationErrors;
					$errors[] = $this->Model->invalidFields();
				}
			}
		}

		$this->_setUpJsonResponse();
		return (json_encode($response));
	}

/**
 * Add Associations action
 * 
 * @param string $type - The type of association
 * @return void
 */
	public function addAssociations($type = 'Page') {
		$response = $this->__setUpResponse();

		$associationKey = $this->__getAssociationKey($type);
		$AssociationModel = $this->__getAssociationModel($type);

		//die(debug($this->params['data']));
		if ($this->params['data']) {
			foreach ($this->params['data'] as $data) {
				if (isset($data['article_id']) && $data['article_id'] > 0 && isset($data['association_id']) && $data['association_id'] > 0) {
					$createData = array(
						'article_id' => $data['article_id'],
						$associationKey => $data['association_id']
					);
					$result = $AssociationModel->find('first', array('conditions' => $createData));

					if (empty($result)) {
						$AssociationModel->create();
						if ($AssociationModel->save($createData)) {
							if (!isset($response['records'][$type])) {
								$response['records'][$type] = array();
							}

							$response['records'][$type][] = $result[$AssociationModel->name]['id'];
						}
					}
				}
			}
		}

		$response['success'] = empty($response['errors']);
		$this->_setUpJsonResponse();
		return (json_encode($response));
	}

/**
 * Get model associations action
 * 
 * @param string $type - Type of associtation (Example: Page)
 * @param int $articleId - Article.id
 * @return void
 */
	public function getAssociations($type, $articleId) {
		$response = $this->__setUpResponse();

		$this->Model = ClassRegistry::init($this->modelClass);
		if (!is_null($articleId) && $articleId > 0) {
			$article = $this->Model->find('first', array(
				'conditions' => array(
					'Article.id' => $articleId
				),
				'contain' => array($type)
			));

			//die(debug($article));
			if ($article) {
				if (isset($article[$type]) && !empty($article[$type])) {
					foreach ($article[$type] as $association) {
						$response['records'][] = array($type => $association);
					}
				}
			}
		}

		$response['success'] = empty($response['errors']);
		$this->_setUpJsonResponse();
		return (json_encode($response));
	}

/**
 * Delete associations action
 * 
 * @param string $type - Association type
 * @return void
 */
	public function deleteAssociations($type = 'Page') {
		$response = $this->__setUpResponse();

		$associationKey = $this->__getAssociationKey($type);
		$AssociationModel = $this->__getAssociationModel($type);

		if ($this->params['data']) {
			foreach ($this->params['data'] as $data) {
				if (isset($data['article_id']) && $data['article_id'] > 0 && isset($data['association_id']) && $data['association_id'] > 0) {
					$results = $AssociationModel->find('all', array(
						'conditions' => array(
							'article_id' => $data['article_id'],
							$associationKey => $data['association_id']
						)
					));

					if ($results) {
						foreach ($results as $result) {
							if ($AssociationModel->delete($result[$AssociationModel->name]['id'])) {
								if (!isset($response['records'][$type])) {
									$response['records'][$type] = array();
								}

								$response['records'][$type][] = $result[$AssociationModel->name][$associationKey];
							} else {
								$errors[] = $AssociationModel->validationErrors;
								$errors[] = $AssociationModel->invalidFields();
							}
						}
					}
				}
			}
		}

		$response['success'] = empty($response['errors']);
		$this->_setUpJsonResponse();
		return (json_encode($response));
	}
}

