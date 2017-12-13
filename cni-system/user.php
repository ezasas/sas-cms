<?php

/** CNI - PHP USER Class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class user{
	
	function user($db,$tablePrefix){
		$this->db 			= $db;
		$this->table_prefix	= $tablePrefix;
	}
	function getPage($arrMenu,$parent,$pageId,$title,$link,$userAccess,$access){
		
		$access = empty($access)?array():$access;
		
		if(isset($arrMenu[$parent])){
		
		   	$menu 	= $parent==0?'<ul class="parent">':'<ul>';
			foreach($arrMenu[$parent] as $value){
				
				#if(in_array($value[$pageId],$userAccess)){
				
					$child   = $this->getPage($arrMenu,$value[$pageId],$pageId,$title,$link,$userAccess,$access); 
					$checked = in_array($value[$pageId],$access)?'checked':'';
					
					if(empty($value[$title])){
					 	$value[$title]=$value['page_name'];
					}
					
					$xMenu = '<input class="chk ace" name="page[]" type="checkbox" value="'.$value[$pageId].'" '.$checked.'/><span class="lbl"> '.$value[$title].'</span>';
					
					if($child){
						$menu .= '
						
							<li class="parent">'.$xMenu.$child.'</li>
						';
					}
					else{
						$menu .= '
						
							<li>'.$xMenu.'</li>
						';
					}
				#}
			}
			
			$menu .= '</ul>';
			
			return $menu;
		}
		else{
			return false;	  
		}
	}
	function pages($query,$userAccess,$access){

		global $system;
		
		$rsMenu = $this->db->execute($query);

		while($row = $rsMenu->fetchRow()){
		
			$data[$row['parent_id']][]=$row;
		}
		
        $pageName 	= $system->site->isMultiLang()?'page_name_'.$system->active_lang():'page_name';
		$pageName	= $system->isColumnExist($system->table_prefix.'pages','page_name_'.$system->active_lang())?$pageName:'page_name';
		
		$adminMenu = $this->getPage($data,0,'page_id',$pageName,'page_url',$userAccess,$access);
		return $adminMenu;
	}
	function getPermission($groupId){
		
		$groupId 	= empty($groupId)?'4':$groupId;
		$getAccess  = $this->db->getOne("select access from ".$this->table_prefix."user_group where group_id='".$groupId."'");
		$permission = empty($getAccess)?array():unserialize($getAccess);

		return $permission;
	}
}
?>