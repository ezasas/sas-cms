<?php if (!defined('basePath')) exit('No direct script access allowed');

// Tabel Name
$sqltable 	= array(

	'table'	=> $this->table_prefix.'menu'
);

// Init
$pageName 	= $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
$adminMenu 	= $this->uri(3)=='admin'?1:0;
$adminOnly	= $adminMenu ==1?'':' and admin_only=\'0\'';

// Selet Page menu
$arrPageMenu = $this->db->getAll("select page_id from ".$this->table_prefix."menu where admin_menu='".$adminMenu."' and position='".$activePosition."' and page_id<>'0'");
$pageMenu	 = array();

foreach($arrPageMenu as $val){
	
	extract($val);
	$pageMenu[] = $page_id;
}

// Create select page
$getArrPage = $this->db->getAll("select page_id,".$pageName." as pagemulti,page_name from ".$this->table_prefix."pages where category_id='0' and publish='1' ".$adminOnly." order by page_name");
$pages		= array();

foreach($getArrPage as $val){
	
	extract($val);
	if(!in_array($page_id,$pageMenu)){
		$pagesID[$page_id] = html_entity_decode($page_name);
		
		if(!empty($pagemulti)){
			$pagesID[$page_id] = html_entity_decode($pagemulti);
		}
	}
}


// Create categoy page
$pageName   = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
$getArrCategory = $this->db->getAll("select page_id,".$pageName." as page_name from ".$this->table_prefix."pages where category_id<>'0'".$adminOnly." order by ".$pageName);

$categoriesID	= array();

foreach($getArrCategory as $val){
	
	extract($val);
	
	if(!in_array($page_id,$pageMenu)){
		$categoriesID[$page_id] = html_entity_decode($page_name);
	}
}

$pages 	  = array('addoption'=>@$pagesID);
$category = array('addoption'=>@$categoriesID);
$publish  = array('addcheck' => array('1' => 'Yes'));

$activeTabs 	= isset($_POST['active_tabs'])?$_POST['active_tabs']:'page';
$pageClass 		= $activeTabs=='page'?' in active':'';
$categoryClass 	= $activeTabs=='category'?' in active':'';


// Pages
$pageParams = array(	
	
	$this->form->input->select('', 'add_page_id', $pages,$multiple=false,'class="select2 form-control"'),
	$this->form->input->html('<div class="hide-hr">'),
	$this->form->input->icon('', 'add_icon'),
	$this->form->input->html('</div>'),
	$this->form->input->hidden('add_admin_menu',$adminMenu),
	$this->form->input->hidden('add_position',$activePosition),
	$this->form->input->hidden('add_publish',1)
);


// Category
$categoryParams = array(

	$this->form->input->select('', 'add_page_id', $category,$multiple=false,'class="select2 select-cat form-control"'),
	$this->form->input->html('<div class="hide-hr">'),
	$this->form->input->icon('', 'add_icon'),
	$this->form->input->html('</div>'),
	$this->form->input->hidden('add_admin_menu',$adminMenu),
	$this->form->input->hidden('add_position',$activePosition),
	$this->form->input->hidden('add_publish',1)
);


// Custom Links
$customParams = array(

	$this->form->input->text('Label', 'add_custom_title', $size=40),
	$this->form->input->text('URL', 'add_custom_url', $size=40, $multilang=false, $value='http://'),
	$this->form->input->html('<div class="hide-hr">'),
	$this->form->input->icon('', 'add_icon'),
	$this->form->input->html('</div>'),
	$this->form->input->hidden('add_admin_menu',$adminMenu),
	$this->form->input->hidden('add_position',$activePosition),
	$this->form->input->hidden('add_custom_links',1),
	$this->form->input->hidden('add_publish',1)
);

/*
$this->form->onInsert('reloadPage()');

function reloadPage(){
	echo '<meta http-equiv="refresh" content="0">';
}
*/
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<h4 class="widget-title">Pages</h4>
			<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#page" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>
		</div>
	</div>
	<div id="page" class="box-body collapse in">
		<div class="widget-main">
			<div class="default-form form-actions-inner">
				<?php echo $this->form->getForm('add',$sqltable,$pageParams,$formName='pages',$submitValue='Add to menu');?>
			</div>
		</div>
	</div>	
</div>
<div class="space"></div>

<div class="box" id="select-cat">
	<div class="box-header with-border">
		<div class="widget-header">
			<h4 class="widget-title">Category</h4>
			<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#category" aria-expanded="false" aria-controls="collapseOne" class="toggle-select collapsed"><i class="ace-icon fa fa-chevron-down"></i></a></div>
		</div>
	</div>
	<div id="category" class="box-body collapse">
		<div class="widget-main">
			<div class="default-form form-actions-inner">
				<?php echo $this->form->getForm('add',$sqltable,$categoryParams,$formName='category',$submitValue='Add to menu');?>
			</div>
		</div>
	</div>
</div>
<div class="space"></div>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<h4 class="widget-title">Custom link</h4>
			<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#link" aria-expanded="false" aria-controls="collapseOne" class="toggle-select collapsed"><i class="ace-icon fa fa-chevron-down"></i></a></div>
		</div>
	</div>	
	<div id="link" class="box-body collapse">
		<div class="widget-main">
			<div class="default-form form-actions-inner">
				<?php echo $this->form->getForm('add',$sqltable,$customParams,$formName='link',$submitValue='Add to menu');?>
			</div>
		</div>
	</div>	
</div>