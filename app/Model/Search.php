<?php 
class Search extends AppModel 
{
	public $useTable = false;
	
	public function searchByQuery($query) {
		die(debug($query));

		App::import('Vendor', 'Client', array('file' => 'solarium-3.2.0'.DS.'library'.DS.'Solarium'.DS.'Client.php'));
	}
}
?>