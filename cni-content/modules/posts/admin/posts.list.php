<?php if (!defined('basePath')) exit('No direct script access allowed');

$publisAccess = array(1,2,3,4);
$userCond = '';
if(!in_array($this->admin('group_id'),$publisAccess)){
	$userCond = " and posts_author_id='".$this->admin('id')."'";
}

$sqlCond = '';
if($this->_GET('year') && $this->_GET('year')!='any'){
	$sqlCond .= " and date_format(created_date,'%Y')='".$this->_GET('year')."' ";
}
if($this->_GET('month') && $this->_GET('month')!='any'){
	$sqlCond .= " and date_format(created_date,'%m')='".$this->_GET('month')."' ";
}

$tableName	= $this->table_prefix.'posts';
$fTitle   	= $this->site->isMultiLang()?'post_title_'.$this->active_lang():'post_title';

$addWhere	= $categoryID !='0'?" and post_category like'%".$categoryID."%'":"";
$addWhere  .= $userCond.$sqlCond;
$query		= "select post_id,".$fTitle.",posts_author,created_date,published_date,publish from ".$tableName." where post_type='post'".$addWhere." order by post_id desc";

/* Add URL */
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$addUrl		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='post_add' and parent_id='".$this->thisPageID()."'");


/* Edit URL */
$addUrl 	= $this->adminUrl().''.$addUrl.$this->permalink().'?r='.base64_encode($this->thisUrl());
$editUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='post_edit' and parent_id='".$this->thisPageID()."'");

$data 		= array();

$data['Judul'] = $fTitle.'.text..style="text-align:left"';
$data['Oleh'] = 'posts_author.text..width="150"';
$data['Tgl Upload'] = 'created_date.custom.created..width="130"';
	
if(in_array($this->admin('group_id'),$publisAccess)){
	$data['Tgl Publish'] ='published_date.custom.published..width="130"';
	$data['Publish'] = 'publish.switchcheck..width="60".align="center"';
	$data['Edit'] = 'id.edit.'.$editUrl;
}
else{
	$data['Publish'] ='published_date.custom.published..width="200"';
}

function created($data){
	
	global $system;
	
	$publish = get_date($data['created_date'],$system->lang('month'),$system->lang('day'),$setDay=false,$setTime=false);
	$publish = '<div class="post-date">'.$publish.'</div>';
	return $publish;
}
function published($data){
	
	global $system;

	$notapproved  	= '<span class="label label-warning  arrowed">Not Published</span>';
	$published 		= get_date($data['published_date'],$system->lang('month'),$system->lang('day'),$setDay=false,$setTime=false);
	$published 		= $data['published_date']=='0000-00-00 00:00:00'?$notapproved:$published;
	
	return $published;
}

/* update post */
$this->data->onUpdate('UpdatePost($this->db,$this->tablePrefix,$id)');
function UpdatePost($db,$tablePrefix,$id){
	
	if(isset($_POST['checkbox'][$id]['publish'])){
		
		$publishedDate = $db->getOne("select published_date from ".$tablePrefix."posts where post_id='".$id."'");
		
		if($publishedDate=='0000-00-00 00:00:00'){
		
			$db->execute("update ".$tablePrefix."posts set published_date='".date('Y-m-d h:i:s')."' where post_id='".$id."'");
		}
	}
	else{
	
		$db->execute("update ".$tablePrefix."posts set published_date='0000-00-00 00:00:00' where post_id='".$id."'");
	}
}

$this->data->addSearch('post_title');
$this->data->removeImage('post_image','modules/posts/');
$this->data->init($query,10,5);

/* Filter Year */
$years = $this->db->getAll("select distinct date_format(created_date,'%Y') as created_date from ".$this->table_prefix."posts where date_format(created_date,'%Y')!='0000' order by created_date asc");

$xYear = @$this->_GET('year');
$setActive = empty($xYear)?'any':$xYear;

$filterYear = '<select name="year" onchange="this.form.submit()" class="select2 form-control">';
$filterYear .= '<option value="any">All Year</option>';

foreach($years as $vYear){
	
	$activeClass = $vYear['created_date'] == $setActive?' selected="true"':'';
	$filterYear .= '<option value="'.$vYear['created_date'].'"'.$activeClass.'>'.$vYear['created_date'].'</option>';
}
$filterYear .= '</select>';

/* Filter month */
$xMonth = @$this->_GET('month');
$setActive = empty($xMonth)?'any':$xMonth;
$filterMonth = '<select name="month" onchange="this.form.submit()" class="select2 form-control">';
$filterMonth .= '<option value="any">All Month</option>';

foreach($this->lang('month') as $kMonth => $vMonth){
	
	$kMonth ++;
	$kMonth = str_pad($kMonth, 2, '0', STR_PAD_LEFT);
	$activeClass = $kMonth == $setActive?' selected="true"':'';
	$filterMonth .= '<option value="'.$kMonth.'"'.$activeClass.'>'.$vMonth.'</option>';
}
$filterMonth .= '</select>';
?>

<div class="box">	
	<div class="box-header with-border">			
		<div class="widget-header">
			<form name="frm-filter" class="form-inline" method="get">
				<div class="form-group">
					<label for="exampleInputName2">Filter</label>
					<?php echo $filterYear ?>
					<?php echo $filterMonth ?>
				</div>
			</form>
			<span class="widget-toolbar">
			<a href="<?php echo $addUrl?>" class="btn btn-sm btn-flat btn-info"><i class="ace-icon fa fa-plus"></i> Add New</a>
			</span>
		</div>					
	</div>	
	<?php
	if(in_array($this->admin('group_id'),$publisAccess)){
		$this->data->getPage($tableName,'post_id',$data);
	}
	else{
		$this->data->getPage($tableName,'post_id',$data,$deleteButton=false,$savebutton=false,$formName='form',$addHtml='',$static=true);
	}
	?>
</div>