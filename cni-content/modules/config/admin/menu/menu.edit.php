<?if (!defined('basePath')) exit('No direct script access allowed');

$tableName 	= $this->table_prefix.'menu';
$refTable  	= $this->table_prefix.'pages';
$menuID 	= intval($this->uri(3));
$pageID 	= $this->db->getOne("select page_id from ".$tableName." where menu_id='".$menuID."'");

// Tabel Name
$sqltable 	= array(

	'table'		=> $this->table_prefix.'menu',
	'menu_id'	=> $menuID
);

// Init
$catID 		= $this->db->getOne("select category_id from ".$this->table_prefix."pages where page_id='".$pageID."'");
$publish  	= array('addcheck' => array('1' => 'Yes'));


if(!$this->site->isMultiLang()){

	$pageName 	= $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
	$pageName 	= $this->db->getOne("select ".$pageName." from ".$this->table_prefix."pages where page_id='".$pageID."'");

	// Pages
	$params = array(
		$this->form->input->html($this->langTabs()),
		$this->form->input->text('Label', 'page_name', $size=25, $multilang=true, $value=$pageName),
		$this->form->input->icon('', 'add_icon'),
		$this->form->input->hidden('add_publish',1)
	);

	// Category
	$categoryParams = array(
		$this->form->input->html($this->langTabs()),
		$this->form->input->text('Label', 'category_name', $size=25, $multilang=true, $value=$pageName),
		$this->form->input->hidden('category_id',$catID),
		$this->form->input->icon('', 'add_icon'),
		$this->form->input->hidden('add_publish',1)
	);

	// Custom Links
	$customParams = array(

		$this->form->input->text('Label', 'add_custom_title', $size=40),
		$this->form->input->text('URL', 'add_custom_url', $size=40, $multilang=false, $value='http://'),
		$this->form->input->icon('', 'add_icon'),
		$this->form->input->hidden('add_publish',1)
	);
}
else{

	// Pages
	$params[] = $this->form->input->html($this->langTabs());
	$params[] = $this->form->input->html('<div class="control-group">');
	
	foreach($this->site->lang() as $langID=>$langVal){
	
		$pageName = $this->db->getOne("select page_name_".$langID." from ".$this->table_prefix."pages where page_id='".$pageID."'");
		$display  = $langID==$this->active_lang()?'block':'none';
		$params[] = $this->form->input->html(
		
			'<div class="tab-'.$langID.'" style="display: '.$display.';">'.
			'<label class="control-label">Label '.$langVal.'</label>'.
			'<input type="text" size="25" value="'.$pageName.'" name="page_name_'.$langID.'" id="page_name-'.$langID.'" class="form-control">'.
			'</div>'
		);
	
	}
	
	$params[] = $this->form->input->html('</div><hr>');
	$params[] = $this->form->input->icon('', 'add_icon');
	$params[] = $this->form->input->hidden('add_publish',1);

	// Category
	$categoryParams[] = $this->form->input->html($this->langTabs());
	$categoryParams[] = $this->form->input->html('<div class="control-group">');
	
	foreach($this->site->lang() as $langID=>$langVal){
	
		$pageName = $this->db->getOne("select page_name_".$langID." from ".$this->table_prefix."pages where page_id='".$pageID."'");
		$display  = $langID==$this->active_lang()?'block':'none';
		$categoryParams[] = $this->form->input->html(
		
			'<div class="tab-'.$langID.'" style="display: '.$display.';">'.
			'<label class="control-label">Label '.$langVal.'</label>'.
			'<input type="text" size="25" value="'.$pageName.'" name="category_name_'.$langID.'" id="page_name-'.$langID.'" class="form-control">'.
			'</div>'
		);
	
	}

	// Custom Links
	$customParams = array(

		$this->form->input->text('Label', 'add_custom_title', $size=40),
		$this->form->input->text('URL', 'add_custom_url', $size=40, $multilang=false, $value='http://'),
		$this->form->input->icon('', 'add_icon'),
		$this->form->input->hidden('add_publish',1)
	);
	
	$categoryParams[] = $this->form->input->html('</div><hr>');
	$categoryParams[] = $this->form->input->hidden('category_id',$catID);
	$categoryParams[] = $this->form->input->icon('', 'add_icon');
	$categoryParams[] = $this->form->input->hidden('add_publish',1);
}

$this->form->onUpdate('updatePage($this->db,$post,$this->table_prefix,$tableKey)');

