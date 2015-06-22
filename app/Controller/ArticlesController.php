<?php
/**
 * Articles Controller
 */

App::uses('AppController', 'Controller');

/**
 * Article Controller
 *
 */
class ArticlesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Articles';

/**
 * $uses
 * @var array
 */
	public $uses = array(
		'Article',
		'Author',
		'Publication',
		'Subject'
	);

/**
 * Index 
 * 
 * @return void
 */
	public function index() {
		$this->set('title_for_layout', 'the most comprehensive compilation of newspaper and periodical material ever assembled by or about Nikola Tesla');

		$selections = array(
			'author' => array(),
			'publication' => array(),
			'subject' => array()
		);

		$ids = array_keys($selections);
		if (!empty($ids)) {
			foreach ($ids as $id) {
				$Model = ucwords($id);
				$results = $this->$Model->find('all', array(
					'fields' => array(
						$Model . '.id',
						$Model . '.name'
					),
					'contain' => array(),
					'order' => array($Model . '.name')
				));

				$selections[$id]['ALL'] = '-- ALL --';
				if ($results) {
					foreach ($results as $result) {
						$recordId = $result[$Model]['id'];
						$recordValue = $result[$Model]['name'];

						$selections[$id][$recordId] = $recordValue;
					}
				}
			}
		}

		$years = $this->Article->find('all', array(
			'fields' => array('Article.year'),
			'group' => 'Article.year',
			'contain' => false,
			'order' => array('Article.year')
		));

		$selections['year']['ALL'] = '-- ALL --';
		if ($years) {
			foreach ($years as $year) {
				$id = $year['Article']['year'];
				$value = $year['Article']['year'];
				$selections['year'][$id] = $value;
			}
		}

		if (isset($this->data['ArticleSearch']) && !empty($this->data['ArticleSearch'])) {
			$searchResults = $this->Article->search($this->data['ArticleSearch']);

			if (isset($searchResults['criteria']) && !empty($searchResults['criteria'])) {
				foreach ($searchResults['criteria'] as $key => $ids) {
					if (isset($selections[$key])) {
						$newValues = array();
						foreach ($ids as $id) {
							if (isset($selections[$key][$id])) {
								$newValues[$id] = $selections[$key][$id];
							} else {
								$newValues[$id] = $id;
							}
						}
						$searchResults['criteria'][$key] = $newValues;
					}
				}
			}

			//die(debug($search_results));
			$this->set('search_results', $searchResults);
		}

		$this->set('selections', $selections);
	}

/**
 * Search
 * 
 * @return void
 */
	public function search() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->RequestHandler->respondAs('json');

		$searchResults = array();

		$selections = array(
			'author' => array(),
			'publication' => array(),
			'subject' => array()
		);

		$ids = array_keys($selections);
		if (!empty($ids)) {
			foreach ($ids as $id) {
				$Model = ucwords($id);
				$results = $this->{$Model}->find('all', array(
					'fields' => array(
						$Model . '.id',
						$Model . '.name'
					),
					'contain' => array(),
					'order' => array($Model . '.name')
				));

				if ($results) {
					foreach ($results as $result) {
						$recordId = $result[$Model]['id'];
						$recordValue = $result[$Model]['name'];
						$selections[$id][$recordId] = $recordValue;
					}
				}
			}
		}

		$years = $this->Article->find('all', array(
			'fields' => array('Article.year'),
			'group' => 'Article.year',
			'contain' => false,
			'order' => array('Article.year')
		));

		if ($years) {
			foreach ($years as $year) {
				$id = $year['Article']['year'];
				$value = $year['Article']['year'];
				$selections['year'][$id] = $value;
			}
		}

		if (isset($this->data['ArticleSearch']) && !empty($this->data['ArticleSearch'])) {
			$searchResults = $this->Article->search($this->data['ArticleSearch']);

			if (isset($searchResults['criteria']) && !empty($searchResults['criteria'])) {
				foreach ($searchResults['criteria'] as $key => $ids) {
					if (isset($selections[$key])) {
						$newValues = array();
						foreach ($ids as $id) {
							if (isset($selections[$key][$id])) {
								$newValues[$id] = $selections[$key][$id];
							} else {
								$newValues[$id] = $id;
							}
						}
						$searchResults['criteria'][$key] = $newValues;
					}
				}
			}
		}

		return (json_encode($searchResults));
	}

/**
 * View
 * 
 * @param int $id - Article.id
 * @return void
 */
	public function view($id = null) {
		if (!is_null($id) && $id > 0) {
			$article = $this->Article->find('first', array(
				'conditions' => array(
					'Article.id' => $id
				)
			));

			$this->set('article', $article);
		}
	}

/**
 * View All 
 * 
 * @param array $articles - Articles array
 * @return void
 */
	public function viewAll($articles) {
		$this->set('articles', $articles);
	}

/**
 * View By URL
 * 
 * @param string $url - Url of article
 * @return void
 */
	public function viewByUrl($url) {
		$article = $this->findByUrl($url);
		$this->set('article', $article);
	}

/**
 * Slug format - articles/year/publication/author/article_slug
 * 
 * @throws NotFoundException
 * @return void
 */
	public function viewBySlug() {
		ini_set('memory_limit', '512M');
		$args = func_get_args();
		$argsCount = count($args);
		$lastArg = $args[$argsCount - 1];

		$this->Article->unbindModel(
			array('hasAndBelongsToMany' => array('Page'))
		);

		$this->Article->bindModel(
			array('hasAndBelongsToMany' => array('Page'))
		);

		$article = $this->Article->find('first', array(
			'conditions' => array('Article.url' => $lastArg),
		));

		if (!empty($article)) {
			$title = '"' . $article['Article']['title'] . '". ' . $article['Publication']['name'] . ', ' . date('F j, Y', strtotime($article['Article']['date']) . '.');
			$this->set('title_for_layout', $title);
			$this->set('article', $article);
			$this->render('view');
		} else {
			//die(debug($args));
			if ($argsCount >= 1) {
				$conditions = array();

				if (isset($args[0])) {
					$conditions['year_id'] = array((int)$args[0]);
				}

				if (isset($args[1])) {
					$conditions['publication_url'] = array($args[1]);
				}

				if (isset($args[2])) {
					$conditions['author_url'] = array($args[2]);
				}

				$articles = $this->Article->search($conditions);
				//die(debug($conditions));
				//die(debug($articles));

				if ($articles) {
					$this->set('criteria', $articles['criteria']);
					$this->set('articles', $articles['articles']);
				} else {
					$this->redirect('/');
				}
			} else {
				$this->redirect('/');
			}
		}
	}

/**
 * Sitemap
 * 
 * @return void
 */
	public function sitemap() {
		$articles = $this->Article->find('all');
		$this->set(compact('articles'));
		$this->RequestHandler->respondAs('xml');
	}
}