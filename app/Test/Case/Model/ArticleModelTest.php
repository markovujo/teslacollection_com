<?php
App::uses('Article', 'Model');

class ArticleTestCase extends CakeTestCase {

	public $fixtures = array(
		'app.article',
		'app.articles_pages',
		'app.articles_subjects',
		'app.author',
		'app.group',
		'app.page',
		'app.publication',
		'app.subject',
		'app.user',
	);

	public function setUp() {
		parent::setUp();
		$this->Article = ClassRegistry::init('Article');
		$this->Publication = ClassRegistry::init('Publication');
		$this->Author = ClassRegistry::init('Author');
	}

	public function testAfterFind() {
		$year = 2000;
		$publicationName = 'new_york_times';
		$authorName = 'marko';
		$articleName = 'test_article';

		$this->Publication->create();
		$publication = $this->Publication->save(array(
			'name' => $publicationName,
			'url' => $publicationName,
			'status' => 'active'
		));

		$this->Author->create();
		$author = $this->Author->save(array(
			'name' => $authorName,
			'url' => $authorName,
			'status' => 'active'
		));

		$this->Article->create();
		$article = $this->Article->save(array(
			'title' => $articleName,
			'publication_id' => $publication['Publication']['id'],
			'author_id' => $author['Author']['id'],
			'year' => $year,
			'url' => $articleName,
			'status' => 'active'
		));

		$article = $this->Article->find('first', array(
			'conditions' => array(
				'Article.id' => $article['Article']['id']
			),
			'contain' => array(
				'Publication',
				'Author'
			)
		));
		//die(print_r($article));

		$fullUrl = "tesla_articles/" . $year . '/' . $publicationName . '/' . $authorName . '/' . $articleName;
		$this->assertEqual($article['Article']['full_url'], $fullUrl);
	}

	public function testSearch() {
		$params = array();
		$result = $this->Article->search($params);
		$this->assertEmpty($result['articles']);
	}
}