<?php if (!defined('basePath')) exit('No direct script access allowed');

/* Add/Edit URL */
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$addUrl		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='page_add' and parent_id='".$this->thisPageID()."'");
$editUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='page_edit' and parent_id='".$this->thisPageID()."'");

$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$type 		= empty($type)?'content':$type;
$tableName	= $this->table_prefix.'pages';
$parentID	= $this->uri(3)=='parent'?intval(@$this->uri(4)):0;
$parentID	= $this->uri(4)=='parent'?intval(@$this->uri(5)):$parentID;
$addSqlCond = $type=='content'?" and content_id<>'0'":" and content_id<>'0'";
$query		= "select * from ".$tableName." where parent_id='".$parentID."' and content_id<>'0' order by page_name";
$pageName   = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';

$breadcrumbNavContent 	= $this->breadcrumbPage($parentID);

$data = array(

	'Pages'  		=> $pageName.'.text..align="left"',
	'Admin Only' 	=> 'admin_only.checkbox..width="110".align="center"',
	'Publish'   	=> 'publish.checkbox..width="70".align="center"',
	'Edit'			=> 'id.edit.'.$editUrl
);

$this->data->onDelete('deleteMenu($this->db,$this->tablePrefix,$id)');

function deleteMenu($db,$tablePrefix,$id){
	
	$getSub  = $db->getAll("select page_id from ".$tablePrefix."pages where parent_id='".$id."'");
	
	foreach($getSub as $sub){		
		$db->execute("delete from ".$tablePrefix."pages where page_id='".$sub['page_id']."'");
	}
	
	$db->execute("delete from ".$tablePrefix."menu where page_id='".$id."'");
	
	//echo '<meta http-equiv="refresh" content="0">';
}

$this->data->addSearch($pageName);
$this->data->removeImage('content_image','modules/pages/');
$this->data->init($query,10,5);
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<?php echo $navMenu?>
			<div class="widget-toolbar">
				<a class="btn btn-sm btn-flat btn-info" href="<?php echo $this->adminURL().$addUrl?>/content<?php echo $this->permalink()?>?r=<?php echo base64_encode($this->thisURL());?>"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
	</div>	
	<div class="box-body">
		<div class="widget-main">
			<?php $this->data->getPage($tableName,'page_id',$data,$deleteButton=true,$savebutton=true,$formName='contentPage');?>
		</div>
	</div>
</div>
