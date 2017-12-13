<?php if (!defined('basePath')) exit('No direct script access allowed');

$tableName	= $this->table_prefix.'category';
$parentID 	= !$this->uri(4)?0:intval($this->uri(4));
$parentID 	= @$this->uri(3)=='parent'?$parentID:0;
//$editUrl 	= 'edit-category';
$query		= "select * from ".$tableName." where category_type='post' and parent_id='".$parentID."' order by category_name";
$pageName   = $this->site->isMultiLang()?'category_name_'.$this->active_lang():'category_name';
$data 		= array(

	'Name' 			=> 'category_name.custom.pageName..style="text-align:left"',
	'Parent' 		=> 'parent_id.select.refTable:'.$this->table_prefix.'category where category_type=\'post\',category_name(category_id).width="180"',
	#'Sub Category' 	=> 'parent_id.custom.viewSub',
	'Edit'			=> 'id.edit.'.$editUrl
);
function pageName($data,$params){

global $system;
	$name	  = 'category_name_'.$system->active_lang();
	$pageName = !empty($data[$name])?$data[$name]:$data['category_name'];
	
	return strDecode($pageName);
}

/* On delete */
$this->data->onUpdate('updatePage()');
function updatePage(){
	
	global $system;
	
	/* update parent category */
	$system->post->updateParentCategory();
}

/* On delete */
$this->data->onDelete('deletePage($this->db,$this->tablePrefix,$id)');
function deletePage($db,$tablePrefix,$id){
	
	$delPages  = array();
	$pageID    = $db->getOne("select page_id from ".$tablePrefix."pages where category_id='".$id."'");
	$pageChild = !empty($pageID)?$db->getAll("select page_id from ".$tablePrefix."pages where parent_id='".$pageID."'"):array();
	
	$delPages[] = $pageID;	
	
	foreach($pageChild as $page){
	
		$delPages[] = $page['page_id'];	
	}

	foreach($delPages as $delID){
		
		$db->execute("delete from ".$tablePrefix."pages where page_id='".$delID."'");
		$menuID = $db->getOne("select menu_id from ".$tablePrefix."menu where page_id='".$delID."'");
		
		if(!empty($menuID)){
			$db->execute("delete from ".$tablePrefix."menu where menu_id='".$menuID."'");
		}
	}
}

$this->data->addSearch('category_name');
$this->data->init($query,10,5);
$this->data->getPage($tableName,'category_id',$data,$deleteButton=true,$savebutton=true,$formName='form',$addHtml='',$static=false);
?>