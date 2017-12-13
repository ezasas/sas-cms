<?php if (!defined('basePath')) exit('No direct script access allowed');

// Table Name
$postID   = !empty($xContentID)?$xContentID:intval($this->uri(3));
$sqltable = array(

	'table'	  => $this->table_prefix.'posts',
	'post_id' => $postID
);

$catName    = $this->site->isMultiLang()?'category_name_'.$this->active_lang():'category_name';
$arrCat 	= array(
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> $catName, 
		'cond' 	=> 'where category_type=\'post\''
	)
);


// create category tabs
$categoryTabs = '

	<ul class="nav nav-tabs">
		<li class="active" id="nav-tab-cat1"><a onclick="return categorytabs(\'cat1\')" href="#">Category</a></li>
		<li id="nav-tab-cat2"><a onclick="return categorytabs(\'cat2\')" href="#">Add New</a></li>
		<div class="clearfix"></div>
	</ul>
	
	<script>
		var activeCatTab = \'cat1\';
		function categorytabs(catID){		
			$("#nav-tab-"+activeCatTab).removeClass("active");
			$("#nav-tab-"+catID).addClass("active");
			$("#tab-cotent-"+activeCatTab).hide();
			$("#tab-cotent-"+catID).show();
			$("#tab-cotent-"+catID).css("visibility","visible");
			$("#tab-cotent-"+catID).css("height","auto");
			activeCatTab = catID;			
			return false;
		}
	</script>
';


// add new category
$arrCategory = $this->db->getAll("select category_id,category_name from cni_category where category_type='content'");
$arrOption	 = '';

foreach($arrCategory as $arr){

	extract($arr);	
	$arrOption .= '<option value="'.$category_id.'">'.$category_name.'</option>';
}

$selectParent = '<select id="parentCat" name="parentCat"><option value="0">Main Parent</option>'.$arrOption.'</select>';
$ajaxRequest  = modulePath.'content/admin/add.category.php';
$addNewCat 	  = '
	
	<div class="result"></div>
	<div class="input"><input id="new_category" type="text" name="new_category"></div>
	<div class="input">'.$selectParent.'</div>
	<div class="input"><a class="button" href="#" onclick="return addCategory();">Add to Category</a></div>
	
	<script>
		function addCategory(catID){
			$.ajax({
				type:"POST",
				url: ajaxURL+"'.$ajaxRequest.'",
				data: $.param({newCat:$("#new_category").val(),parent:$("#parentCat").val()}),
				success:function(data){	
					$(".result").html(data);				
				}
			});				
			return false;
		}
	</script>
';


// Define arr input
$checkbox 	= array('addcheck' => array('1' => 'Yes'));

$parent_id 	 = $this->db->getOne("select parent_id from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");
$category_id = $this->db->getOne("select category_id from ".$this->table_prefix."pages where page_id='".$parent_id."'");

$publisAccess = array(1,2,3,4);
$params = array();

$params[] = $this->form->input->html('<div class="row">');

/* post	*/
$params[] = $this->form->input->html('<div class="col-md-8 col-lg-9">');
$params[] = $this->form->input->html('<div class="box">');
$params[] = $this->form->input->html('<div class="box-body">');
$params[] = $this->form->input->html($this->langTabs());
$params[] = $this->form->input->text('Title', 'add_post_title',80, $multilang=true, $value='', $extra='class="form-control required"', $comment='');
$params[] = $this->form->input->textarea('Content Text', 'add_post_content',60,30,$editor=true, $multilang=true);	
$params[] = $this->form->input->textarea('Description', 'add_post_description',80,2,$editor=false,$multilang=true);
$params[] = $this->form->input->text('Tag', 'add_post_tag', 80, $multilang=false, $value='', $extra='id="page_name" class="form-control"', $comment=$this->lang('info_form_tag'));
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('<div class="col-md-4 col-lg-3">');

