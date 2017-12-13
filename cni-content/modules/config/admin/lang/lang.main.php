<?php if (!defined('basePath')) exit('No direct script access allowed');

//Update lang
if(isset($_POST['save_lang'])){

	$lang = array();

	$lang['ismulti'] 		= isset($_POST['ismulti'])?1:0;
	$lang['default_lang'] 	= $_POST['default_lang'];
	$lang['lang'] 			= $this->site->lang();
	$lang['icon'] 			= $this->site->lang_icon();
	
	$this->db->execute("update ".$this->table_prefix."config set lang ='".serialize($lang)."' where 1");
	
	/* redirect ke halaman yg sama utk bahasa yg baru diganti */
	$fieldName = 'page_url_'.$this->active_lang();
	$getPage = $this->db->getOne("select ".$fieldName." from ".$this->table_prefix."pages where page_id='".$_POST['pageID']."'");
	//header("location:".baseURL.$this->admin_name.'/'.$getPage);
}

$optionLang = '';


//Form
$defaultLang 	  = $this->site->default_lang();
$optionLangAdmin  = '';
$optionLangPublic = '';

foreach($this->site->lang() as $id=>$val){
	
	$selectedAdmin	   = $id==$defaultLang['admin']?' selected="true"':'';
	$selectedPublic    = $id==$defaultLang['public']?' selected="true"':'';
	$optionLangAdmin  .= '<option value="'.$id.'"'.$selectedAdmin.'>'.$val.'</option>';
	$optionLangPublic .= '<option value="'.$id.'"'.$selectedPublic.'>'.$val.'</option>';
}

?>

<form action="" method="post" class="">

	<div class="form-group"><label class="control-label">Publish</label>
		<div class="controls ">
			<div class="switch-box">
				<input class="ace ace-switch ace-switch-5" type="checkbox"<?=$this->site->isMultiLang()==1?' checked="checked"':'';?> value="0" name="ismulti">				
				<span class="lbl"></span>
			</div>
		</div>
	</div>
	<hr>
	<div class="form-group">
		<label class="control-label">Default language (admin)</label>
		<div class="controls">
			<select class="chosen-select form-control" name="default_lang[admin]">
				<?=$optionLangAdmin;?>
			</select>
		</div>
	</div>
	<hr>
	<div class="form-group">
		<label class="control-label">Default language (public)</label>
			<div class="controls">
			<select class="chosen-select form-control" name="default_lang[public]">
				<?=$optionLangPublic;?>
			</select>
		</div>
	</div>
	<hr>

	<div class="form-input-bottom form-actions">
		<button type="submit" id="save_lang" name="save_lang" class="btn btn-flat btn-primary"><i class="fa fa-save"></i>Save Changes</button>
	</div>
	
	<input type="hidden" name="pageID" value="<?=$this->thisPageID()?>">
	<input type="hidden" class="active_tab" name="active_tab" value="general">
	
</form>
