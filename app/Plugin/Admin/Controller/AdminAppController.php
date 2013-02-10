<?php

class AdminAppController extends AppController 
{	
	public function saveAll() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$response = array(
			'success' => true,
			'errors' => array(),
			'records' => array(
				$this->Model->alias => array()
			)
		);
		
		if(!empty($this->params->data)) {
			foreach($this->params->data AS $data) {
				if(isset($data['id']) && $data['id'] > 0) {
					if($this->Model->save($data)) { 
						$response['records'][$this->Model->alias] = $data;
					} else {
						$errors[] = $this->Model->validationErrors;
						$errors[] = $this->ModelName->invalidFields();
					}
				} else {
					$this->Model->create(); 
					if($this->Model->save($data)) { 
						$response['records'][$this->Model->alias] = $data;
					} else {
						$errors[] = $this->Model->validationErrors;
						$errors[] = $this->Model->invalidFields();
					}
				}
			}
		}
		
		return (json_encode($response));
	}
	
	public function delete() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$response = array(
			'success' => true,
			'errors' => array(),
			'records' => array(
				$this->Model->alias => array()
			)
		);
		
		if($this->params['data']) {
			foreach($this->params['data'] AS $id) {
				if($this->Model->delete($id)) {
					$response['records'][$this->Model->alias] = $id;
				} else {
					$errors[] = $this->Model->validationErrors;
					$errors[] = $this->Model->invalidFields();
				}
			}
		}
		
		return (json_encode($response));
	}
	
	public function addAssociations($type = 'Page') {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$response = array(
			'success' => true,
			'errors' => array(),
			'records' => array()
		);
		
		$association_key = strtolower($type) . '_id';
		$association_model_name = 'Articles' . $type;
		$this->loadModel($association_model_name);
		$this->AssociationModel = $this->{$association_model_name};
		
		//die(debug($this->params['data']));
		if($this->params['data']) {
			foreach($this->params['data'] AS $data) {
				if(isset($data['article_id']) && $data['article_id'] > 0 && isset($data['association_id']) && $data['association_id'] > 0){
					
					$create_data = array(
						'article_id' => $data['article_id'],
						$association_key => $data['association_id']
					);
					$result = $this->AssociationModel->find('first', array(
						'conditions' => $create_data
					));
					
					if(empty($result)) {
						$this->AssociationModel->create();
						if($this->AssociationModel->save($create_data)) {
							if(!isset($response['records'][$type])) {
								$response['records'][$type] = array();
							}
							
							$response['records'][$type][] = $result[$this->AssociationModel->name]['id'];
						}
					}
				}
			}
		}
		
		$response['success'] = empty($response['errors']);
		return (json_encode($response));
	}
	
	public function getAssociations($type = 'Page', $article_id) {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$response = array(
			'success' => true,
			'errors' => array(),
			'records' => array()
		);
		
		if(!is_null($article_id) && $article_id > 0) {
			$article = $this->Model->find('first', array(
				'conditions' => array(
					'Article.id' => $article_id
				),
		        'contain' => array($type)
			));

			//die(debug($article));
			if($article) {
				if(isset($article[$type]) && !empty($article[$type])) {
					foreach($article[$type] AS $association) {
						$response['records'][] = array($type => $association);
					}
				}
			}
		}
		
		$response['success'] = empty($response['errors']);
		return (json_encode($response));
	}
	
	public function deleteAssociations($type = 'Page') {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');
		
		$response = array(
			'success' => true,
			'errors' => array(),
			'records' => array()
		);
		
		$association_key = strtolower($type) . '_id';
		$association_model_name = 'Articles' . $type;
		$this->loadModel($association_model_name);
		$this->AssociationModel = $this->{$association_model_name};
		
		if($this->params['data']) {
			foreach($this->params['data'] AS $data) {
				if(isset($data['article_id']) && $data['article_id'] > 0 && isset($data['association_id']) && $data['association_id'] > 0){
					$results = $this->AssociationModel->find('all', array(
						'conditions' => array(
							'article_id' => $data['article_id'],
							$association_key => $data['association_id']
						)
					));
					
					if($results) {
						foreach($results AS $result) {
							if($this->AssociationModel->delete($result[$this->AssociationModel->name]['id'])) {
								if(!isset($response['records'][$type])) {
									$response['records'][$type] = array();
								}
								
								$response['records'][$type][] = $result[$this->AssociationModel->name][$association_key];
							} else {
								$errors[] = $this->AssociationModel->validationErrors;
								$errors[] = $this->AssociationModel->invalidFields();
							}
						}
					}
				}
			}
		}
		
		$response['success'] = empty($response['errors']);
		return (json_encode($response));
	}
}

