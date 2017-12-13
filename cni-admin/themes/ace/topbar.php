<?php if(!defined('basePath')) exit('No direct script access allowed');

$arrMenuPosition = $this->menuPosition('admin');

if($this->adminMenu('top')!='' && in_array('top',$arrMenuPosition)){
	
	?>
	<div class="sidebar h-sidebar navbar-collapse collapse" id="sidebar" data-sidebar="true"><?=$this->adminMenu('top');?></div>
	<?
}
?>