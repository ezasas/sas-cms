<!DOCTYPE html>
<html lang="en">
	<head>
		<?=$this->head();?>	

		<!-- bootstrap & fontawesome -->
		<?=$this->load_css($this->themeURL().'assets/css/bootstrap.css');?>
		<?=$this->load_css($this->themeURL().'assets/css/font-awesome.css');?>

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<?=$this->load_css($this->themeURL().'assets/css/ace-fonts.css');?>
		
		<!-- ace styles -->
		<?=$this->load_css($this->themeURL().'assets/css/ace.css');?>
		
		<!-- cni styles -->
		<?=$this->load_css($this->themeURL().'assets/css/flag.css');?>
		<?=$this->load_css($this->themeURL().'assets/css/style.css');?>

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?=$this->themeURL()?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?=$this->themeURL()?>assets/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<?=$this->load_js($this->themeURL().'assets/js/ace-extra.js');?>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?=$this->themeURL()?>assets/js/html5shiv.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/respond.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container container-fluid">
			<div class="main-content">
				<div class="row-fluid">
					<div class="span12">
						<div class="login-container">
							<div class="row-fluid">
								<div class="center">
									<h1>
										<i class="icon-desktop green"></i>
										<span class="red">CNI</span>
										<span class="white">Application</span>
									</h1>
									<h4 class="blue">&copy; <?=$this->site->title()?></h4>
								</div>
							</div>

							<div class="space-14"></div>

							<div class="row-fluid">
								<div class="position-relative">
									<div id="login-box" class="login-box visible widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<h4 class="header blue lighter bigger">
													<i class="ace-icon fa fa-cloud-download green"></i>
													Please Enter Your Information
												</h4>

												<div class="space-6"></div>
												<?
												if(!empty($this->ErrorLogin)){
													echo '<div class="alert alert-danger">'.$this->ErrorLogin.'</div><div class="space-6"></div>';
												}
												?>
												<form action="" method="post">
													<fieldset>
													
														<label class="block clearfix">
															<span class="block input-icon input-icon-right">
																<input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off"/>
																<i class="ace-icon fa fa-user"></i>
															</span>
														</label>

														<label class="block clearfix">
															<span class="block input-icon input-icon-right">
																<input type="password" class="form-control" name="pass" placeholder="Password" autocomplete="off" />
																<i class="ace-icon fa fa-lock"></i>
															</span>
														</label>

														<div class="space"></div>
														
														<button type="submit" class="btn btn-sm btn-primary" name="login"><span>Login</span><i class="icon-right fa fa-sign-in"></i></button>
														<input type="hidden" value="<?=$this->data->token('scode')?>" name="scode">

														<div class="space-4"></div>
													</fieldset>
												</form>
											</div><!--/widget-main-->
										</div><!--/widget-body-->
									</div><!--/login-box-->
								</div><!--/position-relative-->
							</div>
						</div>
					</div><!--/.span-->
				</div><!--/.row-fluid-->
			</div>
		</div><!--/.main-container-->
	</body>
</html>