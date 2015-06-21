<?php 

App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {

	public $belongsTo = array(
		'Group'
	);

	public $actsAs = array(
		'Acl' => array('type' => 'requester')
	);

/**
 * Before save logic
 * 
 * @param array $options - Save options
 * @return bool
 */
	public function beforeSave($options = array()) {
		$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		return true;
	}

/**
 * Parent node function used for ACL functionality
 * 
 * @return mixed
 */
	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}

/**
 * Bind node logic
 * 
 * @param array $user - User record
 * @return array
 */
	public function bindNode(array $user) {
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}
}