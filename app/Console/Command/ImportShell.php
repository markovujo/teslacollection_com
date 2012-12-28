<?php 
class ImportShell extends AppShell 
{
    public function main() 
    {
        $this->out('IMPORTING ARTICLES AND PAGES!!');
        
        $con = mysql_connect("localhost","root","");
		if (!$con) {
  			die('Could not connect: ' . mysql_error());
		}

		mysql_select_db("teslacollection", $con);
		
		$result = mysql_query("select * from tmp_articles ORDER BY volume, page");
		
		$authors = array();
		$publications = array();
		$subjects = array();
		$article_mapping = array();
		
		while ($article = mysql_fetch_assoc($result)) {  
			if(array_key_exists($authors, $author_name)) {
				$author_id = $authors[$author_name];
			} else {
				$this->Author->create();
				$this->Author->save(array(
					'name' => $author_name
				));
				
				$author_id = $this->Author->id;
				$authors[$author_name] = $author_id;
			}
			
			if(array_key_exists($publications, $publication_name)) {
				$publication_id = $publications[$publication_name];
			} else {
				$this->Publication->create();
				$this->Publication->save(array(
					'name' => $publication_name
				));
				
				$publication_id = $this->Publication->id;
				$publications[$publication_name] = $publication_id;
			}
			
			if(array_key_exists($subjects, $subject_name)) {
				$subject_id = $subjects[$subject_name];
			} else {
				$this->Subject->create();
				$this->Subject->save(array(
					'name' => $subject_name
				));
				
				$subject_id = $this->Subject->id;
				$subjects[$subject_name] = $subject_id;
			}
			
			$this->Article->save(
			    'Article' => array(
			    	'id' => 1, 
			    	'name' => 'one random field'
				),
			    'Subject' => array(
			    	'Subject' => array($subject_id)
				)
			);
			
			$article_mapping[$article['id']] => $this->Article->id;
		}
		
		$result = mysql_query("select * from tmp_article_images");
		
		while ($article_page = mysql_fetch_assoc($result)) {  
			$this->ArticlePage->create();
			$this->ArticlePage->save(array(
				'filename' => '',
				'full_path' => '',
				'article_id' => $article_mapping[$article_page['article_id']]
			));
		}
    }
}
?>