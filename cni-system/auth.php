<?php

/** CNI - PHP Auth class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class auth{
	
	function auth($db,$tablePrefix){
	
		$this->db = $db;
		$this->table_prefix = $tablePrefix;
	}
	function admin(){
	
		$admin = @$this->auth_session('admin');
		$auth  = $this->db->getOne("select authsession from ".$this->table_prefix."user where id='".intval(@$admin['id'])."'");
		
		if(empty($admin['id'])){
			return false;
		}
		elseif(!empty($admin['session']) && @$admin['session']==$auth){
			return $admin;
		}
		else{
			return false;
		}
	}
	function user(){
	
		$user = @$this->auth_session('user');
		$auth  = $this->db->getOne("select authsession from ".$this->table_prefix."user where id='".intval(@$user['id'])."'");
		
		if(!empty($user) && $user['session']==$auth){
			return $user;
		}
		else{
			return false;
		}
	}
	function member(){
	
		$member = @$this->auth_session('member');
		$auth   = $this->db->getOne("select authsession from ".$this->table_prefix."member where member_id='".intval(@$member['memberID'])."'");

		if(!empty($member) && $member['session']==$auth){
			return $member;
		}
		else{
			return false;
		}
	}
	function auth_session($strName){
	
		$session = $_SESSION[$strName];
		return $session;
	}
}
?>