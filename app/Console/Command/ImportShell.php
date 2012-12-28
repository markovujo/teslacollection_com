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
		}
        
        //READ THE RECORDS FROM teslacollection tmp_article
        //FOREACH RECORD
        	//-CHECK AUTHOR - IF EXISTS ELSE CREATE
        	//-CHECK PUBLICATION - IF EXISTS ELSE CREATE
        	//-CHECK SUBJECT - IF EXISTS ELSE CREATE
        	
        //READ THE RECORDS FROM teslacollection tmp_article_pages
        //FOREACH RECORD
        	//IMPORT INTO ARTICLE_PAGE
    }
}
?>