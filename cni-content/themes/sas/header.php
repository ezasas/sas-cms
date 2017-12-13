<?php if (!defined('basePath')) exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
	<head>
		
		<?php echo $this->head();?>
		
		<!-- CSS -->
		<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap.min.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/font-awesome.min.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/animate.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/font-awesome-animation.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/owl.carousel.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/style.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/twitter-widget.css');?>
		<link rel="stylesheet" href="<?php echo $this->themeURL(); ?>assets/css/skin1.css" class="skin-style">

		<?=$this->load_css($this->themeURL().'assets/css/blueimp-gallery.min.css');?> <!-- Image Gallery -->
        <?=$this->load_css($this->themeURL().'assets/css/bootstrap-image-gallery.css');?> <!-- Image Gallery -->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="<?php echo $this->themeURL(); ?>assets/js/html5shiv.js"></script>
		<script src="<?php echo $this->themeURL(); ?>assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="body">
	
		<!-- Header 
		================================================== -->
		<header class="hidden-xs">
			<div class="top-bar">
				<div class="container">
					<div class="pull-left">
						<ul class="top-contact">
							<li><span class="glyphicon glyphicon-envelope iconleft circle"></span> <?=$this->site->company_email()?></li>
							<li><span class="glyphicon glyphicon-earphone iconleft circle"></span> <?=$this->site->company_phone()?></li>
						</ul>
					</div>
					<div class="pull-right">
					
						<?php
						$getSocial = '';						
						foreach($this->site->social_media() as $socialID => $socialUrl){
							
							if(!empty($socialUrl)){
								$socialIcon	= str_replace('_','-',$socialID);
								$socialTitle = ucwords(str_replace('_',' ',$socialID));
								$getSocial  .= '<li><a href="'.$socialUrl.'" target="_blank" class="'.$socialIcon.'" title="'.$socialTitle.'" rel="tooltip" data-placement="bottom"><i class="fa fa-'.$socialIcon.'"></i></a></li>';
							}
						}
						?>
					
						<ul class="social-icon">
							<?php echo $getSocial; ?>
						</ul>					
					</div>
				</div>
			</div>
		</header>
		<!-- /.Header -->
		
		
		<!-- Navigation 
		================================================== -->
		<nav class="navbar navbar-default" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php 
							if($this->site->logo() != ''){
								echo '
								<div class="navbar-brand">
									<img class="img-responsive" src="'.uploadURL.'modules/siteconfig/thumbs/small/'.$this->site->logo().'">
								</div>';
							}else{ ?>
								<a class="navbar-brand" href="<?php echo baseURL; ?>"><strong><?php echo $this->site->title(); ?></strong></a>
							<?php } ?>
				</div>
				
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<?php
					/*
					<div class="navbar-nav navbar-right hidden-xs">
						<div class="btn-group nav-search">
							<button type="button" class="btn-search" data-toggle="dropdown">
								<span class="glyphicon glyphicon-search"></span>
							</button>
							<div class="dropdown-menu search-box">
								<form action="<?=baseURL?>search<?=$this->permalink();?>" class="search-form" method="get">
									<div class="input-group">
									  <input type="search" name="k" class="form-control no-shadow" placeholder="Search.." value="<?php echo urldecode(@$this->_GET('k')); ?>">
									  <span class="input-group-btn">
										<button class="btn btn-default no-shadow" type="submit">Go!</button>
									  </span>
									</div>
								</form>								
							</div>
						</div>
					</div>
					*/
					?>
					<?=$this->getMenu('top', 'nav navbar-nav navbar-right')?>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		<!-- /.Navigation -->