<?php	
	echo $this->Form->create('ArticleSearch');

	echo $this->element('selection', array(
   		'selection_id' => 'author_id'
   		, 'selection_name' => 'Author'
   		, 'options' => $selections['author']
	));
	
	echo $this->element('selection', array(
   		'selection_id' => 'publication_id'
   		, 'selection_name' => 'Publication'
   		, 'options' => $selections['publication']
	));
	
	echo $this->element('selection', array(
   		'selection_id' => 'subject_id'
   		, 'selection_name' => 'Subject'
   		, 'options' => $selections['subject']
	));
	
	echo $this->element('selection', array(
   		'selection_id' => 'year_id'
   		, 'selection_name' => 'Year'
   		, 'options' => $selections['year']
	));
	
	echo $this->Form->end('Submit');
?>

<div class="articles_search_results">
	<?php if(isset($articles)):?>
		<?php foreach($articles AS $article):?>
			<?php debug($article); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
