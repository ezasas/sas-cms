<?php if(!defined('basePath')) exit('No direct script access allowed');

$arrPosition = $this->menuPosition('admin');

if($this->adminMenu('left')!='' && in_array('left',$arrPosition)){

	//Sidebar Class
	$addSidebarClass  = isset($_COOKIE['sidebarMin'])?$_COOKIE['sidebarMin']:'';
	$addSidebarClass  = $addSidebarClass=='menu-min'?' menu-min':'';	
	$addSidebarClass  = in_array('top',$arrPosition) && !isset($_COOKIE['sidebarMin'])?' menu-min':$addSidebarClass;	
	$addArrowClass 	  = $addSidebarClass!=' menu-min'?' fa-angle-double-left':' fa-angle-double-right';	
	
	$fURL = $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
	$statisticUrl = $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='statistics_main'");
	$pageUrl = $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='page'");
	$userUrl = $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='user'");
	$configUrl = $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='site_config'");
	?>

	<div class="sidebar responsive<?=$addSidebarClass?>" id="sidebar2">
		<div class="sidebar-shortcuts" id="sidebar-shortcuts">
			<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
				<a href="<?php echo $this->adminURL().$statisticUrl.$this->permalink() ?>" class="btn btn-success">
					<i class="ace-icon fa fa-bar-chart"></i>
				</a>
				<a href="<?php echo $this->adminURL().$pageUrl.$this->permalink() ?>" class="btn btn-info">
					<i class="ace-icon fa fa-pencil"></i>
				</a>
				<a href="<?php echo $this->adminURL().$userUrl.$this->permalink() ?>" class="btn btn-warning">
					<i class="ace-icon fa fa-users"></i>
				</a>
				<a href="<?php echo $this->adminURL().$configUrl.$this->permalink() ?>" class="btn btn-danger">
					<i class="ace-icon fa fa-cogs"></i>
				</a>
			</div>

			<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
				<span class="btn btn-success"></span>

				<span class="btn btn-info"></span>

				<span class="btn btn-warning"></span>

				<span class="btn btn-danger"></span>
			</div>
		</div><!-- /.sidebar-shortcuts -->

		<?=$this->adminMenu('left');?>

		<!-- #section:basics/sidebar.layout.minimize -->
		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i class="angle-icon ace-icon fa <?=$addArrowClass?>" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
		</div>
	</div>
	<?
}
?>