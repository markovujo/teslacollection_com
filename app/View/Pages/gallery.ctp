<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script src="js/galleria/galleria-1.2.9.min.js"></script>

<style>
    #galleria { 
    	width: 700px; 
    	height: 400px; 
    	background: #000 
   	}
</style>

<div id="galleria">
    <?php foreach($images AS $image) : ?>
    	<img src="/images/gallery/<?php echo $image['filename']; ?>" data-title="" data-description="">
    <?php endforeach; ?>
</div>

<script>
	Galleria.loadTheme('js/galleria/themes/classic/galleria.classic.min.js');
    Galleria.run('#galleria');
</script>