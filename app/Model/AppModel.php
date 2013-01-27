<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	public function beforeFind($queryData = array())
	{
		$queryData['conditions'][$this->name . '.status !='] = 'deleted';
		
		return $queryData;
	}
	
	function delete($id = null, $cascade = true)
	{
		if (!empty($id)) {
            $this->id = $id;
        }
        
        if($this->exists()) {
	        $id = $this->id;
			$updates = array();
			if($this->hasField('deleted')) {
				if(!$this->field('deleted')){
					$set_value = null;
					switch ($this->getColumnType('deleted')){
						case 'datetime':
							$set_value = date("Y-m-d H:i:s");
							break;
						case 'boolean':
							$set_value = 1;
							break;
						case 'integer':
							$set_value = time();
							break;
					}
					if(!empty($set_value)) {
						$updates['deleted'] = $set_value;
					}
				}
			}

			if($this->hasField('status')) {
				$updates['status'] = 'deleted';
			}
			if(!empty($updates)) {
				if ($this->beforeDelete($cascade)) {
					/*
					$filters = $this->Behaviors->trigger($this, 'beforeDelete', array($cascade), array(
						'break' => true, 
						'breakOn' => false
					));
					
					if (!$filters || !$this->exists()) {
						return false;
					}
					*/

					// Soft Delete
					$update_fields = array_keys($updates);
					$this->set($updates);
					if($this->save(null, false, $update_fields)) {
						//$this->Behaviors->trigger($this, 'afterDelete');
						//$this->afterDelete();
						$this->id = false;
						return true;
					}
				}
			} else {
				return parent::delete($id, $cascade);
			}
        }
        
		return false;
	}
}
