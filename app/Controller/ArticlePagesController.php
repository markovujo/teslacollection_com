<?php
/**
 * ArticlePages Controller
 */

App::uses('AppController', 'Controller');

/**
 * ArticlePages Controller
 *
 */
class ArticlePagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'ArticlePages';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'Page',
		'Article'
	);

/**
 * View 
 * 
 * @param int $id - ArticlePage.id
 * @return void
 */
	public function view($id) {
		return $this->__viewPage($id, $download = true);
	}

/**
 * View thumbnail
 * 
 * @param int $id - Page.id
 * @return void
 */
	public function view_thumbnail($id) {
		return $this->__viewPage($id, $download = false);
	}

/**
 * View Page
 * 
 * @param type $id - Page.id
 * @param bool $download - Boolean whether page is downloaded or not
 * @return void
 */
	private function __viewPage($id, $download = false) {
		$articlePage = $this->Page->find('first', array(
			'conditions' => array(
				'Page.id' => (int)$id
			)
		));

		if ($articlePage) {
			$this->viewClass = 'Media';
			$path = str_replace('/var/www/html/teslacollection_com/app/', '', $articlePage['Page']['full_path']);
			$path = substr($path, 0, strrpos($path, '/')) . DS;
			$name = str_replace('.jpg', '', $articlePage['Page']['filename']);

			$params = array(
				'id' => $articlePage['Page']['filename'],
				'name' => $name,
				'download' => $download,
				'extension' => 'jpg',
				'path' => $path
			);

			//die(debug($articlePage['Page']['filename']));
			$this->set($params);
		}
	}
}
