<?php if (!defined('basePath')) exit('No direct script access allowed');

$pageID 	= $this->getSwitch()=='_page'?$this->thisPageID():intval($this->uri(3));
$contentID 	= $this->db->getOne("select content_id from ".$this->table_prefix."pages where page_id='".$pageID."'");
$parentID 	= $this->db->getOne("select parent_id from ".$this->table_prefix."pages where page_id='".$pageID."'");

if($contentID!=0){

	include 'pages.edit.content.php';
	
}
else{
	
	include 'pages.edit.application.php';
}
?>