<?php 
/**
 * Import Articles and Article Pages into the Database
 * @author MarkoVujovic
 * 
 * cake Import
 */
class ImportShell extends AppShell {

	public $uses = array(
		'Author',
		'Publication',
		'Subject',
		'Article',
		'ArticlePage'
	);

/**
 * Truncate tables
 * 
 * @return void
 */
	public function truncateTables() {
		$this->Article->query("TRUNCATE TABLE articles");
		$this->Article->query("TRUNCATE TABLE article_pages");
		$this->Article->query("TRUNCATE TABLE publications");
		$this->Article->query("TRUNCATE TABLE authors");
		$this->Article->query("TRUNCATE TABLE subjects");
		$this->Article->query("TRUNCATE TABLE articles_subjects");
	}

/**
 * Main logic
 * 
 * @return void
 */
	public function main() {
		$this->out('IMPORTING ARTICLES AND PAGES!!');

		$authors = array();
		$publications = array();
		$subjects = array();
		$articleMapping = array();

		$con = mysql_connect("localhost", "root", "");
		if (!$con) {
			die('Could not connect: ' . mysql_error());
		}

		mysql_select_db("teslacollection", $con);

		$this->truncateTables();

		$result = mysql_query("select * from tmp_articles ORDER BY volume, page");

		while ($article = mysql_fetch_assoc($result)) {
			$authorName = trim($article['author']);
			$publicationName = trim($article['publication']);
			$subjectName = trim($article['subject']);

			if (array_key_exists($authorName, $authors)) {
				$authorId = $authors[$authorName];
			} else {
				if ($authorName != '') {
					$this->Author->create();
					$this->Author->save(array(
						'name' => $authorName
					));

					$authorId = $this->Author->id;
					$authors[$authorName] = $authorId;
				}
			}

			if (array_key_exists($publicationName, $publications)) {
				$publicationId = $publications[$publicationName];
			} else {
				if ($publicationName != '') {
					$this->Publication->create();
					$this->Publication->save(array(
						'name' => $publicationName
					));

					$publicationId = $this->Publication->id;
					$publications[$publicationName] = $publicationId;
				}
			}

			if (array_key_exists($subjectName, $subjects)) {
				$subjectId = $subjects[$subjectName];
			} else {
				if ($subjectName != '') {
					$this->Subject->create();
					$this->Subject->save(array(
						'name' => $subjectName
					));

					$subjectId = $this->Subject->id;
					$subjects[$subjectName] = $subjectId;
				}
			}

			$this->Article->saveAll(array(
				'Article' => array(
					'volume' => trim($article['volume']),
					'page' => trim($article['page']),
					'title' => trim($article['title']),
					'date' => date('Y-m-d', strtotime(trim($article['date']))),
					'year' => date('Y', strtotime(trim($article['date']))),
					'range_text' => trim($article['range_text']),
					'status' => 'created',
					'publication_id' => $publicationId,
					'author_id' => $authorId,
				),
				'Subject' => array(
					'Subject' => array(
						$subjectId
					)
				)
			));

			$this->out("\n\nArticle Id :: " . $this->Article->id .
				' title : ' . $article['title'] . "\n" .
				' volume : ' . $article['volume'] .
				' page : ' . $article['page']
			);
			$articleMapping[$article['id']] = $this->Article->id;
		}

		$result = mysql_query("select * from tmp_article_images");

		while ($articlePage = mysql_fetch_assoc($result)) {
			$article = array(
				'id' => null,
				'volume' => null,
				'page' => null,
				'title' => null
			);

			if (isset($articleMapping[$articlePage['article_id']])) {
				$articleId = $articleMapping[$articlePage['article_id']];
				$articleResult = $this->Article->find('first', array(
					'conditions' => array(
						'Article.id' => $articleId
					)
				));

				if ($articleResult) {
					$article = $articleResult['Article'];
				}
			}

			$this->ArticlePage->create();
			$this->ArticlePage->save(array(
				'article_id' => $articleId,
				'filename' => trim($articlePage['filename']),
				'full_path' => trim($articlePage['full_path']),
				'title' => trim($article['title']),
				'text' => trim($articlePage['text'])
			));

			$this->out('Article Id :: ' . $this->ArticlePage->id .
				' Article Page :: ' . $articlePage['filename'] .
				' Title :: ' . $article['title'] .
				' volume : ' . $article['volume'] .
				' page : ' . $article['page']
			);
		}
	}
}