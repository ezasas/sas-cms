<?php if(!defined('basePath')) exit('No direct script access allowed'); 

$addBodyClass  = isset($_COOKIE['adminSkin'])?' '.$_COOKIE['adminSkin']:' no-skin';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php echo $this->head();?>	

		<!-- bootstrap & fontawesome -->
		<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/font-awesome.css');?>

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<?php echo $this->load_css($this->themeURL().'assets/css/ace-fonts.css');?>

		<!-- plugin styles -->
		<?php echo $this->load_css($this->themeURL().'assets/css/chosen.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/datepicker.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap-timepicker.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/daterangepicker.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap-datetimepicker.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/colorpicker.css');?>
		
		<!-- ace styles -->
		<?php echo $this->load_css($this->themeURL().'assets/css/ace.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/ace-skins.css');?>
		
		<!-- shCore -->
		<?php echo $this->load_css($this->themeURL().'assets/css/shcore/shCore.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/shcore/shThemeDefault.css');?>
		
		<!-- cni styles -->
		<?php echo $this->load_css($this->themeURL().'assets/css/flag.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/style.css');?>

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo $this->themeURL()?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo $this->themeURL()?>assets/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<?php echo $this->load_js($this->themeURL().'assets/js/ace-extra.js');?>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo $this->themeURL()?>assets/js/html5shiv.js"></script>
		<script src="<?php echo $this->themeURL()?>assets/js/respond.js"></script>
		<![endif]-->
		
		<!-- basic script -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo $this->themeURL()?>assets/js/jquery.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='<?php echo $this->themeURL()?>assets/js/jquery1x.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $this->themeURL()?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>
	</head>

	<body class="<?php echo $addBodyClass?>">
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default navbar-fixed-top">
		
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				
				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
				
					<!-- #section:basics/sidebar.mobile.toggle -->
					<?php
					$arrPosition = $this->menuPosition('admin');
					if($this->adminMenu('left')!='' && in_array('left',$arrPosition)){
					
						?>
						<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar2">
							<span class="sr-only">Toggle sidebar</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?
					}
					?>
					<!-- #section:basics/navbar.layout.brand -->
					<a href="<?php echo baseURL?>" target="_blank" class="navbar-brand">						
						<small><i class="fa fa-tasks"></i> <?php echo $this->site->title()?></small>
					</a>
					
					<!-- #section:basics/sidebar.mobile.toggle -->
					<?php
					$arrMenuPosition = $this->menuPosition('admin');

					if($this->adminMenu('top')!='' && in_array('top',$arrMenuPosition)){
						
						?>
						<button type="button" class="navbar-toggle menu-toggler pull-right" id="menu-toggler" data-target="#sidebar">
							<span class="sr-only">Toggle sidebar</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?
					}
					?>
				</div>
				
				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle nav-user">								
								<div class="user-photo">
									<div class="square">
										<div class="square-content">
											<div class="img-wrap">
												<img class="propotion-image landscape" src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" alt="<?php echo $this->admin('name');?>'s Photo" />
											</div>
										</div>
									</div>
								</div>
								<span class="user-info">
									<?php echo $this->admin('name');?>
									<small><?php echo $this->admin('group_name');?></small>
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="<?php echo $this->adminURL()?>my-profile<?php echo $this->permalink()?>">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>
								<li>
									<a href="<?php echo $this->adminURL()?>my-account<?php echo $this->permalink()?>?t=<?php echo $this->admin('session')?>">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>
								
								<?php if($this->admin('group_id')==1 || $this->admin('group_id')==2){ ?>
								<li class="divider"></li>								
								<li>
									<a href="<?php echo $this->reloginURL()?>">
										<i class="ace-icon fa fa-refresh"></i>
										Relogin
									</a>
								</li>
								<?php } ?>
								
								<li class="divider"></li>
								<li>
									<a href="<?php echo $this->logoutURL()?>">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>