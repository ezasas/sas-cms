<?php if (!defined('basePath')) exit('No direct script access allowed');

// Get Parent
$parentID 		= $this->uri(3);
$breadcrumbCat	= $this->breadcrumbCategory($parentID);

// Table Name
$sqltable 	= array(

	'table' => $this->table_prefix.'category'
);

// Define form field
$params	= array(
	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->html($this->langTabs()),
	/* $this->form->input->image('Default Image','add_category_image',uploadPath.'modules/category/',uploadPath.'modules/category/thumbs/','image'), */
	$this->form->input->text('Name', 'add_category_name',80, $multilang=true),
	$this->form->input->text('Tagline', 'add_category_tagline', 80, $multilang=true),
	$this->form->input->html('<div class="hidden-hr">'),
	$this->form->input->textarea('Description','add_category_description',30,3,$editor=false, $multilang=true),
	$this->form->input->hidden('add_parent_id', $parentID),
	$this->form->input->hidden('add_category_type', 'post'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

// On insert add to page
$this->form->onInsert('addToPage($this->db,$post,$this->table_prefix,$this->isMultiLang,$this->lang,$this->user)');

function addToPage($db,$post,$table_prefix,$isMultiLang,$lang,$user){
	
	global $system;
	
	$categoryID = $db->insert_id();
	
	//get permission
	$groupID	= $_SESSION['admin']['group_id'];
	$getAccess  = $user->getPermission($groupID);
	
	foreach($getAccess as $permission){
		$setPermission[] = $permission;		
	}
	
	// is Multilang
	if($isMultiLang){
	
		foreach($lang as $langID=>$langVal){
			
			$categoryName = $post['add_category_name_'.$langID];
			$pageUrl 	  = seo_slug($categoryName);
			$qryUrl	 	  = "select page_url_".$langID." from ".$table_prefix."pages where page_name_".$langID."='".$categoryName."' order by page_url_".$langID." desc";
			$cUrl	 	  = $db->getOne("select page_url_".$langID." from ".$table_prefix."pages where page_url_".$langID."='".$pageUrl."'");
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
				$pageUrl	= $categoryName.'-'.$lastSlug;
				$pageUrl	= seo_slug($pageUrl);
			}
			
			@$setField 	   .= "page_name_".$langID."='".$categoryName."',page_tagline_".$langID."='".$post['add_category_tagline_'.$langID]."',page_url_".$langID."='".$pageUrl."',";
			@$setFieldAdd  .= "page_name_".$langID."='add new ".$categoryName."',page_url_".$langID."='add-new-".$pageUrl."',";
			@$setFieldEdit .= "page_name_".$langID."='edit ".$categoryName."',page_url_".$langID."='edit-".$pageUrl."',";	
		}
	}
	else{
		$pageUrl = seo_slug($post['add_category_name']);
		$qryUrl	 = "select page_url from ".$table_prefix."pages where page_name='".$post['add_category_name']."' order by page_url desc";
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
			$pageUrl	= $post['add_category_name'].'-'.$lastSlug;
		}
		
		$setField 	  = "page_name='".$post['add_category_name']."',page_tagline='".$post['add_category_tagline']."',page_url='".$pageUrl."',";
		$setFieldAdd  = "page_name='add new ".$post['add_category_name']."',page_url='add-new-".$pageUrl."',";
		$setFieldEdit = "page_name='edit ".$post['add_category_name']."',page_url='edit-".$pageUrl."',";
	}	
	
	//Add to page
	$postID   = $db->getOne("select module_id from ".$table_prefix."modules where module_name='posts'");
	$mainPage = "insert into ".$table_prefix."pages set module_id='".$postID."', ".$setField." category_id='".$categoryID."', publish='1'";
	$db->execute($mainPage);
	$parentID = $db->insert_id();
	
	//Set permission parent
	$setPermission[] = $parentID;	
	$db->execute("update ".$table_prefix."user_group set access='".serialize($setPermission)."' where group_id='".$groupID."'");	
	
	$addPage  = "insert into ".$table_prefix."pages set parent_id='".$parentID."', module_id='".$postID."', ".$setFieldAdd." page_switch='post_add'";
	$editPage = "insert into ".$table_prefix."pages set parent_id='".$parentID."', module_id='".$postID."', ".$setFieldEdit." page_switch='post_edit'";
	
	//Insert Add Page
	$db->execute($addPage);
	
	//Set perpission add page
	$setPermission[] = $db->insert_id();	
	$db->execute("update ".$table_prefix."user_group set access='".serialize($setPermission)."' where group_id='".$groupID."'");
	
	//Insert Edit Page
	$db->execute($editPage);
	
	//Set perpission edit page
	$setPermission[] = $db->insert_id();	
	$db->execute("update ".$table_prefix."user_group set access='".serialize($setPermission)."' where group_id='".$groupID."'");
}

/* cek before insert */
$this->form->beforeInsert('cek()');
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

<?$this->form->getForm('add',$sqltable,$params,$formName='category',$submitValue='Add Category',true); ?>