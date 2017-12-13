<?php if (!defined('basePath')) exit('No direct script access allowed');

$sqltable 	= array(

	'table'		=> $this->table_prefix.'pages',
	'page_id'	=> $pageID
);	

// Get Parent Page
$pageName   = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
$queryPage 		= "select page_id,".$pageName." as pagemulti, page_name from ".$this->table_prefix."pages where content_id='0' and page_id<>'".$pageID."' order by page_name";
$getArrpage 	= $this->db->getAll($queryPage);
$parentOption 	= array();
$menuName		= '';
$parentOption 	= '<option value="0">--</option>';

foreach($getArrpage as $k=>$v){
	
	extract($v);
	
	$parID			= isset($_POST['parent_id'])?$_POST['parent_id']:$parentID;
	$parentSelected	= $parID==$page_id?' selected="true"':'';	
	if(empty($page_name)){
		@$page_name=$pagemulti;
	}
	$parentOption  .= '<option value="'.$page_id.'"'.$parentSelected.'>'.$page_name.'</option>';
}

$parent = '<select name="add_parent_id" class="chosen-select form-control">'.$parentOption.'</select>';


//modules
$modules = array(
	'addoption'	=> array(
		'' => '--'
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'modules',
		'id' 	=> 'module_id', 
		'field'	=> 'module_name'
	)
);


// Define arr input

$cParams = array(
	$this->form->input->html('<div class="box">'),
	$this->form->input->html($this->langTabs()),
	$this->form->input->html('<div class="box-header with-border">'),
	$this->form->input->html('<div class="widget-header">'),
	$this->form->input->html('<h4 class="widget-title">Application Page</h4>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->text('Page Name', 'add_page_name', 80, $multilang=true, $value='', $extra='id="page_name" class="form-control" onkeyup="createUrl(this.value,\'langID\')"'),
	$this->form->input->text('Tagline', 'add_page_tagline', 80, $multilang=true),
	$this->form->input->html('<div class="form-group"><label class="control-label">Parent</label><div class="controls">'.$parent.'</div></div><hr>'),
	$this->form->input->select('Module', 'add_module_id',$modules),
	$this->form->input->text('Switch Page', 'add_page_switch',30, $multilang=false,$value='','class="form-control"'),
	$this->form->input->text('Slug Url', 'add_page_url',80, $multilang=true, $value='', $extra='id="add_page_url" class="form-control"'),
	$this->form->input->html('<div class="hidden-hr">'),
	$this->form->input->switchcheck('Publish', 'add_publish', $skin=5),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->onUpdate('updateTbl($this->db,$post,$this->table_prefix,$tableKey)');

function updateTbl($db,$post,$table_prefix,$tableKey){
	
	global $system;
	
	$pageID = $tableKey;
	if(!$system->site->isMultiLang()){
	
		$pageName = anti_injection(htmlentities(str_replace('\\','\\\\',$post['add_page_name']),ENT_QUOTES));
		
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
			
			$pageName = anti_injection(htmlentities(str_replace('\\','\\\\',$post['add_page_name_'.$langID]),ENT_QUOTES));
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

$this->form->getForm('edit',$sqltable,$cParams,$formName='application',$submitValue='Update Page',$finishButton=true,$resetBotton=false,$extra='class="form-horizontal"');
?>


<!--- Script --->
<script type="text/javascript">
	
	function createUrl(str,langID){
		var url 	= seoUrl(str);
		var pageUrl = 'add_page_url';
		
		if(langID!='langID'){
			pageUrl = pageUrl+'-'+langID;
		}

		$("#"+pageUrl).val(url);
	}
	
	function seoUrl(str){
		
		var url = $.trim(str);
		
		url = url.replace(/\s+/g,' ');
		url = url.toLowerCase();
		url = url.replace(/\W/g, ' ');
		url = $.trim(url);
		url = url.replace(/\s+/g, '-');
		
		return url;
	}
	
</script>