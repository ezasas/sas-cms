<?php
$menu = json_decode(stripslashes($_POST['menu']),true);

function updateMenu($arrMenu,$parent=0){

	global $system;
	
	foreach($arrMenu as $n=>$v){
		
		$sql = "update ".$system->table_prefix."menu set parent_id='".$parent."', menu_order='".$n."' where menu_id='".$v['id']."'";
		$system->db->execute($sql);
		if(isset($v['children']))updateMenu($v['children'],$v['id']);
	}	
}

updateMenu($menu);
?>