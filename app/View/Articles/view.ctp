<div itemscope itemtype="http://schema.org/NewsArticle">
	<div style="display: block; margin: 25px auto; width: 500px">
		<table style="width: 500px">
			<tr>
				<td>Name</td>
				<td align="center"><strong>"<span itemprop="name"><?php echo $article['Article']['title']; ?></span>"</strong></td>
			</tr>
			<tr>
				<td>Publisher</td>
				<td align="center"><strong><span itemprop="publisher"><?php echo $article['Publication']['name']; ?></span></strong></td>
			</tr>
			<tr>
				<td>Date</td>
				<td align="center"><strong><span itemprop="dateCreated"><time datetime="<?php echo date('Y-m-d', strtotime($article['Article']['date'])); ?>"><?php echo date('F j, Y', strtotime($article['Article']['date'])); ?></time></span></strong></td>
			</tr>
			<tr>
				<td>Author</td>
				<td align="center"><strong><span itemprop="author"><?php echo $article['Author']['name']; ?></span></strong></td>
			</tr>
		</table>
	</div>
	<?php 
	$article_text = '';
	$i = 1;
	if(isset($article['Page']) && !empty($article['Page'])): ?>
		<?php foreach($article['Page'] AS $page) :?>
			<div>
				<?php $itemprop = ($i == 1) ? 'itemprop="image"' : ''; ?>
				<img src="<?php echo Configure::read('Server.uri');?>/article_pages/view/<?php echo $page['id']?>" alt="<?php echo $article['Article']['title'] . '_' . $i; ?>" <?php echo $itemprop; ?> />
			</div>
			<?php 
				$article_text = $article_text . ' <p>' . $page['text'] . '</p>';
				$i++;
			?>
		<?php endforeach;?>
	<?php endif;?>
	
	<div itemprop="articleBody" style="width: 550px;">
		<?php echo $article_text; ?>
	</div>
</div>