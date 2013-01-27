<?php

class AdminAppController extends AppController 
{	
	var $components = array('RequestHandler');
	
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
						$errors[] = $this->ModelName->invalidFields();
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
		
		/*
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
						$errors[] = $this->ModelName->invalidFields();
					}
				}
			}
		}
		*/
		
		return (json_encode($response));
	}
}

