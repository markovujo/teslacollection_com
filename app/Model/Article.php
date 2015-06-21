<?php
/**
 *
 * Article Model
 *
 * TeslaCollection.com(tm) : (http://teslacollection.com)
 */
class Article extends AppModel {

	public $belongsTo = array(
		'Author' => array(
			'className' => 'Author',
			'foreignKey' => 'author_id'
		),
		'Publication' => array(
			'className' => 'Publication',
			'foreignKey' => 'publication_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'Subject' => array(
			'className' => 'Subject',
		),
		'Page' => array(
			'className' => 'Page',
			'fields' => array('id', 'filename', 'full_path', 'status')
		)
	);

	public $actsAs = array('Containable');

/**
 * After find logic
 * 
 * @param array $results - Find result records
 * @param bool $primary - Whether this model is being queried directly (vs. being queried as an association)
 * @return array
 */
	public function afterFind($results, $primary = false) {
		if ($results) {
			foreach ($results as &$result) {
				$year = isset($result['Article']['year']) ? $result['Article']['year'] : '';
				$publication = isset($result['Publication']['url']) ? $result['Publication']['url'] : '';
				$author = isset($result['Author']['url']) ? $result['Author']['url'] : '';
				$articleUrl = isset($result['Article']['url']) ? $result['Article']['url'] : '';

				$result['Article']['full_url'] = "tesla_articles/" . $year . '/' . $publication . '/' . $author . '/' . $articleUrl;
			}
		}

		//die(debug($results));
		return $results;
	}

/**
 * Search logic.  Returns records based on params
 * 
 * @param array $params - Array parameters to search for
 * @return array
 */
	public function search($params) {
		$conditions = array();
		$joins = array();
		$group = array('Article.id');

		$fields = array(
			'Article.id',
			'Article.title',
			'Article.volume',
			'Article.page',
			'Article.date',
			'Article.year',
			'Article.range_text',
			'Article.url'
		);

		$contain = array(
			'Author' => array('fields' => array('id', 'name', 'url')),
			'Publication' => array('fields' => array('id', 'name', 'url')),
			'Subject' => array('fields' => array('id', 'name', 'url')),
			'Page' => array(
				'fields' => array('id', 'filename', 'ArticlesPage.id')
			),
		);

		$return = array(
			'criteria' => array()
		);

		if (isset($params['limit']) && !empty($params['limit'])) {
			$limit = (int)$params['limit'];
		} else {
			$limit = null;
		}

		if (isset($params['author_id']) && !empty($params['author_id'])) {
			if (!in_array('ALL', $params['author_id'])) {
				$conditions['Author.id'] = (array)$params['author_id'];
				$return['criteria']['author'] = $params['author_id'];
			}
		}

		if (isset($params['author_url']) && !empty($params['author_url'])) {
			$conditions['Author.url'] = (array)$params['author_url'];
			$return['criteria']['author_url'] = $params['author_url'];
		}

		if (isset($params['publication_id']) && !empty($params['publication_id'])) {
			if (!in_array('ALL', $params['publication_id'])) {
				$conditions['Publication.id'] = (array)$params['publication_id'];
				$return['criteria']['publication'] = $params['publication_id'];
			}
		}

		if (isset($params['publication_url']) && !empty($params['publication_url'])) {
			$conditions['Publication.url'] = (array)$params['publication_url'];
			$return['criteria']['publication_url'] = $params['publication_url'];
		}

		if (isset($params['subject_id']) && !empty($params['subject_id'])) {
			if (!in_array('ALL', $params['subject_id'])) {
				$conditions['ArticlesSubject.subject_id'] = (array)$params['subject_id'];
				$joins[] = array(
					'table' => 'articles_subjects',
					'alias' => 'ArticlesSubject',
					'type' => 'LEFT',
					'conditions' => array(
						'Article.id = ArticlesSubject.article_id'
					)
				);
				$return['criteria']['subject'] = $params['subject_id'];
			}
		}

		if (isset($params['year_id']) && !empty($params['year_id'])) {
			if (!in_array('ALL', $params['year_id'])) {
				$conditions['Article.year'] = (array)$params['year_id'];
				$return['criteria']['year'] = $params['year_id'];
			}
		}

		if (isset($params['title_text']) && $params['title_text'] != '') {
			App::uses('Sanitize', 'Utility');
			$params['title_text'] = Sanitize::escape($params['title_text']);

			$conditions['Article.title LIKE'] = '%' . $params['title_text'] . '%';

			$return['criteria']['title_text'] = $params['title_text'];
		}

		if (isset($params['text_search']) && !empty($params['text_search'])) {
			App::uses('Sanitize', 'Utility');
			$params['text_search'] = Sanitize::escape($params['text_search']);

			$joins[] = array(
				'table' => 'articles_pages',
				'alias' => 'ArticlesPage',
				'type' => 'INNER',
				'conditions' => array(
					'Article.id = ArticlesPage.article_id'
				)
			);

			$joins[] = array(
				'table' => 'pages',
				'alias' => 'Page',
				'type' => 'INNER',
				'conditions' => array(
					'ArticlesPage.page_id = Page.id'
				)
			);

			$conditions[] = array(
				"MATCH(Page.text) AGAINST('" . $params['text_search'] . "' IN BOOLEAN MODE)"
			);

			$return['criteria']['text_search'] = $params['text_search'];
		}
		$conditions['Article.status'] = 'active';

		$return['articles'] = $this->find('all', array(
			'conditions' => $conditions,
			'contain' => $contain,
			'joins' => $joins,
			'group' => $group,
			'fields' => $fields,
			'limit' => $limit
		));

		/* DEBUGGING ::
		debug($params);
		debug($conditions);
		debug($joins);
		debug($return['articles']);
		die();
		*/

		//die(debug($return['articles']));
		//CAKEPHP CAN'T SORT BY filename FOR HABTM ASSOCIATED TABLE
		if (!empty($return['articles'])) {
			foreach ($return['articles'] as &$article) {
				if (isset($article['Page']) && !empty($article['Page'])) {
					$article['Page'] = Set::sort($article['Page'], '{n}.filename', 'asc');
				}
			}
		}

		//die(debug($return));
		return $return;
	}
}
