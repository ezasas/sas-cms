<? if (!defined('basePath')) exit('No direct script access allowed');

$sqltable 	= array(

	'table'		=> $this->table_prefix.'pages',
	'page_id'	=> $this->uri(3)
);


// Get Parent Menu
$queryPage 		= "select page_id, page_name from ".$this->table_prefix."pages where content_id='0' order by page_name";
$getArrpage 	= $this->db->getAll($queryPage);
$parentOption 	= array();
$menuName		= '';

$parentOption[0] = '--';

foreach($getArrpage as $k=>$v){
	
	extract($v);
	$parentOption[$page_id] = $page_name;
}

$parent = array('addoption'	=> $parentOption);
$pageName 	 = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
//parent
$getParent = array(
	'addoption'	=> array(
		'' => '--'
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'pages',
		'id' 	=> 'page_id',
		'field'	=> $pageName,
		'cond'	=> 'where content_id=\'0\' and publish=\'1\''
	)
);

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
	$this->form->input->html('<div class="alert-msg"></div>'),
	$this->form->input->html($this->langTabs()),
	$this->form->input->html('<div class="box-header with-border">'),
	$this->form->input->html('<div class="widget-header">'),
	$this->form->input->html('<h4 class="widget-title">Application Page</h4>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->text('Page Name', 'add_page_name', 80, $multilang=true, $value='', $extra='id="page_name" class="form-control" onkeyup="createUrl(this.value,\'langID\')"', $comment=''),
	$this->form->input->text('Tagline', 'add_page_tagline', 80, $multilang=true),
	$this->form->input->select('Parent', 'add_parent_id',$getParent),
	$this->form->input->select('Module', 'add_module_id',$modules),
	$this->form->input->text('Switch Page', 'add_page_switch',30, $multilang=false, $value='', $extra='class="form-control"'),
	$this->form->input->text('Slug Url', 'add_page_url',80, $multilang=true, $value='', $extra='id="add_page_url" class="form-control"', $comment=''),
	$this->form->input->html('<div class="hidden-hr">'),
	$this->form->input->switchcheck('Publish', 'add_publish', $skin=5,$checked=false),
	$this->form->input->hidden('action','add'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->onInsert('updateTbl($this->db,$this->table_prefix,$post,$tableName,$this->isMultiLang,$this->lang,$this->user)');
	
function updateTbl($db,$table_prefix,$post,$tableName,$isMultiLang,$lang,$user){
	
}
?>

<?php $this->form->getForm('add',$sqltable,$cParams,$formName='application','Add Page',$finishButton=true,$resetBotton=false,$extra='class="form-horizontal"');?>



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
	
	/* Cek Page Name */
	/*
	$('#addApplication').live("submit",function(){
	
		var postUrl  = ajaxURL+"<?=modulePath?>config/admin/pages/pages.ajax.checkname.php";
		
		$('.alert-msg').html('');
		
		var wedus;
		
		$.ajax({
			type: 'POST',
			url: postUrl,
			data: $(this).serialize(),
			dataType: 'json',
			success: function(data) {
				if(data.allowed){
					wedus = 'a';
				}
				else{
					$('.alert-msg').html(
						'<div class="alert alert-error">'+
							'<button data-dismiss="alert" class="close" type="button">×</button>'+
							'<strong>'+
								'<i class="icon-exclamation-sign"></i> Warning!'+
							'</strong>'+
							' Page name already exist'+
							'<br>'+
						'</div>'+
						'<div class="space"></div>'
					);
					wedus = 'b';
				}
			}
		});
		
		alert(wedus);
		return false;
	});
	*/
</script>