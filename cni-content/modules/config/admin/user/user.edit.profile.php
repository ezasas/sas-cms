<?php if (!defined('basePath')) exit('No direct script access allowed');

$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$sqlCond   = $groupSessId!=1?'where group_id<>1':'where 1';

$userID 	= intval(@$this->uri(3));

$sqltable = array(

	'table' => $this->table_prefix.'user',
	'id'	=> $userID
);

$group = array(
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'user_group',
		'id' 	=> 'group_id', 
		'field'	=> 'name', 
		'cond' 	=> $sqlCond
	)
);
$active 	= array('addcheck' => array('1' => 'Yes'));

$params = array(

	$this->form->input->text('User Name', 'add_username'),
	$this->form->input->select('User Group', 'add_group_id',$group),
	$this->form->input->text('Name', 'add_name'),
	$this->form->input->text('Email', 'add_email'),
	$this->form->input->switchcheck('Active', 'add_active', $skin=3,$checked=true)
);

$this->form->beforeInsert('cek()');
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

$this->form->getForm('edit',$sqltable,$params,$formName='edituser',$submitValue='Save Changes',$finishButton=true);
?>