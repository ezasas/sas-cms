<?if (!defined('basePath')) exit('No direct script access allowed');

$sqltable = array(
	'table'	=> $this->table_prefix.'config',
	'id'	=> 1
);

//Add lang
if(isset($_POST['add_lang'])){

	$langID 	= array();
	$lang 		= array();
	$errorAdd 	= '';

	foreach($this->site->lang() as $id=>$val){
	
		$langID[] 	 		= $id;
		$lang['lang'][$id] 	= $val;
	}
	foreach($this->site->lang_icon() as $id=>$val){
	
		$langID[] 	 		= $id;
		$lang['icon'][$id] 	= $val;
	}
	
	if(empty($_POST['lang_id'])){
	
		$errorAdd = 'Language ID is required';		
	}	
	elseif(empty($_POST['lang'])){
	
		$errorAdd = 'Language is required';		
	}
	elseif(in_array(@$_POST['lang_id'],$langID)){
	
		$errorAdd = 'Language ID already used';
	}
	else{
		$updateLang = array();
		
		$isMultiLang						= $this->site->isMultiLang()?1:0;
		$lang['ismulti'] 					= $isMultiLang;
		$lang['default_lang'] 				= $this->site->default_lang();
		$lang['lang'][$_POST['lang_id']]	= $_POST['lang'];
		$lang['icon'][$_POST['lang_id']]	= $_POST['icon'];
		
		$updateLang['ismulti'] 				= $lang['ismulti'];
		$updateLang['default_lang'] 		= $lang['default_lang'];
		$updateLang['lang'] 				= $lang['lang'];
		$updateLang['icon'] 				= $lang['icon'];
		
		$this->db->execute("update ".$this->table_prefix."config set lang ='".serialize($updateLang)."' where 1");
		
		$_POST = array();
	}
}

//listlang
if(isset($_POST['listlang'])){

	$langID 	= array();
	$lang 		= array();
	$errorAdd 	= '';
	$delID 		= $_POST['delID'];
	
	foreach($this->site->lang() as $id=>$val){
	
		if(!empty($id)){
		
			if($id!=$delID){
			
				$langID[] 	 		= $id;
				$lang['lang'][$id] 	= $val;
			}
		}
	}
	foreach($this->site->lang_icon() as $id=>$val){
	
		if(!empty($id)){
		
			if($id!=$delID){
			
				$langID[] 	 		= $id;
				$lang['icon'][$id] 	= $val;
			}
		}
	}
	
	if(empty($_POST['delID'])){
	
		$errorAdd = 'Language ID not found';		
		
	}
	else{
	
		$updateLang = array();
		
		$isMultiLang						= $this->site->isMultiLang()?1:0;
		$lang['ismulti'] 					= $isMultiLang;
		$lang['default_lang'] 				= $this->site->default_lang();
		//$lang['lang'][$_POST['lang_id']]	= $_POST['lang'];
		//$lang['icon'][$_POST['lang_id']]	= $_POST['icon'];
		
		$updateLang['ismulti'] 				= $lang['ismulti'];
		$updateLang['default_lang'] 		= $lang['default_lang'];
		$updateLang['lang'] 				= $lang['lang'];
		$updateLang['icon'] 				= $lang['icon'];
		
		$this->db->execute("update ".$this->table_prefix."config set lang ='".serialize($updateLang)."' where 1");
		
		$_POST = array();
	}
}


// listing lang
$getlang 	= $this->site->getLang();
$listlang 	= '';
$row 		= '';
$action 	= '';
$saveBtn 	= '';
$deleteBtn 	= '';
$formName 	= 'listlang';

foreach($getlang['lang'] as $langID=>$langName){

	$row   	.= '<tr>';
	$row   	.= '<td><label><span class="'.$getlang['icon'][$langID].'" id="flagicon"></span>&nbsp;<span class="lbl"></span>'.$langName.'</label></td>';
	$row   	.= '<td align="center"><strong class="blue">'.strtoupper($langID).'</strong></td>';
	$row   	.= '
				<td width="30" align="center">
					<form method="post" action="">
						<input type="hidden" name="delID" value="'.$langID.'"/>
						<input type="hidden" name="listlang" value="1"/>
						<button type="submit" onclick="if(!confirm(\''.$this->lang('delete_confirm').'\'))return false;" class="btn-transparent red"/><i class="fa fa-trash bigger-130"></i></button>
					</form>
				</td>
			   ';
	$row   	.= '</tr>';
}


$th = '

	<thead>
	<tr>
		<th align="left"><label>language<span class="lbl"></span></label></th>
		<th width="100"><label>language ID<span class="lbl"></span></label></th>
		<th><label>Option<span class="lbl"></span></label></th>
	</tr>
	</thead>
';

$listlang .= '<div class="dataTables_wrapper">';
$listlang .= '<table class="default grid table table-striped table-bordered table-hover dataTable">';
$listlang .= $th.$row;
$listlang .= '</table>';
$listlang .= '</div>';
?>


<div class="row">
	<div class="col-md-4 col-lg-3">
		<div class="box">
			<div class="box-header with-border">
				<div class="widget-header">
					<h4 class="widget-title">Add Language</h4>
				</div>
			</div>
			<div class="box-body">
				<div class="widget-main">
					<form action="" method="post">
					
						<?php echo @$errorAdd; ?>
						<div class="form-group">
							<label class="control-label">Language ID</label>
							<div class="controls">
								<input type="text" name="lang_id" value="<?=@$_POST['lang_id']?>" class="form-control">
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="control-label">Language</label>
							<div class="controls">
								<input type="text" name="lang" value="<?=@$_POST['lang']?>" class="form-control">
							</div>
						</div>
						<hr>						
						<div class="form-group">
							<label class="control-label">Icon</label>
							<div class="controls">
								<?php include_once(systemPath.'form/form.flag.php'); ?>
							</div>
						</div>
						<hr>		
						<div class="form-input-bottom form-actions">
							<button type="submit" id="add_lang" name="add_lang" class="btn btn-flat btn-primary">Add Language</button>
						</div>						
						<input type="hidden" class="active_tab" name="active_tab" value="add_lang">						
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8 col-lg-9">
		<div class="box">
			<div class="box-header with-border">
				<div class="widget-header">
					<h4 class="widget-title">Language List</h4>
				</div>
			</div>
			<div class="box-body">
				<div class="widget-main">
					<?php echo $listlang; ?>
				</div>
			</div>
		</div>
	</div>
</div>
