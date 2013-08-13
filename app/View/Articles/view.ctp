<div itemscope itemtype="http://schema.org/NewsArticle">
	<h2 itemprop="name">Name :: <?php echo $article['Article']['title']; ?></h2>
	<h2 itemprop="publisher">Publisher :: <?php echo $article['Publication']['name']; ?></h2>
	<h2 itemprop="dateCreated">Date :: <?php echo $article['Article']['date']; ?></h2>
	<h2 itemprop="author">Author :: <?php echo $article['Author']['name']; ?></h2>
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
				$article_text += $page['text'];
				$i++;
			?>
		<?php endforeach;?>
	<?php endif;?>
	
	<div itemprop="articleBody" style="width: 550px;">
		Article Text :: <?php echo $article_text; ?>
	</div>
</div>