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
			'errors' => array()
		);
		
		die(debug($this->params));
		if(!empty($this->params['data']['records'])) {
			foreach($this->params['data']['records'] AS $data) {
				die($data);
			}
		}
		
		return (json_encode($response));
	}
}

