<?php if(!defined('basePath')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
	<?php echo $this->head();?>	
	
	<!-- bootstrap & fontawesome -->
	<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/font-awesome.min.css');?>
	
	<!-- plugin style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/select2.min.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/datepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap-timepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/daterangepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap-datetimepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/colorpicker.css');?>	
	
	<!-- admin style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/AdminLTE.min.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/skins/skin-blue.css');?>
	
	<!-- flag style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/flag.css');?>
	
	<!-- custom style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/form.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/style.css');?>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="<?php echo $this->themeURL(); ?>assets/js/html5shiv.js"></script>
	<script src="<?php echo $this->themeURL(); ?>assets/js/respond.min.js"></script>
	<![endif]-->
	<?php echo $this->load_js($this->themeURL().'assets/js/jquery-2.2.3.min.js');?>
	<?php echo $this->load_js($this->themeURL().'assets/js/jquery-ui.min.js');?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo baseURL?>" target="_blank" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><small><i class="fa fa-tasks"></i></small></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">2Sign Panel</span>
    </a>
	
	
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
		  <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->admin('name');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo uploadURL?>modules/user/thumbs/mini/<?php echo $this->admin('image')?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->admin('name');?>
                  <small><?php echo $this->admin('group_name');?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $this->adminURL()?>my-profile<?php echo $this->permalink()?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $this->logoutURL()?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>