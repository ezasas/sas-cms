<?php if (!defined('basePath')) exit('No direct script access allowed');

$read_id	= 47; /* Page read ID*/

function getURI($segment,$url){
	
	global $system;
	
	$getURI = str_replace($system->thisURI(),'',$url);
	
	$requestURI = $system->config['permalink']=='.html'?get_string_before($getURI,'.html'):$getURI;
	$requestURI = $system->config['permalink']=='.html' && !preg_match('/.html/i',$getURI)?$getURI:$requestURI;
	$system->uri  = explode('/',str_replace($system->config['baseURL'],'',$requestURI));

	if(array_key_exists($segment, $system->uri)){
		
		$systemUri = $system->permalink()!='/'?str_replace($system->permalink(),'',$system->uri[$segment]):$system->uri[$segment];
		return $systemUri;
	}
	else{
		return null;
	}
}

$this->change_lang('public',$_POST['lang_id']);

if($_POST['page_id']==$read_id){

	$postID = intval(getURI(1,$_POST['this_url']));
	
	$post_url		 = $this->db->getOne("select post_title_".$_POST['lang_id']." from ".$this->table_prefix."posts where post_id='".$postID."'");
	$post_url_active = $this->db->getOne("select post_title_".$_POST['active_lang']." from ".$this->table_prefix."posts where post_id='".$postID."'");
	$redirect 		 = str_replace(seo_slug($post_url_active),seo_slug($post_url),$_POST['this_url']);
	$redirect 		 = $redirect;
}
else{

	$page_url		 = $this->db->getOne("select page_url_".$_POST['lang_id']." from ".$this->table_prefix."pages where page_id='".$_POST['page_id']."'");
	$page_url_active = $this->db->getOne("select page_url_".$_POST['active_lang']." from ".$this->table_prefix."pages where page_id='".$_POST['page_id']."'");
	$redirect 		 = str_replace($page_url_active,$page_url,$_POST['this_url']);
}
echo $response = json_encode(array('redirect'=>$redirect));
?>