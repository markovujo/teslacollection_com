<?php
/**
 * Articles Controller
 */

App::uses('AppController', 'Controller');

/**
 * Pages Controller
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

	public function index()
	{
		
	}
	
	public function view($id)
	{
		$article_page = $this->Page->find('first', array(
			'conditions' => array(
				'Page.id' => (int) $id
			)
		));
		
		if($article_page) {
			$this->viewClass = 'Media';
			$path = str_replace('/var/www/html/teslacollection_com/app/', '', $article_page['Page']['full_path']);
			$path = substr($path, 0, strrpos($path, '/')) . DS;
			$name = str_replace('.jpg', '', $article_page['Page']['filename']);
			
	        $params = array(
	            'id'        => $article_page['Page']['filename'],
	            'name'      => $name,
	            'download'  => true,
	            'extension' => 'jpg',
	            'path'      => $path
	        );
	        $this->set($params);
		}
	}
	
	public function view_thumbnail($id)
	{
		$article_page = $this->Page->find('first', array(
			'conditions' => array(
				'Page.id' => (int) $id
			)
		));
		
		if($article_page) {
			$this->viewClass = 'Media';
			$path = str_replace('/var/www/html/teslacollection_com/app/', '', $article_page['Page']['full_path']);
			$path = substr($path, 0, strrpos($path, '/')) . DS;
			$name = str_replace('.jpg', '', $article_page['Page']['filename']);
		
	        $params = array(
	            'id'        => $article_page['Page']['filename'],
	            'name'      => $name,
	            'download'  => false,
	            'extension' => 'jpg',
	            'path'      => $path
	        );
	        $this->set($params);
		}
	}
}
  
