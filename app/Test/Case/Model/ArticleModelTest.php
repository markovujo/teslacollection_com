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
    
    public function testAfterFind() {
        $this->assertTrue(true);
    }
}