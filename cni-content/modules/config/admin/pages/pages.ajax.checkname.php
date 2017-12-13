<?php if (!defined('basePath')) exit('No direct script access allowed');

#$addWhere = @$_POST['action']=='add'?'':'';
$query	  = "select page_id from ".$this->table_prefix."pages where page_name='".$_POST['add_page_name']."'";
$getName  = $this->db->execute($query);
$allowed  = $getName->recordCount()>0?false:true;
$msg	  = '';

$response = array(
	'allowed'	=> $allowed
);

echo json_encode($response);
?>