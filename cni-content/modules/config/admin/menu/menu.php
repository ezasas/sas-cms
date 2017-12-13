<?php if (!defined('basePath')) exit('No direct script access allowed');

$admin			= $this->session('admin');
$uriID 			= @$this->uri(3)=='public'?5:4;
$uriParent 		= @$this->uri(3)=='public'?4:3;

$getParentID 	= !$this->uri($uriID)?0:intval($this->uri($uriID));
$getParentID 	= @$this->uri($uriParent)=='parent'?$getParentID:0;

$xadminMenu		= $this->uri(3)=='admin'?1:0;
$tableName		= $this->table_prefix.'pages';
$sqlCond 		= " where content_id='0'";
$query   		= "select page_id,parent_id,page_name from ".$tableName.$sqlCond." order by page_name";
$fURL   		= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$menuUrl 		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='menu' and page_id='".$this->thisPageID()."'");

//create tab navigation
if($xadminMenu==0){

	$arrTabs  = array(
		
		'public' 		=> array(
			'title'		=> 'Public Menu',
			'url'		=> $this->adminURL().$menuUrl.'/public'.$this->permalink(),
			'active'	=> 'nav-menu active'
		),
		'admin' 	=> array(
			'title'		=>	'Admin Menu',
			'url'		=> $this->adminURL().$menuUrl.'/admin'.$this->permalink(),
			'active'	=> 'nav-menu'
		)
	);
}
else{

	$arrTabs  = array(
		
		'public' 		=> array(
			'title'		=> 'Public Menu',
			'url'		=> $this->adminURL().$menuUrl.'/public'.$this->permalink(),
			'active'	=> 'nav-menu'
		),
		'admin' 	=> array(
			'title'		=>	'Admin Menu',
			'url'		=> $this->adminURL().$menuUrl.'/admin'.$this->permalink(),
			'active'	=> 'nav-menu active'
		)
	);
}
$navMenu = '';
foreach($arrTabs as $v){
	$navMenu .= '<li class="'.$v['active'].'"><a href="'.$v['url'].'">'.$v['title'].'</a></li>';
}
$navMenu = '<ul class="nav-group">'.$navMenu.'</ul>';

//Position
$arrPosition  = $xadminMenu==1?$this->menuPosition('admin'):$this->menuPosition();
$position	  = '<select name="p" onchange="this.form.submit()" class="select2 form-control">';

foreach($arrPosition as $positionID=>$positionVal){
	
	$activePosition = empty($activePosition )?$positionID:$activePosition ;
	$selected  		= $positionID == @$this->_GET('p')?' selected="true"':'';
	$position 	   .= '<option value="'.$positionID.'"'.$selected.'>'.$positionVal.'</option>';
}
$position 	   .= '</select>';
$getPosition 	= $this->_GET('p');
$activePosition = !empty($getPosition)?$getPosition:$activePosition;
?>

<div class="row">
	<div class="col-md-4 col-lg-3">
		<? require 'menu.add.php'; ?>
	</div>
	<div class="col-md-8 col-lg-9">
		<? require 'menu.list.php'; ?>
	</div>
</div>