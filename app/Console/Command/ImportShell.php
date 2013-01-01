<?php 
/**
 * Import Articles and Article Pages into the Database
 * @author MarkoVujovic
 * 
 * cake Import
 */
class ImportShell extends AppShell 
{
    public $uses = array(
    	'Author'
    	, 'Publication'
    	, 'Subject'
    	, 'Article'
    	, 'ArticlePage'
    );
	
	public function main() 
    {
        $this->out('IMPORTING ARTICLES AND PAGES!!');
        
       	$authors = array();
		$publications = array();
		$subjects = array();
		$article_mapping = array();
        
        $con = mysql_connect("localhost","root","");
		if (!$con) {
  			die('Could not connect: ' . mysql_error());
		}

		mysql_select_db("teslacollection", $con);
		
		#TRUNCATE TABLES FOR IMPORT
		$result = $this->Article->query("TRUNCATE TABLE articles");
		$result = $this->Article->query("TRUNCATE TABLE article_pages");
		$result = $this->Article->query("TRUNCATE TABLE publications");
		$result = $this->Article->query("TRUNCATE TABLE authors");
		$result = $this->Article->query("TRUNCATE TABLE subjects");
		$result = $this->Article->query("TRUNCATE TABLE articles_subjects");
		
		$result = mysql_query("select * from tmp_articles ORDER BY volume, page");
		
		while ($article = mysql_fetch_assoc($result)) {
			$author_name = trim($article['author']);
			$publication_name = trim($article['publication']);
			$subject_name = trim($article['subject']);
			 
			if(array_key_exists($author_name, $authors)) {
				$author_id = $authors[$author_name];
			} else {
				$this->Author->create();
				$this->Author->save(array(
					'name' => $author_name
				));
				
				$author_id = $this->Author->id;
				$authors[$author_name] = $author_id;
			}
			//die(debug($authors));
			
			if(array_key_exists($publication_name, $publications)) {
				$publication_id = $publications[$publication_name];
			} else {
				$this->Publication->create();
				$this->Publication->save(array(
					'name' => $publication_name
				));
				
				$publication_id = $this->Publication->id;
				$publications[$publication_name] = $publication_id;
			}
			//die(debug($publications));
			
			if(array_key_exists($subject_name, $subjects)) {
				$subject_id = $subjects[$subject_name];
			} else {
				$this->Subject->create();
				$this->Subject->save(array(
					'name' => $subject_name
				));
				
				$subject_id = $this->Subject->id;
				$subjects[$subject_name] = $subject_id;
			}
			//die(debug($subjects));
			
			$this->Article->saveAll(array(
			 	'Article' => array(
			    	'volume' => trim($article['volume']), 
			    	'page' => trim($article['page']),
					'title' => trim($article['title']),
					'date' => date('Y-m-d', strtotime(trim($article['date']))),
					'year' => date('Y', strtotime(trim($article['date']))),
					'range_text' => trim($article['range_text']),
					'status' => 'created',
					'publication_id' => $publication_id,
					'author_id' => $author_id,
				),
			    'Subject' => array(
			    	'Subject' => array(
						$subject_id
					)
				)
			));
			
			$this->out("\n\nArticle Id :: " . $this->Article->id . 
				' title : ' . $article['title'] . "\n" .
				' volume : ' . $article['volume'] . 
				' page : ' . $article['page']
			);
			$article_mapping[$article['id']] = $this->Article->id;
		}
		
		$result = mysql_query("select * from tmp_article_images");
		
		while ($article_page = mysql_fetch_assoc($result)) {
			$article = array(
				'id' => NULL,
				'volume' => NULL,
				'page' => NULL
			);
			
			if(isset($article_mapping[$article_page['article_id']])) {
				$article_id = $article_mapping[$article_page['article_id']];
				$article_result = $this->Article->find('first', array(
					'conditions' => array(
						'Article.id' => $article_id
					)
				));
				
				if($article_result) {
					$article = $article_result['Article'];
				}
			}
			
			$this->ArticlePage->create();
			$this->ArticlePage->save(array(
				'article_id' => $article_id,
				'filename' => trim($article_page['filename']),
				'full_path' => trim($article_page['full_path']),
				'text' => trim($article_page['text'])
			));
			
			$this->out('Article Id :: ' . $this->ArticlePage->id . 
				' Article Page :: ' . $article_page['filename'] .
				' volume : ' . $article['volume'] . 
				' page : ' . $article['page']
			);
		}
    }
}
?>