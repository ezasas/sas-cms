<?php if (!defined('basePath')) exit('No direct script access allowed');

$sqltable = array(

	'table' => $this->table_prefix.'user',
	'id'	=> $this->admin('id')
);

$group = array(
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'user_group',
		'id' 	=> 'group_id', 
		'field'	=> 'name', 
		'cond' 	=> 'where 1'
	)
);

$active 	= array('addcheck' => array('1' => 'Yes'));

$params = array(
	
	$this->form->input->html('<div class="widget-content">'),
	$this->form->input->html('<div class="image-holder">'),
	$this->form->input->image('Profil Picture','add_image',uploadPath.'modules/user/',uploadPath.'modules/user/thumbs/','image'),
	$this->form->input->html('</div>'),
	$this->form->input->text('Name', 'add_name'),
	$this->form->input->text('Email', 'add_email'),
	$this->form->input->html('</div>')
);

$this->form->beforeUpdate('cek()');

function cek(){
	
	$error = false;
	$alert = '';
	
	@$sc = '
		elseif(!validateEmail($_POST[\'add_email\'])){
			$error = true;
			$alert = "Email tidak valid.";
		}
	';
	
	$sc = substr(trim($sc),4);
	
	eval($sc);
	$response = array(
		
		'error' => $error,
		'alert' => $alert
	);
	
	return $response;	
}
?>

<div class="widget-container">

	<? $this->form->getForm('edit',$sqltable,$params,$formName='edituser',$submitValue='Save Changes');?>
	
</div>