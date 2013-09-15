<?php echo $this->Html->css(Configure::read('Server.uri') . '/fpgallery/fpgallery.css'); ?>
<?php echo $this->Html->css(Configure::read('Server.uri') . '/colorbox/colorbox.css'); ?>

<?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'); ?>
<?php echo $this->Html->script(Configure::read('Server.uri') . '/fpgallery/fpgallery.js'); ?>
<?php echo $this->Html->script(Configure::read('Server.uri') . '/colorbox/jquery.colorbox-min.js'); ?>

<div class="section_text">
	<h1>TESLA PICTURE GALLERY</h1>
	
	<p>For the most part these scans were taken off the web and are assembled here for your convenience.  If for whatever reason you should need an illustration for publication or academic use, since the High Resolution Photographs are from my private collection they should be credited to "The Tesla Collection."</p>
	<p>In assembling these scans it is taken for granted that anyone utilizing them for whatever reason would know what they are and, therefore, a detailed description of each would prove unnecessary.</p>
	<p>For a full size scan simply click on the thumbnail.</p>
</div>

<!-- display list of folders in "albums" folder and paginate in 6 item blocks -->
<div id="fpGallery" class="fpGallery" style="margin: 45px 0px;"><div class="numPerPage" title="40"></div></div>