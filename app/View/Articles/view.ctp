<?php if(isset($article['Page']) && !empty($article['Page'])): ?>
	<?php foreach($article['Page'] AS $page) :?>
		<div><img src="/article_pages/view/<?php echo $page['id']?>" /></div>
	<?php endforeach;?>
<?php endif;?>