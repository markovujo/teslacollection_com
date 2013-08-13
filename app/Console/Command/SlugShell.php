<?php 
/**
 * Create slugs url for SEO friendly links on TeslaCollection
 * @author MarkoVujovic
 * 
 * cake Import
 */
class SlugShell extends AppShell 
{
    public $uses = array(
    	'Article'	
    	, 'Author'
    	, 'Publication'
    	, 'Subject'
    );
	
	public function main() 
    {
        $this->out('SAVING ARTICLES!!');
        
        $articles = $this->Article->find('all', array(
        	'conditions' => array(
        		//'Article.id' => 1649
        	),
        	'contain' => false
        ));
        
        $i = 1;
        $total_count = count($articles);
        
        //die(debug($articles));
        if($articles) {
        	foreach($articles AS $article) {
        		$data = array(
        			'id' => $article['Article']['id'],
        			'title' => $article['Article']['title']
        		);
        		
        		if($this->Article->save($data)) {
        			$this->out('SUCCESSFULLY SAVED ARTICLE (' . $article['Article']['id'] . ')! - ' . $i . '/' . $total_count);
        		}
        		$i++;
        	}
        }
        
        $models = array(
        	'Author',
        	'Publication',
        	'Subject'
        );
        
        if($models) {
        	foreach($models AS $model) {
        		$records = $this->{$model}->find('all', array('contain' => false));
        		
        		$i = 1;
        		$record_count = count($records);
        		
        	    if($records) {
		        	foreach($records AS $record) {
		        		$data = array(
		        			'id' => $record[$model]['id'],
		        			'name' => $record[$model]['name']
		        		);
		        		
		        		if($this->{$model}->save($data)) {
		        			$this->out('SUCCESSFULLY SAVED ' . strtoupper($model) . ' (' . $record[$model]['id'] . ')! - ' . $i . '/' . $record_count);
		        		}
		        		$i++;
		        	}
		        }
        	}
        }
    }
}
?>