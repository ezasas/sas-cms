<?php if (!defined('basePath')) exit('No direct script access allowed');

// Table Name
$sqltable 	= array(

	'table'		 => $this->table_prefix.'pages_content'
);

// Get Parent Menu
$queryPage 		= "select page_id, page_name from ".$this->table_prefix."pages where content_id<>'0' order by page_name";
$getArrpage 	= $this->db->getAll($queryPage);
$parentOption 	= array();
$menuName		= '';

$parentOption[0] = '--';

foreach($getArrpage as $k=>$v){
	
	extract($v);
	$parentOption[$page_id] = $page_name;
}

$parent = array('addoption'	=> $parentOption);

// Define arr input
$checkbox 	= array('addcheck' => array('1' => 'Yes'));
$params 	= array(
	
	//post	
	$this->form->input->html('<div class="row">'),
	
		$this->form->input->html('<div class="col-md-8 col-lg-9">'),
		$this->form->input->html('<div class="box">'),
		$this->form->input->html('<div class="box-header with-border">'),
		$this->form->input->html('<div class="widget-header">'),
		$this->form->input->html('<h4 class="widget-title">Content Page</h4>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('<div class="box-body">'),
		$this->form->input->html($this->langTabs()),
		$this->form->input->text('Title', 'add_content_title',80, $multilang=true),
		$this->form->input->text('Tagline', 'add_content_tagline', 80, $multilang=true),
		$this->form->input->textarea('Content Text', 'add_content_text',60,30,$editor=true, $multilang=true),	
		$this->form->input->textarea('Description', 'add_content_description',80,2,$editor=false, $multilang=true),
		$this->form->input->html('<div class="hidden-hr">'),
		$this->form->input->text('Tag', 'add_content_tag', 80, $multilang=true, $value='', $extra='class="form-control"', $comment='Pisahkan dengan tanda koma'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		
		$this->form->input->html('<div class="col-md-4 col-lg-3">'),

		//publish
		$this->form->input->html('<div class="box">'),
		$this->form->input->html('<div class="box-header with-border">'),
		$this->form->input->html('<div class="widget-header">'),
		$this->form->input->html('<h4 class="widget-title">Publish</h4>'),
		$this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#publish" href="#publish" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('<div id="publish" class="box-body collapse in">'),
		$this->form->input->html('<div class="widget-main label-inline hidden-hr">'),
		#$this->form->input->checkbox('Publish', 'add_publish',$checkbox),
		$this->form->input->switchcheck('Publish', 'add_publish',$type=2,$checked=true,$addClass='pull-right'),
		#$this->form->input->text('Author', 'add_author',30),
		$this->form->input->hidden('add_created_date',date('Y-m-d h:i:s')),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('<div class="space"></div>'),

		//parents
		$this->form->input->html('<div class="box">'),
		$this->form->input->html('<div class="box-header with-border">'),
		$this->form->input->html('<div class="widget-header">'),
		$this->form->input->html('<h4 class="widget-title">Parent</h4>'),
		$this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#parents" href="#parents" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('<div id="parents" class="box-body collapse in">'),
		$this->form->input->html('<div class="widget-main hidden-hr">'),
		$this->form->input->select('','parent_id', $parent),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('<div class="space"></div>'),
			
		//image
		$this->form->input->html('<div class="box">'),
		$this->form->input->html('<div class="box-header with-border">'),
		$this->form->input->html('<div class="widget-header">'),
		$this->form->input->html('<h4 class="widget-title">Featured Image</h4>'),
		$this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#image" href="#image" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('<div id="image" class="box-body collapse in">'),
		$this->form->input->html('<div class="widget-main hidden-hr">'),
		$this->form->input->image('','add_content_image',uploadPath.'modules/pages/',uploadPath.'modules/pages/thumbs/','image'),
		$this->form->input->html('<div class="clearfix"></div>'),
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),		$this->form->input->html('</div>'),
		
		$this->form->input->html('</div>'),
	
	$this->form->input->html('</div>')
);


// On insert add to page
$this->form->onInsert('addToPage($this->db,$post,$this->table_prefix,$this->user,$this->isMultiLang,$this->lang)');
$this->form->beforeInsert('cek()');

function addToPage($db,$post,$table_prefix,$user){

	global $system;
	
	$content_id = $db->insert_id();
	
	if($system->site->isMultiLang()){
	
		foreach($system->site->lang() as $langID=>$langVal){
		
			//Check page_url
			$pageUrl = seo_slug($post['add_content_title_'.$langID]);
			$qryUrl	 = "select page_url_".$langID." from ".$table_prefix."pages where page_name_".$langID."='".$post['add_content_title_'.$langID]."' order by page_url_".$langID." desc";
			$cUrl	 = $db->getOne("select page_url_".$langID." from ".$table_prefix."pages where page_url_".$langID."='".$pageUrl."'");
			$slugUrl = $db->execute($qryUrl);
			
			if($pageUrl==$cUrl){
				$pageUrl = $pageUrl.'-1';
			}
			if($slugUrl->recordCount()>0){
			
				$sUrl		= $db->getOne($qryUrl);
				$arrSlug 	= explode('-',$sUrl);
				$xSlug		= count($arrSlug)-1;
				$lastSlug 	= intval($arrSlug[$xSlug]);
				$lastSlug  += 1;
				$pageUrl	= $post['add_content_title_'.$langID].'-'.$lastSlug;
			}
			
			@$setFields .= "page_name_".$langID."='".$post['add_content_title_'.$langID]."', page_tagline_".$langID."='".$post['add_page_tagline_'.$langID]."', page_url_".$langID."='".$pageUrl."',";
		}
	}
	else{
	
		//Check page_url
		$pageUrl = seo_slug($post['add_content_title']);
		$qryUrl	 = "select page_url from ".$table_prefix."pages where page_name='".$post['add_content_title']."' order by page_url desc";
		$cUrl	 = $db->getOne("select page_url from ".$table_prefix."pages where page_url='".$pageUrl."'");
		$slugUrl = $db->execute($qryUrl);
		
		if($pageUrl==$cUrl){
			$pageUrl = $pageUrl.'-1';
		}
		if($slugUrl->recordCount()>0){
		
			$sUrl		= $db->getOne($qryUrl);
			$arrSlug 	= explode('-',$sUrl);
			$xSlug		= count($arrSlug)-1;
			$lastSlug 	= intval($arrSlug[$xSlug]);
			$lastSlug  += 1;
			$pageUrl	= $post['add_content_title'].'-'.$lastSlug;
		}
		
		$setFields = "page_name='".$post['add_content_title']."', page_tagline='".$post['add_content_tagline']."', page_url='".$pageUrl."',";
	}
	
	//add new page
	$publish = isset($post['switchcheck']['add_publish']['value'])?1:0;
	$sql 	 = "insert into ".$table_prefix."pages set parent_id='".$post['parent_id']."', module_id='".contentID."', ".$setFields." content_id='".$content_id."', page_switch='_page', publish='".$publish."'";
	$db->execute($sql);
	$pageID	 = $db->insert_id();
	
	//set permission
	$groupID	= $_SESSION['admin']['group_id'];
	$getAccess  = $user->getPermission($groupID);
	
	foreach($getAccess as $permission){
		$setPermission[] = $permission;
	}
	
	$setPermission[] = $pageID;
	
	$db->execute("update ".$table_prefix."user_group set access='".serialize($setPermission)."' where group_id='".$groupID."'");
}

function cek(){
	
	global $system;

	$error = false;
	$alert = '';
	
	if($system->site->isMultiLang()){
	
		foreach($system->site->lang() as $langID=>$langVal){
			
			@$sc .= '
			
				elseif(empty($_POST[\'add_content_title_'.$langID.'\'])){
					$error = true;
					$alert = "Title '.strtoupper($langVal).' cannot be empty.";
				}
				elseif(empty($_POST[\'add_content_text_\'])){
					$error = true;
					$alert = "Content text '.strtoupper($langVal).' cannot be empty.";
				}
			';
		}
	}
	else{
	
		@$sc = '
			
			elseif(empty($_POST[\'add_content_title\'])){
				$error = true;
				$alert = "Title cannot be empty.";
			}
			elseif(empty($_POST[\'add_content_text\'])){
				$error = true;
				$alert = "Content text cannot be empty.";
			}
		';
	}
	
	$sc = substr(trim($sc),4);
	
	eval($sc);
	
	$response = array(
		
		'error' => $error,
		'alert' => $alert
	);
	
	return $response;	
}

//create tab navigation
$arrTabs  = array(
	
	'content' 		=> array(
		'title'		=> 'Content Page',
		'url'		=> $this->adminURL().'add-new-page/content'.$this->permalink(),
		'active'	=> 'active'
	),
	'application' 	=> array(
		'title'		=>	'Application Page',
		'url'		=>	$this->adminURL().'add-new-page/application'.$this->permalink()
	)
);
$this->form->getForm('add',$sqltable,$params,$formName='content','Add Page',true);
?>