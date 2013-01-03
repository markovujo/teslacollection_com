<?php
/**
 * Articles Controller
 */

App::uses('AppController', 'Controller');

/**
 * ArticlePage Controller
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
		'ArticlePage',
		'Article'
	);

	public function index()
	{
		
	}
	
	public function view($id)
	{
		$article_page = $this->ArticlePage->find('first', array(
			'conditions' => array(
				'ArticlePage.id' => (int) $id
			)
		));
		
		if($article_page) {
			$this->viewClass = 'Media';
			$path = str_replace('/var/www/html/teslacollection_com/app/', '', $article_page['ArticlePage']['full_path']);
			$path = substr($path, 0, strrpos($path, '/')) . DS;
			$name = str_replace('.jpg', '', $article_page['ArticlePage']['filename']);
			
	        $params = array(
	            'id'        => $article_page['ArticlePage']['filename'],
	            'name'      => $name,
	            'download'  => true,
	            'extension' => 'jpg',
	            'path'      => $path
	        );
	        $this->set($params);
		}
	}
}
  