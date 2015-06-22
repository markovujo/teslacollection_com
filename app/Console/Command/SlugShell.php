<?php 
/**
 * Create slugs url for SEO friendly links on TeslaCollection
 * @author MarkoVujovic
 * 
 * cake Import
 */
class SlugShell extends AppShell {

	public $uses = array(
		'Article',
		'Author',
		'Publication',
		'Subject'
	);

/**
 * Main logic
 */
	public function main() {
		$this->out('SAVING ARTICLES!!');

		$articles = $this->Article->find('all', array(
			'conditions' => array(),
			'contain' => false
		));

		$i = 1;
		$totalCount = count($articles);

		//die(debug($articles));
		if ($articles) {
			foreach ($articles as $article) {
				$data = array(
					'id' => $article['Article']['id'],
					'title' => $article['Article']['title']
				);

				if ($this->Article->save($data)) {
					$this->out('SUCCESSFULLY SAVED ARTICLE (' . $article['Article']['id'] . ')! - ' . $i . '/' . $totalCount);
				}
				$i++;
			}
		}

		$models = array(
			'Author',
			'Publication',
			'Subject'
		);

		if ($models) {
			foreach ($models as $model) {
				$records = $this->{$model}->find('all', array('contain' => false));

				$i = 1;
				$recordCount = count($records);

				if ($records) {
					foreach ($records as $record) {
						$data = array(
							'id' => $record[$model]['id'],
							'name' => $record[$model]['name']
						);

						if ($this->{$model}->save($data)) {
							$this->out('SUCCESSFULLY SAVED ' . strtoupper($model) . ' (' . $record[$model]['id'] . ')! - ' . $i . '/' . $recordCount);
						}
						$i++;
					}
				}
			}
		}
	}
}