function updatePage($db,$post,$table_prefix,$tableKey){
	
	global $system;
	
	$pageID   = $db->getOne("select page_id from ".$table_prefix."menu where menu_id='".$tableKey."'");
	
	if(!$system->site->isMultiLang()){
	
		$pageName = '';
		
		if(isset($post['page_name'])){
			
			$pageName = anti_injection(htmlentities(str_replace('\\','\\\\',$post['page_name']),ENT_QUOTES));
		}
		elseif(isset($post['category_name'])){
			
			$pageName = anti_injection(htmlentities(str_replace('\\','\\\\',$post['category_name']),ENT_QUOTES));	
			
			$sqlCat = "update ".$table_prefix."category set category_name='".$pageName."' where category_id='".$post['category_id']."'";
			$db->execute($sqlCat);
		}
		
		if($pageName!=''){
		
			$pageUrl = seo_slug($pageName);
			$qryUrl	 = "select page_url from ".$table_prefix."pages where page_name='".$pageName."' and page_id<>'".$pageID."' order by page_url desc";
			$cUrl	 = $db->getOne("select page_url from ".$table_prefix."pages where page_url='".$pageUrl."' and page_id<>'".$pageID."'");
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
				$pageUrl	= $pageName.'-'.$lastSlug;
			}
			
			$sql = "update ".$table_prefix."pages set page_name='".$pageName."',page_url='".$pageUrl."' where page_id='".$pageID."'";
			$db->execute($sql);
			
			$rsChild = $db->getAll("select page_id, page_switch from ".$table_prefix."pages where parent_id='".$pageID."'");
			
			foreach($rsChild as $page){
				
				switch($page['page_switch']){
					
					case 'post_add':
						$setFieldAdd  = "page_name='add new ".$pageName."',page_url='add-new-".$pageUrl."'";
						$addPage  = "update ".$table_prefix."pages set ".$setFieldAdd." where page_id='".$page['page_id']."'";
						$db->execute($addPage);
					break;
					
					case 'post_edit':
						$setFieldEdit = "page_name='edit ".$pageName."',page_url='edit-".$pageUrl."'";
						$editPage = "update ".$table_prefix."pages set ".$setFieldEdit." where page_id='".$page['page_id']."'";
						$db->execute($editPage);
					break;
				}
			}
		}
	}
	else{	
		
		foreach($system->site->lang() as $langID=>$langVal){
		
			$pageName = '';
		
			if(isset($post['page_name_'.$langID])){
				
				$pageName = anti_injection(htmlentities(str_replace('\\','\\\\',$post['page_name_'].$langID),ENT_QUOTES));	
			}
			elseif(isset($post['category_name_'.$langID])){
				
				$pageName = anti_injection(htmlentities(str_replace('\\','\\\\',$post['page_name_'].$langID),ENT_QUOTES));	
				
				$sqlCat = "update ".$table_prefix."category set category_name_".$langID."='".$pageName."' where category_id='".$post['category_id']."'";
				$db->execute($sqlCat);
			}
			
			if($pageName!=''){
			
				$pageUrl = seo_slug($pageName);
				$qryUrl	 = "select page_url from ".$table_prefix."pages where page_name_".$langID."='".$pageName."' and page_id<>'".$pageID."' order by page_url desc";
				$cUrl	 = $db->getOne("select page_url_".$langID." from ".$table_prefix."pages where page_url_".$langID."='".$pageUrl."' and page_id<>'".$pageID."'");
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
					$pageUrl	= $pageName.'-'.$lastSlug;
				}
				
				$sql = "update ".$table_prefix."pages set page_name_".$langID."='".$pageName."',page_url_".$langID."='".$pageUrl."' where page_id='".$pageID."'";
				$db->execute($sql);
				
				$rsChild = $db->getAll("select page_id, page_switch from ".$table_prefix."pages where parent_id='".$pageID."'");
			
				foreach($rsChild as $page){
					
					switch($page['page_switch']){
						
						case 'post_add':
							$setFieldAdd  = "page_name_".$langID."='add new ".$pageName."',page_url_".$langID."='add-new-".$pageUrl."'";
							$addPage  = "update ".$table_prefix."pages set ".$setFieldAdd." where page_id='".$page['page_id']."'";
							$db->execute($addPage);
						break;
						
						case 'post_edit':
							$setFieldEdit = "page_name_".$langID."='edit ".$pageName."',page_url_".$langID."='edit-".$pageUrl."'";
							$editPage = "update ".$table_prefix."pages set ".$setFieldEdit." where page_id='".$page['page_id']."'";
							$db->execute($editPage);
						break;
					}
				}
			}
		}
	}
}
$this->form->beforeUpdate('cek()');

function cek(){
	
	global $system;
	
	$error = false;
	$alert = '';
	
	if($system->site->isMultiLang()){
	
		foreach($system->site->lang() as $langID=>$langVal){
			
			@$sc .= '
			
				elseif(empty($_POST[\'category_name_'.$langID.'\']) && empty($_POST[\'page_name_'.$langID.'\']) && empty($_POST[\'add_custom_title'.$langID.'\'])){
					$error = true;
					$alert = "Label '.strtoupper($langVal).' cannot be empty.";
				}
			';
		}
	}
	else{
	
		@$sc = '
			
			elseif(empty($_POST[\'category_name\']) && empty($_POST[\'page_name\']) && empty($_POST[\'add_custom_title\'])){
				$error = true;
				$alert = "Label cannot be empty.";
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

if($pageID==0){
	$this->form->getForm('edit',$sqltable,$customParams,$formName='customlink',$submitValue='Update menu',$finishButton=true);
}
else{
	
	$categoryID = $this->db->getOne("select category_id from ".$this->table_prefix."pages where page_id='".$pageID."'");
	?>
	<div class="box">
		<div class="box-body">
			<div class="widget-main">
				<?php
				if($categoryID!='0'){
					$this->form->getForm('edit',$sqltable,$categoryParams,$formName='pages',$submitValue='Update menu',$finishButton=true);
				}
				else{
					$this->form->getForm('edit',$sqltable,$params,$formName='pages',$submitValue='Update Menu',$finishButton=true);
				}
				?>
			</div>
		</div>	
	</div>
	<?php
}
?>