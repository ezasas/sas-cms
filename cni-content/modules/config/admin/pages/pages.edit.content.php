<?php if (!defined('basePath')) exit('No direct script access allowed');

// Table Name
$sqltable 	= array(

	'table'		 => $this->table_prefix.'pages_content',
	'content_id' => $contentID
);


// Get Parent Page
$pageName   = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
$queryPage 		= "select page_id, ".$pageName." as page_name from ".$this->table_prefix."pages where content_id<>'0' and page_id<>'".$pageID."' order by ".$pageName ;
$getArrpage 	= $this->db->getAll($queryPage);
$parentOption 	= array();
$menuName		= '';
$parentOption 	= '<option value="0">--</option>';

foreach($getArrpage as $k=>$v){
	
	extract($v);
	
	$parID			= isset($_POST['parent_id'])?$_POST['parent_id']:$parentID;
	$parentSelected	= $parID==$page_id?' selected="true"':'';	
	$parentOption  .= '<option value="'.$page_id.'"'.$parentSelected.'>'.$page_name.'</option>';
}

$parent = '<select name="parent_id" class="chosen-select form-control">'.$parentOption.'</select>';


// Define arr input
$checkbox 	= array('addcheck' => array('1' => 'Yes'));
$params 	= array(
	
	$this->form->input->hidden('page_id',$pageID),
	$this->form->input->html('<div class="row">'),
	
	//post
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
		$this->form->input->switchcheck('Publish', 'add_publish',$type=2,$checked=false,$addClass='pull-right'),
		$this->form->input->hidden('add_updated_date',date('Y-m-d h:i:s')),
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
		$this->form->input->html($parent),
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
		$this->form->input->html('</div>'),
		$this->form->input->html('</div>'),
	
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);


// On insert add to page
$this->form->onUpdate('updatePage($this->db,$post,$this->table_prefix,$this->isMultiLang,$this->lang)');
$this->form->beforeUpdate('cek()');

function updatePage($db,$post,$table_prefix,$isMultiLang,$lang){
 
	global $system;
	
	if($system->site->isMultiLang()){
	
		foreach($system->site->lang() as $langID=>$langVal){
		
			//Check page_url
			$postTitle = anti_injection(htmlentities(str_replace('\\','\\\\',$post['add_content_title_'].$langID),ENT_QUOTES));
			$postTagline = anti_injection(htmlentities(str_replace('\\','\\\\',$post['add_content_tagline_'].$langID),ENT_QUOTES));
			$pageUrl = seo_slug($postTitle);
			$qryUrl	 = "select page_url_".$langID." from ".$table_prefix."pages where page_name_".$langID."='".$post['add_content_title_'.$langID]."' and page_id<>'".intval($post['page_id'])."' order by page_url_".$langID." desc";
			$cUrl	 = $db->getOne("select page_url_".$langID." from ".$table_prefix."pages where page_url_".$langID."='".$pageUrl."'");
			$slugUrl = $db->execute($qryUrl);
			
			if($slugUrl->recordCount()>0){
			
				if($pageUrl==$cUrl){
					$pageUrl = $pageUrl.'-1';
				}
				else{
					$sUrl		= $db->getOne($qryUrl);
					$arrSlug 	= explode('-',$sUrl);
					$xSlug		= count($arrSlug)-1;
					$lastSlug 	= intval($arrSlug[$xSlug]);
					$lastSlug  += 1;
					$pageUrl	= $post['add_content_title_'.$langID].'-'.$lastSlug;
				}
			}
			//echo $pageUrl.'<br>';
			@$setFields .= "page_name_".$langID."='".$postTitle."', page_tagline_".$langID."='".$postTagline."', page_url_".$langID."='".$pageUrl."',";
		}
	}
	else{
	
		//Check page_url
		$postTitle = anti_injection(htmlentities(str_replace('\\','\\\\',$post['add_content_title']),ENT_QUOTES));
		$postTagline = anti_injection(htmlentities(str_replace('\\','\\\\',$post['add_content_tagline']),ENT_QUOTES));
		$pageUrl = seo_slug($postTitle);
		$qryUrl	 = "select page_url from ".$table_prefix."pages where page_name='".$postTitle."' and page_id<>'".intval($post['page_id'])."' order by page_url desc";
		$cUrl	 = $db->getOne("select page_url from ".$table_prefix."pages where page_url='".$pageUrl."'");
		$slugUrl = $db->execute($qryUrl);
		
		if($slugUrl->recordCount()>0){
		
			if($pageUrl==$cUrl){
				$pageUrl = $pageUrl.'-1';
			}
			else{
				$sUrl		= $db->getOne($qryUrl);
				$arrSlug 	= explode('-',$sUrl);
				$xSlug		= count($arrSlug)-1;
				$lastSlug 	= intval($arrSlug[$xSlug]);
				$lastSlug  += 1;
				$pageUrl	= $postTitle.'-'.$lastSlug;
			}
		}
		
		$setFields = "page_name='".$postTitle."', page_tagline='".$postTagline."', page_url='".$pageUrl."', parent_id='".$post['parent_id']."',";
	}
	
	$setFields 	= substr($setFields,0,-1);
	$sql 		= "update ".$table_prefix."pages set ".$setFields." where page_id='".intval($post['page_id'])."'";
	
	$db->execute($sql);
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

$this->form->getForm('edit',$sqltable,$params,$formName='content',$submitValue='Update page',$finishButton=true);
?>