<?php
App::uses('Article', 'Model');

class ArticleTestCase extends CakeTestCase {
    var $fixtures = array(
        'app.article',
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
        $publication_name = 'new_york_times';
        $author_name = 'marko';
        $article_name = 'test_article';
        
        $this->Publication->create();
        $publication = $this->Publication->save(array(
            'name' => $publication_name,
            'url' => $publication_name,
            'status' => 'active'
        ));
        
        $this->Author->create();
        $author = $this->Author->save(array(
            'name' => $author_name,
            'url' => $author_name,
            'status' => 'active'
        ));
        
        $this->Article->create();
        $article = $this->Article->save(array(
            'title' => $article_name,
            'publication_id' => $publication['Publication']['id'],
            'author_id' => $author['Author']['id'],
            'year' => $year,
            'url' => $article_name,
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
        
        $full_url = "tesla_articles/" . $year . '/' . $publication_name . '/' . $author_name . '/' . $article_name;
        $this->assertEqual($article['Article']['full_url'], $full_url);
    }
}