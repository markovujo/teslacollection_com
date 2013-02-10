<?php

class AdminAppController extends AppController 
{	
	/*
	public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),
        'Session',
        'RequestHandler'
    );
    */
    
    /*
    public function beforeFilter() 
    {
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'plugin' => null);
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'plugin' => null);
        $this->Auth->loginRedirect = array('controller' => 'articles', 'action' => 'index', 'plugin' => null);
    }
    */
	
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
}

