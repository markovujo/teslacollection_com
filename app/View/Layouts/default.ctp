<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$siteDescription = '"The Tesla Collection" - the most comprehensive compilation of newspaper and periodical material ever assembled by or about Nikola Tesla';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $siteDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('layout');
		echo $this->Html->css('table');
		echo $this->Html->css('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css');
		echo $this->Html->css('tablesorter/style.css');
		
		echo $this->Html->script('http://code.jquery.com/jquery-1.8.3.js');
		echo $this->Html->script('http://code.jquery.com/ui/1.9.2/jquery-ui.js');
		
		echo $this->Html->script('tablesorter/jquery.metadata.js');
		echo $this->Html->script('tablesorter/jquery.tablesorter.min.js');
		echo $this->Html->script('tablesorter/jquery.tablesorter.pager.js');
		echo $this->Html->script('article_search.js');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer" style="width: 1000px">
			&copy; <?php echo date('Y'); ?> - "The Tesla Collection"
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
