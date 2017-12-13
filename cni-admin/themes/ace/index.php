<?php if(!defined('basePath')) exit('No direct script access allowed'); 

$this->getHeader();
?>

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<!-- #section:basics/sidebar.horizontal -->
	<? $this->getTopbar(); ?>

	<!-- /section:basics/sidebar.horizontal -->
	<div class="main-content">
		<div class="main-content-inner">
			<? $this->getSidebar(); ?>
			
			<div class="page-content main-content">
				<div class="breadcrumbs hidden-xs" id="breadcrumbs">
					<?=$this->breadcrumb()?>
				</div>
				<div class="page-header">
					<h1><?=$this->pageTitle();?></h1>
				</div>
					<? $this->getContent(); ?>
				</div>
			</div>
		</div>
	</div><!-- /.main-content -->

	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
</div><!-- /.main-container -->

<?php $this->getFooter(); ?>