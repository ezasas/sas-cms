<?php

/** CNI - PHP Site Class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class site{
	
	function site($db,$table_prefix){	
		$this->db 			= $db;
		$this->table_prefix = $table_prefix;		
		$site = $this->db->getArray("select * from ".$this->table_prefix."config where 1");
		return $site;		
	}
	function getLang(){
		$lang = $this->db->getOne("select lang from ".$this->table_prefix."config where 1");
		$lang = unserialize($lang);
		return $lang;
	}
	function default_lang(){
		$lang = $this->getLang();
		return $lang['default_lang'];
	}
	function lang(){
		$lang = $this->getLang();
		return $lang['lang'];
	}
	function lang_icon(){
		$langIcon = $this->getLang();
		return $langIcon['icon'];
	}
	function isMultiLang(){
		$lang = $this->getLang();
		
		if($lang['ismulti']==1){
			return true;
		}
		else{
			return false;
		}
	}
	function theme(){
		$theme = $this->db->getOne("select site_theme from ".$this->table_prefix."config where 1");
		return $theme;		
	}
	function title(){
		$site_title = $this->db->getOne("select site_title from ".$this->table_prefix."config where 1");
		return $site_title;
	}
	function tagline(){
		$tagline = $this->db->getOne("select site_tagline from ".$this->table_prefix."config where 1");
		return $tagline;
	}
	function welcome(){
		$welcome = $this->db->getOne("select site_welcome from ".$this->table_prefix."config where 1");
		return $welcome;
	}
	function description(){
	 global $system;
	    $desi  = $system->site->isMultiLang()?'site_description_'.$system->active_lang():'site_description';
		$description = $this->db->getOne("select ".$desi." from ".$this->table_prefix."config where 1");
		return $description;
	}
	function keyword(){
	    global $system;
	    $katakunci  = $system->site->isMultiLang()?'site_keyword_'.$system->active_lang():'site_keyword';
		$keyword = $this->db->getOne("select ".$katakunci." from ".$this->table_prefix."config where 1");
		return $keyword;
	}
	function company_name(){
		$company_name = $this->db->getOne("select company_name from ".$this->table_prefix."config where 1");
		return $company_name;
	}
	function company_address(){
		$company_address = $this->db->getOne("select company_address from ".$this->table_prefix."config where 1");
		return $company_address;
	}
	function company_phone(){
		$company_phone = $this->db->getOne("select company_phone from ".$this->table_prefix."config where 1");
		return $company_phone;
	}
	function company_mobile(){
		$company_mobile = $this->db->getOne("select company_mobile from ".$this->table_prefix."config where 1");
		return $company_mobile;
	}
	function company_fax(){
		$company_fax = $this->db->getOne("select company_fax from ".$this->table_prefix."config where 1");
		return $company_fax;
	}
	function company_email(){
		$email_account = $this->db->getOne("select email_account from ".$this->table_prefix."config where 1");
		return $email_account;
	}
	function company_alternate_email(){
		$alternate_email = $this->db->getOne("select alternate_email from ".$this->table_prefix."config where 1");
		return $alternate_email;
	}
	function logo(){
		$company_logo = $this->db->getOne("select company_logo from ".$this->table_prefix."config where 1");
		return $company_logo;
	}
	function domain(){
		$domain = $this->db->getOne("select site_domain from ".$this->table_prefix."config where 1");
		return $domain;
	}
	function footer(){
		$footer = $this->db->getOne("select site_footer from ".$this->table_prefix."config where 1");
		return $footer;
	}
	function header(){
		$header = $this->db->getOne("select header from ".$this->table_prefix."config where 1");
		return $header;
	}
	function social_media($brand=''){
		
		$getSocial 	= $this->db->getOne("select socila_media from ".$this->table_prefix."config where 1");
		$arrMedia	= unserialize($getSocial);
		$social		= empty($brand)?$arrMedia:$arrMedia[$brand];
		
		return $social;
	}
	function thumbnailVal($size=''){
		
		$getThumbnail 	= $this->db->getOne("select thumbnail from ".$this->table_prefix."config where 1");
		$arrThumb		= unserialize($getThumbnail);
		$thumbnail		= empty($size)?$arrThumb:$arrThumb[$size];
		
		return $thumbnail;
	}
	function thumbnail(){
		
		$getThumbnail 	= $this->db->getOne("select thumbnail from ".$this->table_prefix."config where 1");
		$thumbnail		= empty($getThumbnail)?array():unserialize($getThumbnail);
		
		return $thumbnail;
	}
	function favicon(){
		$facebook = $this->db->getOne("select favicon from ".$this->table_prefix."config where 1");
		return $facebook;
	}
	function menu_position($str){
		if($str=='public'){
			$menu_position = $this->db->getOne("select menu_public from ".$this->table_prefix."config where 1");
		}
		elseif($str=='admin'){
			$menu_position = $this->db->getOne("select menu_admin from ".$this->table_prefix."config where 1");		
		}
		return $menu_position;
	}
	function defaultImage(){
		$defaultImage = $this->db->getOne("select default_img from ".$this->table_prefix."config where 1");
		return $defaultImage;
	}
}
?>