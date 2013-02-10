<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tesla Collection | Admin Section</title>

	<?php echo $this->Html->css('/admin/js/ext/ext-4.1.1a/resources/css/ext-all.css'); ?> 
    
    <?php echo $this->Html->script('/admin/js/ext/ext-4.1.1a/ext-all.js', $options = array('plugin' => 'admin')); ?>
    <?php //echo $this->Html->script('/admin/js/ext/ext-4.1.1a/ext-all-debug.js', $options = array('plugin' => 'admin')); ?>
</head>
<body>
<div id="content"></div>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
</body>
</html>