<?php
/**
 * Publications Controller
 */

App::uses('AppController', 'Controller');

/**
 * Publications Controller
 *
 */
class PublicationsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Publications';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'Publication'
	);
}
