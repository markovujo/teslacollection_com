
<div id="search_header" style="width: 1050px">
	<div id="information">
		<div style="float: left; background-color: red; width: 500px"><?php echo $this->Html->image('the_genius_who_lit_the_world.jpg')?></div>
		<div style="float: right; width: 400px; margin-right: 100px;">
			<p>The "Tesla Collection" is the most comprehensive compilation of newspaper and periodical material ever assembled by or about Nikola Tesla.  The Collection begins on August 14, 1886 and continues through December 11, 1920.  Comprising approximately 1,700 separate items totaling more than 4,200 pages, the Collection is drawn from both American and British publications and is reproduced directly from the original English Language material.</p>
			<p>Seen together "The Tesla Collection" not only sheds new light on the early days of electricity, and the development and widespread acceptance by the public and scientific community of Alternating Current, but also provides a one-of-a-kind look into the early days of X-Ray, Wireless, Remote Control, Robotics and the efforts and experiments made by Tesla into the development and delivery of wireless Electricity.</p>
		</div> 
		<div style="clear: both;"></div>
	</div>
	
	<div id="selection_form">
		<?php echo $this->Form->create('ArticleSearch'); ?>
		
		<div id="" style="margin: 50px 0px">
			<?php 
				echo $this->element('selection', array(
			   		'selection_id' => 'publication_id'
			   		, 'selection_name' => 'Publication'
			   		, 'options' => $selections['publication']
				));
				
				echo $this->element('selection', array(
			   		'selection_id' => 'author_id'
			   		, 'selection_name' => 'Author'
			   		, 'options' => $selections['author']
				));
			
				echo $this->element('selection', array(
			   		'selection_id' => 'year_id'
			   		, 'selection_name' => 'Year'
			   		, 'options' => $selections['year']
				));
			
				echo $this->element('selection', array(
			   		'selection_id' => 'subject_id'
			   		, 'selection_name' => 'Subject'
			   		, 'options' => $selections['subject']
				));
				
				echo $this->element('selection_text', array(
					'selection_id' => 'search_text',
					'selection_name' => 'Article Title/Body',
					'name' => 'data[ArticleSearch][text_search]'
				));
			?>
		</div>
		<div style="clear: both"></div>
		
		<div style="text-align: center; background-color: #E6EEEE">
			<?php echo $this->Form->submit('Search'); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>

<div class="articles_search_criteria" style="margin: 25px">
	<?php if(isset($search_results['criteria'])): ?>
		<?php foreach($search_results['criteria'] AS $key => $ids):?>
			<div class="criteria_detail">
				<?php if(is_array($ids)) {
					echo ucwords($key) . ' IN (<br/>' . implode(",<br/>\n", $ids) . '<br/>)';
				} else {
					echo ucwords($key) . " = '" . $ids . "'<br/>";
				}
				?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<?php if(isset($search_results['articles'])):?>
		<div><strong><?php echo count($search_results['articles']) ?></strong> Article(s) found.</div></div>
	<?php endif; ?>
</div>

<!-- 
<div id="pager" class="pager">
	<form>
		<img src="../addons/pager/icons/first.png" class="first"/>
		<img src="../addons/pager/icons/prev.png" class="prev"/>
		<input type="text" class="pagedisplay"/>
		<img src="../addons/pager/icons/next.png" class="next"/>
		<img src="../addons/pager/icons/last.png" class="last"/>
		<select class="pagesize">
			<option selected="selected"  value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option  value="40">40</option>
		</select>
	</form>
</div>
 -->

<div class="articles_search_results" style="margin: 25px 0px">
	<?php if(isset($search_results['articles'])):?>
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
				<?php 
				$i=0;
				foreach($search_results['articles'] AS $article): 
					if($i%2 == 0) {
						$class = "odd";
					} else {
						$class = '';
					}
				?>
					<tr<?php echo ($class != '') ? ' class="' . $class .'"' : '';?>>
						<td><?php echo $this->Html->link($article['Article']['title'], array('controller' => 'articles', 'action' => 'view', $article['Article']['id'])); ?></td>
						<td><?php echo $article['Article']['volume']; ?></td>
						<td><?php echo $article['Article']['page']; ?></td>
						<td><?php echo $article['Publication']['name']; ?></td>
						<td><?php echo $article['Author']['name']; ?></td>
						<td><?php echo date('F d, Y', strtotime($article['Article']['date'])); ?></td>
						<td>
							<?php 
							if(isset($article['Subject']) && !empty($article['Subject'])) {
								$subjects = array();
								foreach($article['Subject'] AS $subject) {
									$subjects[] = $subject['name'];
								}
								echo implode(",", $subjects);
							}
							?>
						</td>
						<td><?php echo str_replace(",", ",<br/>\n", $article['Article']['range_text']); ?></td>
						<td>
							<?php 
							if(isset($article['ArticlePage']) && !empty($article['ArticlePage'])) {
								$filenames = array();
								foreach($article['ArticlePage'] AS $article_page) {
									$link = $this->Html->link($article_page['filename'], array(
											'controller' => 'article_pages', 
											'action' => 'view', 
											$article_page['id']
										), 
										array(
											'class' => 'tooltip_selector', 
											'title' => $article_page['title'],
											'data-id' => $article_page['id']
										)
									);
									echo $link . "<br/>\n";
								}
								//echo implode(",<br/>\n", $filenames);
							}
							?>
						</td>
					</tr>
				<?php 
				$i++;
				endforeach; ?>
			</tbody> 
		</table>
	<?php endif; ?>
</div>
