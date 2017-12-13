<?php if (!defined('basePath')) exit('No direct script access allowed');

$tableName	= $this->table_prefix.'pages';
$sqlCond 	= " where content_id='0'";
$xpgName    = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
$query   	= "select * from ".$tableName.$sqlCond." order by ".$xpgName;
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$pageUrl 	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='page' and page_id='".$this->thisPageID()."'");
$menuUrl 	= $this->adminURL().$pageUrl.'/content'.$this->permalink();

//create tab navigation
$arrTabs  = array(
	
	'content' 		=> array(
		'title'		=> 'Content Page',
		'url'		=> $this->adminURL().$pageUrl.'/content'.$this->permalink(),
		'active'	=> 'nav-menu'
	),
	'application' 	=> array(
		'title'		=>	'Application Page',
		'url'		=>	$this->adminURL().$pageUrl.'/application'.$this->permalink(),
		'active'	=> 'nav-menu active'
	)
);

$navMenu = '';
foreach($arrTabs as $v){
	$navMenu .= '<li class="'.$v['active'].'"><a href="'.$v['url'].'">'.$v['title'].'</a></li>';
}
$navMenu = '<ul class="nav-group">'.$navMenu.'</ul>';
?>

<div class="tab-content">

	<div class="row">
		<div class="col-md-4 col-lg-3">
			<div class="box">
				<div class="box-header with-border">
					<div class="widget-header">
						<h4 class="widget-title">Select Parent</h4>
						<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#parent" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>
					</div>
				</div>
				<div id="parent" class="box-body collapse in">
					<div class="widget-main">
						<div class="tree">
							<?php echo $this->tree->getMenu($query,$menuUrl,$tableName,'page_id');?>
						</div>
					</div>
				</div>	
			</div>	
		</div>
		<div class="col-md-8 col-lg-9">
			<?include'pages.aplication.list.php';?>
		</div>
	</div>
	
</div>