/* publish */
if(in_array($this->admin('group_id'),$publisAccess)){
	$params[] = $this->form->input->html('<div class="box">');
	$params[] = $this->form->input->html('<div class="box-header with-border">');
	$params[] = $this->form->input->html('<div class="widget-header">');
	$params[] = $this->form->input->html('<h4 class="widget-title">Publish</h4>');
	$params[] = $this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#publish" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('<div id="publish" class="box-body collapse in">');
	$params[] = $this->form->input->html('<div class="widget-main label-inline">');
	$params[] = $this->form->input->text('Author', 'add_posts_author',30,$multilang=false, $value='Admin');
	$params[] = $this->form->input->html('<div class=" hidden-hr">');
	$params[] = $this->form->input->switchcheck('Publish', 'add_publish',$type=2,$checked=true,$addClass='pull-right');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('<div class="space"></div>');
}
else{
	$params[] = $this->form->input->hidden('add_posts_author',$this->admin('name'));
}

/* category */
if($category_id==0){
	$params[] = $this->form->input->html('<div class="box">');		
	$params[] = $this->form->input->html('<div class="box-header with-border">');		
	$params[] = $this->form->input->html('<div class="widget-header">');			
	$params[] = $this->form->input->html('<h4 class="widget-title">Category</h4>');
	$params[] = $this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#category" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('<div id="category" class="box-body collapse in">');
	$params[] = $this->form->input->html('<div class="widget-main hidden-hr">');
	$params[] = $this->form->input->select('', 'add_post_category',$arrCat,$multiple=false);
	$params[] = $this->form->input->html('<div id="tab-cotent-cat1">');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('<div id="tab-cotent-cat2" style="visibility:hidden;height:0;">');
	$params[] = $this->form->input->html($addNewCat);
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('</div>');
	$params[] = $this->form->input->html('<div class="space"></div>');
}
else{
	$params[] = $this->form->input->hidden('add_post_category',$category_id);
}

/* image */
$params[] = $this->form->input->html('<div class="box">');
$params[] = $this->form->input->html('<div class="box-header with-border">');
$params[] = $this->form->input->html('<div class="widget-header">');			
$params[] = $this->form->input->html('<h4 class="widget-title">Featured Image</h4>');
$params[] = $this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#image" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('<div id="image" class="box-body collapse in">');
$params[] = $this->form->input->html('<div class="widget-main hidden-hr">');			
$params[] = $this->form->input->image('','add_post_image',uploadPath.'modules/posts/',uploadPath.'modules/posts/thumbs/','image');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('</div>');
$params[] = $this->form->input->html('</div>');

/* hidden */
$params[] = $this->form->input->hidden('add_post_type','post');
$params[] = $this->form->input->hidden('add_created_date',date('Y-m-d h:i:s'));

$this->form->onInsert('updateOnInsert($this->db,$post,$this->table_prefix)');
$this->form->onUpdate('updateOnUpdate($this->db,$post,$this->table_prefix,$tableID,$tableKey)');

function updateOnInsert($db,$post,$table_prefix){
	
	global $system;
	
	$postID = $db->insert_id();
	$db->execute("update ".$table_prefix."posts set posts_author_id='".$system->admin('id')."' where post_id='".$postID."'");
	if(isset($post['switchcheck']['add_publish']['value'])){

		$db->execute("update ".$table_prefix."posts set published_date='".date('Y-m-d h:i:s')."' where post_id='".$postID."'");
	}
	
	/* update parent category */
	$system->post->updateParentCategory($postID);
}
function updateOnUpdate($db,$post,$table_prefix,$tableID,$tableKey){
	
	global $system;
	
	if(isset($post['switchcheck']['add_publish']['value'])){

		$publishedDate = $db->getOne("select published_date from ".$table_prefix."posts where ".$tableID."='".$tableKey."'");
		
		if($publishedDate=='0000-00-00 00:00:00'){
		
			$db->execute("update ".$table_prefix."posts set published_date='".date('Y-m-d h:i:s')."' where ".$tableID."='".$tableKey."'");
		}
	}
	else{
		$db->execute("update ".$table_prefix."posts set published_date='0000-00-00 00:00:00' where ".$tableID."='".$tableKey."'");
	}
	
	/* update parent category */
	$system->post->updateParentCategory($tableKey);
}
?>