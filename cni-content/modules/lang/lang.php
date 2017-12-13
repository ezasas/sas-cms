<?php if (!defined('basePath')) exit('No direct script access allowed');

function getURI($segment,$url){
	
	global $system;
	
	$getURI = str_replace($system->thisURI(),'',$url);	
	$requestURI = $system->config['permalink']=='.html'?get_string_before($getURI,'.html'):$getURI;
	$requestURI = $system->config['permalink']=='.html' && !preg_match('/.html/i',$getURI)?$getURI:$requestURI;	
	$uri  = explode('/',str_replace($system->config['baseURL'],'',$requestURI));

	if(array_key_exists($segment, $uri)){
		return $uri[$segment];
	}
	else{
		return null;
	}
}

$currentUrl = getURI(0,$_SERVER['HTTP_REFERER']);
$selectedLang = $this->uri(2);
$columnName	= $this->site->isMultiLang()?'page_url_'.$selectedLang:'page_url';
$columnUrl = $this->isColumnExist($this->table_prefix.'pages',$columnName)?$columnName:'page_url';
$currentColumnName = $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$pageID = $this->db->getOne("select page_id from ".$this->table_prefix."pages where ".$currentColumnName."='".$currentUrl."'");
$module = $this->db->getOne("select m.module_name from ".$this->table_prefix."modules m left join ".$this->table_prefix."pages p on(m.module_id=p.module_id) where p.".$currentColumnName."='".$currentUrl."'");
$pageUrl = $this->db->getOne("select ".$columnUrl." from ".$this->table_prefix."pages where ".$currentColumnName."='".$currentUrl."'");
$redirect = baseURL;

switch($module){
	
	case 'lang':break;
	
	case 'posts':
	
	break;	
	
	default:
		$redirect .= $pageUrl.$this->permalink();
	break;
}

$this->change_lang('public',$selectedLang);
$this->redirect($redirect);
exit;
?>