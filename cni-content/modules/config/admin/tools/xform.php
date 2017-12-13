<?php if (!defined('basePath')) exit('No direct script access allowed');

// Table Name
$sqltable 	= array(

	'table' => $this->table_prefix.'category'
);

$categoryName = $this->site->isMultiLang()?'category_name_'.$this->active_lang():'category_name';

/* select */
$arrOption = array(
	'addoption'	=> array(
		'0' => '--'
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> $categoryName,
		'cond' 	=> 'where 1'
	)
);

/* checkbox */
$arrCheck  = array(
	'addcheck'	=> array(
		'1' => 'Yes',
		'0' => 'No',
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> $categoryName,
		'cond' 	=> 'where 1'
	)
);

/* Radio */
$arrRadio  = array(

	'addRadio'	=> array(
		'1' => 'Yes',
		'0' => 'No'
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> $categoryName,
		'cond' 	=> 'where 1'
	)
);

// Define form field
$params	= array(

	$this->form->input->file('File', 'add_fieldname', @$path, $allowedTypes='image', $maxsize='', $comment='comment here')
	
);

/*

*/
$this->form->getForm('add',$sqltable,$params,$formName='category',$submitValue='Submit',$finishBotton=false,$resetBotton=false,$extra='class=""')
?>

<!-- shcore js -->
<script src="<?=$this->themeURL()?>assets/js/shcore/jquery.localscroll-1.2.7-min.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shCore.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushPhp.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushXML.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushJScript.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushCss.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/custom.js"></script>