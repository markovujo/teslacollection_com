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
			'records' => array()
		);
		
		if(!empty($this->params->data)) {
			foreach($this->params->data AS $data) {
				$response['records'][] = $data;
			}
		}
		
		return (json_encode($response));
	}
}

