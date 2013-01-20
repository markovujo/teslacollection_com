<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Section</title>
    <!-- Use the scoped CSS stylesheet. This is in conjunction with setting Ext.scopeResetCSS = true in app init code --> 
    <script>
        // use the scoped CSS stylesheet if the url has a scopecss parameter
        document.write('<link rel="stylesheet" type="text/css" href="../../resources/css/ext-all' +
            ((window.location.search.indexOf('scopecss') === -1) ? '' : '-scoped') + '.css" />');
    </script>
	<?php echo $this->Html->css('/admin/js/ext/ext-4.1.1a/resources/css/ext-all.css'); ?> 
    
    <?php echo $this->Html->script('/admin/js/ext/ext-4.1.1a/ext-all.js', $options = array('plugin' => 'admin')); ?>
	<?php echo $this->Html->script('/admin/js/teslacollection/articles.js', $options = array('plugin' => 'admin')); ?>
</head>
<body>
<div id="content"></div>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
</body>
</html>