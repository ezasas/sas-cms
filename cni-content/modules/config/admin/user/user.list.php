<?php if (!defined('basePath')) exit('No direct script access allowed');

/* Add/Edit URL */
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$addUrl		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='user_add' and parent_id='".$this->thisPageID()."'");
$editUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='user_edit' and parent_id='".$this->thisPageID()."'");

$addUrl 	 = $this->adminURL().$addUrl.$this->permalink().'?r='.base64_encode($this->thisURL());
$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$tablename = $this->table_prefix.'user';
$sqlCond   = $groupSessId!=1?" where group_id<>1":"";
$query	   = 'select * from '.$tablename.$sqlCond;
$data 	   = array(

	'UserName' 	 => 'username.text',
	'Name' 		 => 'name.text',
	'Email' 	 => 'email.text',
	'User Group' => 'group_id.select.refTable:'.$this->table_prefix.'user_group '.$sqlCond.',name(group_id) .width="40".',
	'Active'	 => 'active.switchcheck..width="60".align="center"',
	'Edit'		 => 'id.edit.'.$editUrl,
	'Delete'	 => 'id.delete'
);

$this->data->addSearch('username,name,email');
$this->data->init($query);
?>

<div class="box">	
	<div class="box-header">			
		<div class="widget-header">	
			<span class="widget-toolbar">
				<a href="<?php echo $addUrl?>" class="btn btn-sm btn-flat btn-info"><i class="fa fa-plus"></i> Add New</a>
			</span>
		</div>					
	</div>	
	<?$this->data->getPage($tablename,'id',$data);?>
</div>