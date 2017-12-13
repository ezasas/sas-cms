<?php if (!defined('basePath')) exit('No direct script access allowed'); 

$catID 	  		= intval($this->uri(3));
$redirect 		= base64_decode(substr($this->uri(4),3));
$parentID 		= $this->db->getOne("select parent_id from ".$this->table_prefix."category where category_id='".$catID."'");
$breadcrumbCat	= $this->breadcrumbCategory($parentID);

// Table Name
$sqltable 	= array(

	'table'		  => $this->table_prefix.'category',
	'category_id' => $catID
);

// Get Category
$parent = array(
	'addoption'	=> array(
		'0' => '--'
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> 'category_name',
		'cond' 	=> 'where category_type=\'post\' and category_id<>\''.$catID.'\''
	)
);

// Define form field
$params	= array(
	
	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->hidden('catID',$catID),
	$this->form->input->html($this->langTabs()),
	/* $this->form->input->image('Default Image','add_category_image',uploadPath.'modules/category/',uploadPath.'modules/category/thumbs/','image'), */
	$this->form->input->text('Name', 'add_category_name',80, $multilang=true),
	$this->form->input->text('Tagline', 'add_category_tagline', 80, $multilang=true),
	$this->form->input->select('Parent', 'add_parent_id', $parent),
	$this->form->input->html('<div class="hidden-hr">'),
	$this->form->input->textarea('Description','add_category_description',30,3,$editor=false, $multilang=true),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->onUpdate('updatePage($this->db,$post,$this->table_prefix,$this->isMultiLang,$this->lang)');

function updatePage($db,$post,$table_prefix,$isMultiLang,$lang){

	global $system;
	
	// is Multilang
	if($isMultiLang){
	
		foreach($lang as $langID=>$langVal){
			
			$categoryName = $post['add_category_name_'.$langID];
			$pageUrl 	  = seo_slug($categoryName);
			$qryUrl	 	  = "select page_url_".$langID." from ".$table_prefix."pages where page_name_".$langID."='".$categoryName."' and category_id<>'".$post['catID']."' order by page_url_".$langID." desc";
			$cUrl	 	  = $db->getOne("select page_url_".$langID." from ".$table_prefix."pages where page_url_".$langID."='".$pageUrl."' and category_id<>'".$post['catID']."'");
			$slugUrl 	  = $db->execute($qryUrl);
			
			if($pageUrl==$cUrl){
				$pageUrl = $pageUrl.'-1';
			}
			if($slugUrl->recordCount()>0){
			
				$sUrl		= $db->getOne($qryUrl);
				$arrSlug 	= explode('-',$sUrl);
				$xSlug		= count($arrSlug)-1;
				$lastSlug 	= intval($arrSlug[$xSlug]);
				$lastSlug  += 1;
				$pageUrl	= seo_slug($categoryName).'-'.$lastSlug;
			}
			
			@$setField 	   .= "page_name_".$langID."='".$categoryName."',page_tagline_".$langID."='".$post['add_category_tagline_'.$langID]."',page_url_".$langID."='".$pageUrl."',";
			@$setFieldAdd  .= "page_name_".$langID."='add new ".$categoryName."',page_url_".$langID."='add-new-".$pageUrl."',";
			@$setFieldEdit .= "page_name_".$langID."='edit ".$categoryName."',page_url_".$langID."='edit-".$pageUrl."',";	
		}
	}
	else{
		$pageUrl = seo_slug($post['add_category_name']);
		$qryUrl	 = "select page_url from ".$table_prefix."pages where page_name='".$post['add_category_name']."' and category_id<>'".$post['catID']."' order by page_url desc";
		$cUrl	 = $db->getOne("select page_url from ".$table_prefix."pages where page_url='".$pageUrl."' and category_id<>'".$post['catID']."'");
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
			$pageUrl	= seo_slug($post['add_category_name']).'-'.$lastSlug;
		}
		$setField 	  = "page_name='".$post['add_category_name']."',page_tagline='".$post['add_category_tagline']."',page_url='".$pageUrl."',";
		$setFieldAdd  = "page_name='add new ".$post['add_category_name']."',page_url='add-new-".$pageUrl."',";
		$setFieldEdit = "page_name='edit ".$post['add_category_name']."',page_url='edit-".$pageUrl."',";
	}
	
	$setField 		= substr($setField,0,-1);
	$setFieldAdd 	= substr($setFieldAdd,0,-1);
	$setFieldEdit 	= substr($setFieldEdit,0,-1);
	
	//Get page ID
	$pageID	  	= $db->getOne("select page_id from ".$table_prefix."pages where category_id='".$post['catID']."'");
	$addPageID	= $db->getOne("select page_id from ".$table_prefix."pages where parent_id='".$pageID."' and page_switch='post_add'");
	$editPageID = $db->getOne("select page_id from ".$table_prefix."pages where parent_id='".$pageID."' and page_switch='post_edit'");
	
	//Update page
	$mainPage = "update ".$table_prefix."pages set ".$setField." where page_id='".$pageID."'";
	$addPage  = "update ".$table_prefix."pages set ".$setFieldAdd." where page_id='".$addPageID."'";
	$editPage = "update ".$table_prefix."pages set ".$setFieldEdit." where page_id='".$editPageID."'";
	
	$db->execute($mainPage);
	$db->execute($addPage);
	$db->execute($editPage);
	
	/* update parent category */
	$system->post->updateParentCategory();
}

/* cek before update */
$this->form->beforeUpdate('cek()');
function cek(){
	
	global $system;
	
	$error = false;
	$alert = '';
	
	if($system->site->isMultiLang()){
	
		foreach($system->site->lang() as $langID=>$langVal){
			
			@$sc .= '
			
				elseif(empty($_POST[\'add_category_name_'.$langID.'\'])){
					$error = true;
					$alert = "Category name '.strtoupper($langVal).' required.";
				}
			';
		}
	}
	else{
	
		@$sc = '
			
			elseif(empty($_POST[\'add_category_name\'])){
				$error = true;
				$alert = "Category name required.";
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
?>

<?$this->form->getForm('edit',$sqltable,$params,$formName='category',$submitValue='Update Category',$redirect,$resetBotton=false);?>