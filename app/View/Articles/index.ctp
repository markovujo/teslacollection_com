
<div id="search_header" style="width: 1050px">
	<div id="information">
		<div style="float: left; width: 500px"><?php echo $this->Html->image('the_genius_who_lit_the_world.jpg')?></div>
		<div style="float: right; width: 400px; margin-right: 100px;">
			<p>The "Tesla Collection" is the most comprehensive compilation of newspaper and periodical material ever assembled by or about Nikola Tesla.  The Collection begins on August 14, 1886 and continues through December 11, 1920.  Comprising approximately 1,700 separate items totaling more than 4,200 pages, the Collection is drawn from both American and British publications and is reproduced directly from the original English Language material.</p>
			<p>Seen together "The Tesla Collection" not only sheds new light on the early days of electricity, and the development and widespread acceptance by the public and scientific community of Alternating Current, but also provides a one-of-a-kind look into the early days of X-Ray, Wireless, Remote Control, Robotics and the efforts and experiments made by Tesla into the development and delivery of wireless Electricity.</p>
		</div> 
		<div style="clear: both;"></div>
	</div>
	
	<div id="selection_form">
		<?php echo $this->Form->create('ArticleSearch', array('id' => 'article_search_form')); ?>
		
		<div id="" style="margin: 50px 0px">
			<?php 
				echo $this->element('selection', array(
			   		'selection_id' => 'publication_id'
			   		, 'id' => 'publication_selection'
			   		, 'selection_name' => 'Publication'
			   		, 'options' => $selections['publication']
				));
				
				echo $this->element('selection', array(
			   		'selection_id' => 'author_id'
			   		, 'id' => 'author_selection'
			   		, 'selection_name' => 'Author'
			   		, 'options' => $selections['author']
				));
			
				echo $this->element('selection', array(
			   		'selection_id' => 'year_id'
			   		, 'id' => 'year_selection'
			   		, 'selection_name' => 'Year'
			   		, 'options' => $selections['year']
				));
			
				echo $this->element('selection', array(
			   		'selection_id' => 'subject_id'
			   		, 'id' => 'subject_selection'
			   		, 'selection_name' => 'Subject'
			   		, 'options' => $selections['subject']
				));
				
				echo $this->element('selection_text', array(
					'selection_id' => 'title_text'
					, 'id' => 'title_text'
					, 'selection_name' => 'Article Title'
					, 'name' => 'data[ArticleSearch][title_text]'
				));
				
				echo $this->element('selection_text', array(
					'selection_id' => 'search_text'
					, 'id' => 'search_text'
					, 'selection_name' => 'Article Body'
					, 'name' => 'data[ArticleSearch][text_search]'
				));
			?>
		</div>
		<div style="clear: both"></div>
		
		<div style="text-align: center; background-color: #E6EEEE; width: 1000px; height: 25px;">
			<?php //die(debug($this->here));?>
			<span id="article_result_ajax"><img src="<?php echo $this->here ?>img/ajax_spinner_25_25.gif" style="height: 15px" /></span>
			<?php echo $this->Form->button('Search', array('type'=>'submit', 'id' => 'search_submit')); ?>
			<?php echo $this->Form->button('Reset', array('type'=>'reset', 'id' => 'search_reset')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>

<!-- 
<div class="articles_search_criteria" style="border-style: solid; border-width: 3px; padding: 5px; width: 1000px">
	<?php if(isset($search_results['criteria'])): ?>
		<?php foreach($search_results['criteria'] AS $key => $ids):?>
			<div id="criteria_<?php echo $key; ?>" class="criteria_detail" style="width: 200px; float: left; border-style: solid; border-width: 3px;">
				<?php if(is_array($ids)) {
					echo ucwords($key) . ' IN (<br/>' . implode(",<br/>\n", $ids) . '<br/>)';
				} else {
					echo ucwords($key) . " = '" . $ids . "'<br/>";
				}
				?>
			</div>
		<?php endforeach; ?>
		<div style="clear : both" />
	<?php endif; ?>
</div>
-->

<div id="articles_search_results" style="margin: 25px 0px; width: 75%;">
	<div id="articles_search_criteria" style="text-align: center">
		<p><strong><span id="article_result_count"></span></strong> Article(s) found.</p>
	</div>

	<table id="search_results" class="tablesorter">
		<col width="30%">
  		<col width="4%">
  		<col width="4%">
  		<col width="15%">
  		<col width="10%">
  		<col width="10%">
  		<col width="10%">
  		<col width="5%">
  		<col width="15%">
  		<thead>
			<tr>
				<th>Full Article</th>
				<th>Volume</th>
				<th>Page</th>
				<th>Publication</th>
				<th>Author</th>
				<th>Date</th>
				<th>Subject</th>
				<th>Page<br/>Range</th>
				<th>Page</th>
			</tr>
		</thead>
		<tbody> 

		</tbody> 
	</table>
</div>
