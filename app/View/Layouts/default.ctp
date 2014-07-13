
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $siteDescription ?> - <?php echo $title_for_layout; ?>
	</title>
	<meta name="description" content="<?php //echo str_replace('"', '\'', $siteDescription); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <?php echo $this->Html->meta('icon'); ?>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.teslacollection.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo $this->Html->css('carousel'); ?>
  </head>
<!-- NAVBAR
================================================== -->
  <body>
  
      <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
	      <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img class="featurette-image img-responsive" style="height: 35px; width: auto; margin: 6px;" src="/img/the_tesla_collection.jpg" alt="The Tesla Collection"> 
	        </div>
	        <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li class="active"><a href="<?php echo Configure::read('Server.uri');?>/">Articles</a></li>
				<li><a href="<?php echo Configure::read('Server.uri');?>/images">Images</a></li>
				<li><a href="<?php echo Configure::read('Server.uri');?>/directors">Directors</a></li>
				<li><a href="<?php echo Configure::read('Server.uri');?>/about">About</a></li>
				<li><a href="<?php echo Configure::read('Server.uri');?>/contact">Contact</a></li>
	          </ul>
	          <form class="navbar-form navbar-right">
	            <input type="text" class="form-control" placeholder="Search by text ...">
	          </form>
	        <!--/.navbar-collapse -->
	      </div>
      </div>
    </div>

    <div class="container">
      <?php echo $this->Session->flash(); ?>
	  <?php echo $this->fetch('content'); ?>

      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; <?php echo date('Y'); ?> - "The Tesla Collection".  &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
