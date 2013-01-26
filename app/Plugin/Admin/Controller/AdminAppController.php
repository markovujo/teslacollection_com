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
		
		die(get_object_vars($_REQUEST['records']));
		if(!empty($_REQUEST['records'])) {
			foreach($_REQUEST['records'] AS $record) {
				die(debug($record));
			}
		}
		
		return (json_encode($response));
	}
}

