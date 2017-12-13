<?php if (!defined('basePath')) exit('No direct script access allowed');

$groupName = $this->db->execute("select group_id from ".$this->table_prefix."user_group where name='".$_POST['add_name']."'");
$error 	   = true;
$errorMsg  = '';

if(empty($_POST['add_name'])){
	$errorMsg = 'group name is required';
}
elseif($groupName->RecordCount()>0){
	$errorMsg = 'group name already exists';
}
else{
	$addQuery = "insert into ".$this->table_prefix."user_group set name='".$_POST['add_name']."'";
	
	if($this->db->execute($addQuery)){
		$error 	  = false;
	}
	else{
		$errorMsg = 'Unable to add new group, please try again later';
	}
}

$response = array(
	
	'error'		=> $error,
	'errorMsg'	=> $errorMsg
);

echo json_encode($response);