<?php if (!defined('basePath')) exit('No direct script access allowed');

$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$sqlCond   = $groupSessId!=1?'where group_id<>1':'where 1';

$sqltable 	= array(
	'table' 	=> $this->table_prefix.'user'
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
	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->text('User Name', 'add_username'),
	$this->form->input->password('Password', 'add_pass'),
	$this->form->input->select('User Group', 'add_group_id',$group),
	$this->form->input->text('Name', 'add_name'),
	$this->form->input->text('Email', 'add_email'),
	$this->form->input->html('<div class=" hidden-hr">'),
	$this->form->input->switchcheck('Active', 'add_active', $skin=3,$checked=true),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->getForm('add',$sqltable,$params,$formName='adduser',$submitValue='Add User',$finishButton=true);
?>