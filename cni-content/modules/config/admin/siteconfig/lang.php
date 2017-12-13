<?if (!defined('basePath')) exit('No direct script access allowed');

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
	
		$errorAdd = 'Language ID alreadey used';
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


//Update lang
if(isset($_POST['save_lang'])){

	$lang = array();

	$lang['ismulti'] 		= isset($_POST['ismulti'])?1:0;
	$lang['default_lang'] 	= $_POST['default_lang'];
	$lang['lang'] 			= $this->site->lang();
	$lang['icon'] 			= $this->site->lang_icon();
	
	$this->db->execute("update ".$this->table_prefix."config set lang ='".serialize($lang)."' where 1");
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


<h3>Config</h3>
<form action="" method="post">

	<div class="form-input">

		<p class="inputCheckbox">
			<label>Multi language</label>
			<input type="checkbox" class="chk" name="ismulti" value="0" <?=$this->site->isMultiLang()==1?' checked="checked"':'';?>/>
			<label class="lbl"> Yes</label>
		</p>
		<p>
			<label>Default language (admin)</label>
			<select class="text" name="default_lang[admin]">
				<?=$optionLangAdmin;?>
			</select>
		</p>
		
		<p>
			<label>Default language (public)</label>
			<select class="text" name="default_lang[public]">
				<?=$optionLangPublic;?>
			</select>
		</p>
		
		<p>
			<label>Default language (public)</label>
			<select class="" name="tes">
				<option value="1">tes 1</option>
				<option value="2">tes 2</option>
				<option value="3">tes 3</option>
			</select>
		</p>
		
	</div>

	<div class="form-input-bottom">
		<input type="submit" id="save_lang" name="save_lang" value="Save" class="btn btn-small btn-primary">
	</div>
	
</form>

<h3>Add Language</h3>
<form action="" method="post">
	<?=@$errorAdd;?>
	<div class="form-input">

		<p>
			<label>Language ID</label>
			<input type="text" name="lang_id" value="<?=@$_POST['lang_id']?>">
		</p>
		
		<p>
			<label>Language</label>
			<input type="text" name="lang" value="<?=@$_POST['lang']?>">
		</p>
		
		<p>
			<label>Icon</label>
			<?php include_once(systemPath.'form/form.flag.php'); ?>
		</p>
		
	</div>

	<div class="form-input-bottom">
		<input type="submit" id="add_lang" name="add_lang" value="Add Language" class="btn btn-small btn-primary">
	</div>
	
</form>
