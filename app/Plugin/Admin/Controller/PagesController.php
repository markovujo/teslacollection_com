<?php
App::uses('AdminAppController', 'Admin.Controller');

/**
 * Pages Controller
 *
 */
class PagesController extends AdminAppController {

/**
 * Uses
 *
 * @var array
 */
	public $uses = array(
		'Page',
		'ArticlePage'
	);

/**
 * Process Page upload
 * 
 * @return void
 */
	public function upload() {
		$errors = array();
		$page = array();

		$this->log($this->request->params['form'], 'requesting');
		if ($this->request->is('post')) {
			$articleId = $this->request['data']['article-id'];
			$articleText = $this->request['data']['article-text'];

			if (!empty($this->request->params['form'])) {
				$result = $this->_processUpload($this->request->params['form']);

				if ($result['success']) {
					$this->Page->create();
					$page = $this->Page->save(array(
						'filename' => $result['filename'],
						'full_path' => $result['full_path'],
						'text' => $articleText,
						'status' => 'active'
					));

					if (!empty($page)) {
						$this->ArticlesPage->create();
						$this->ArticlesPage->save(array(
							'article_id' => $articleId,
							'page_id' => $page['Page']['id']
						));
					} else {
						$errors[] = 'Failed to save page!';
					}
				} else {
					$errors = array_merge($result['errors'], $errors);
				}
			} else {
				$errors[] = 'POST form param not found!';
			}
		} else {
			$errors[] = 'POST operation not used!';
		}

		$this->__setUpJsonResponse();
		return (json_encode(array(
			'success' => empty($errors),
			'errors' => $errors,
			'page' => $page
		)));
	}

/**
 * Process the Upload
 * 
 * @param array $form - Form posted
 * @return array
 */
	protected function _processUpload($form = array()) {
		$errors = array();

		if (!empty($form['filename']['tmp_name'])) {
			if (!is_uploaded_file($form['filename']['tmp_name'])) {
				$errors[] = 'File not uploaded!';
			}

			$filename = $form['filename']['name'];
			$uploadPath = APP . 'files/tesla_collection/Volume 24/';

			if (!file_exists($uploadPath)) {
				mkdir($uploadPath, 0744, true);
			}

			$fullPath = $uploadPath . $filename;
			if (empty($errors)) {
				$count = $this->Page->find('count', array(
					'conditions' => array(
						'Page.filename' => $filename
					),
					'contain' => false
				));

				if ($count == 0) {
					if (!move_uploaded_file($form['filename']['tmp_name'], $fullPath)) {
						$errors[] = 'Failed trying to move file from tmp folder.';
					}
				} else {
					$errors[] = 'Filename (' . $filename . ') already exists!';
				}
			}
		} else {
			$errors[] = 'Tmp name not set!';
		}

		return array(
			'success' => empty($errors),
			'errors' => $errors,
			'full_path' => $fullPath,
			'filename' => $filename
		);
	}
}
