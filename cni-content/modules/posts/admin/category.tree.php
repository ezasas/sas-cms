<?if (!defined('basePath')) exit('No direct script access allowed');?>

<div class="menu-tree">
	<?
	$xtableName	= $this->table_prefix.'category';
	$xcatName  = $this->site->isMultiLang()?'category_name_'.$this->active_lang():'category_name';
	$xquery   	= "select category_id,parent_id,".$xcatName." from ".$xtableName." where category_type='post' order by ".$xcatName;
	$xmenuUrl 	= $this->adminURL().'category'.$this->permalink();
	
	echo $this->tree->getTree($xquery,$xmenuUrl,$xtableName,'category_id',$xcatName);
	?>
</div>