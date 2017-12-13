<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){
	
	case '_page':
		
		$page 			 = new stdClass();
	    $content_text 	 = $this->site->isMultiLang()?'content_text_'.$this->active_lang():'content_text';
		$content_title   = $this->site->isMultiLang()?'content_title_'.$this->active_lang():'content_title';
		$content_tagline = $this->site->isMultiLang()?'content_tagline_'.$this->active_lang():'content_tagline';
		$contentId	     = $this->db->getOne("select content_id from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");
		$pages 		     = $this->db->getAll("select ".$content_title." as content_title, ".$content_tagline." as content_tagline,".$content_text." as content_text,content_image from ".$this->table_prefix."pages_content where content_id='".$contentId."'");
		
		$getPage = array();
		
		foreach($pages as $arrPage){
		
			$getPage['title'] 	= html_entity_decode($arrPage['content_title']);
			$getPage['content'] = html_entity_decode($arrPage['content_text']);
			$getPage['image']   = !empty($arrPage['content_image'])?$arrPage['content_image']:'';
		}
		
		
		//Define variables
		$page->title	 = html_entity_decode($getPage['title']);
		$page->content 	 = html_entity_decode($getPage['content']);
		$page->image	 = $getPage['image']!=''?uploadURL.'modules/pages/'.$getPage['image']:'';
		
		
		//Start Listing
		if(isFileExist($this->themePath(),'pages.php')){
			include_once $this->themePath().'pages.php';
		}
		else{
		
			echo '
			
				<div class="post">
					<img src="'.$page->image.'"/>
					'.$page->content.'
				</div>
			';
		}
		
	break;
	
	default:
		$this->_404();
		break;
}