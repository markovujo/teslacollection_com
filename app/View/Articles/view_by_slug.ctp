<?php //die(debug($articles)); ?>

<div id="articles_search_results">
	<div id="articles_search_criteria" style="text-align: center">
		<p><strong><span id="article_result_count"></span></strong> Article(s) found.</p>
	</div>

	<table id="search_results" class="tablesorter" width="1250">
		<col style="width: 450px;">
		<col style="width: 50px;">
		<col style="width: 50px;">
		<col style="width: 150px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 50px;">
		<col style="width: 215px;">
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
		
		<?php if($articles) : ?>
			<?php 
			foreach($articles AS $article) :
				$subjects = '';
				$article_page_text = '';
			?>
				<tr>
				    <td><a href=" <?php echo $article['Article']['full_url']; ?>" style="color : #d82323"><?php echo $article['Article']['title'] ?></a></td>
				   	<td><?php echo $article['Article']['volume']; ?></td>
				   	<td><?php echo $article['Article']['page']; ?></td>
				   	<td><?php echo $article['Publication']['name']; ?></td>
				   	<td><?php echo $article['Author']['name']; ?></td>
				   	<td><?php echo $article['Article']['date'] ?></td>
				   	<td><?php echo $subjects; ?></td>
				   	<td><?php echo $article['Article']['range_text'] ?></td>
				   	<td><?php echo $article_page_text?></td>
				</tr>
			<?php endforeach;?>
		<?php endif;?> 

		</tbody> 
	</table>
</div>

<script type="text/javascript">
	$(function() {
		$('#articles_search_results').show();
	}
</script>