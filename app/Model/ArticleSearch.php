<?php 
class ArticleSearch extends AppModel 
{
	public $useTable = false;
	
	public $uses = array(
		'Article'
		, 'ArticlePage'
		, 'Subject'
		, 'Author'
		, 'Publication'
	);
	
	public function search($params)
	{
		$conditions = array();
		
		$contain = array(
			'Author',
			'Publication',
			'Subject',
			'ArticlePage'
		);
		
		if(isset($params['author_ids'])) {
			$conditions['Author.id'] = $params['author_ids'];
		}
		
		if(isset($params['publication_ids'])) {
			$conditions['Publication.id'] = $params['publication_ids'];
		}
		
		if(isset($params['subject_ids'])) {
			$conditions['Subject.id'] = $params['subject_ids'];
		}
		
		if(isset($params['years'])) {
			$conditions['Article.year'] = $params['years'];
		}
		
		$results = $this->Article->find('all', array(
			'conditions' => $conditions
			, 'contain' => $contain
		));
		
		return $results;
	}
}
?>