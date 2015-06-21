<?php 
class Group extends AppModel {

	public $actsAs = array('Acl' => array('type' => 'requester'));

	public $hasMany = array(
		'User'
	);

/**
 * Parent node function used for ACL functionality
 * 
 * @return mixed
 */
	public function parentNode() {
		return null;
	}
}