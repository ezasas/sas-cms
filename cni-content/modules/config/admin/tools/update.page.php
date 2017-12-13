<?php if (!defined('basePath')) exit('No direct script access allowed');

if($this->site->isMultiLang()){
	
	/*---------------------------------------------------
	PAGES
	----------------------------------------------------*/	
	$tableName = $this->table_prefix.'pages';
	
	foreach($this->site->lang() as $langID=>$langVal){
		
		@$langField .= ',page_tagline_'.$langID.',page_name_'.$langID.',page_url_'.$langID;
		
		$this->form->isColumnExist($tableName,'page_tagline',$langID,'page_tagline');
		$this->form->isColumnExist($tableName,'page_name',$langID,'page_name');
		$this->form->isColumnExist($tableName,'page_url',$langID,'page_url');
	}
	
	$getPage = $this->db->getAll("select page_id,content_id,page_name,page_url".$langField." from ".$tableName);

	foreach($getPage as $page){
		
		/* update page name */
		if($page['page_name']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$pageName = 'page_name_'.$langID;
				if($page[$pageName]==''){
					$tableName = $this->table_prefix.'pages';
					$this->db->execute("update ".$tableName." set ".$pageName."='".$page['page_name']."' where page_id='".$page['page_id']."'");
					
				}
			}
		}	
		else{
			
			$sql = "update ".$tableName." set page_name='".$page['page_name_'.$this->active_lang()]."' where page_id='".$page['page_id']."'";
			$this->db->execute($sql);
		}
		
		/* update page url */
		if($page['page_url']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$pageUrl= 'page_url_'.$langID;
				if($page[$pageName]==''){
					$tableName = $this->table_prefix.'pages';
					$this->db->execute("update ".$tableName." set ".$pageUrl."='".$page['page_url']."' where page_id='".$page['page_id']."'");
				}
			}
		}
		else{
			
			$sql = "update ".$tableName." set page_url='".$page['page_url_'.$this->active_lang()]."' where page_id='".$page['page_id']."'";
			$this->db->execute($sql);
		}
		
		/* update page content */
		if($page['content_id']!=0){
			
			$tableName = $this->table_prefix.'pages_content';
			$langField = '';
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$langField .= ',content_title_'.$langID.',content_tagline_'.$langID.',content_description_'.$langID.',content_text_'.$langID.',content_tag_'.$langID;
				
				$this->form->isColumnExist($tableName,'content_title',$langID,'content_title');
				$this->form->isColumnExist($tableName,'content_tagline',$langID,'content_tagline');
				$this->form->isColumnExist($tableName,'content_description',$langID,'content_description');
				$this->form->isColumnExist($tableName,'content_text',$langID,'content_text');
				$this->form->isColumnExist($tableName,'content_tag',$langID,'content_tag');
			}
			
			$contentPage = $this->db->getRow("select content_title, content_tagline, content_description, content_text, content_tag ".$langField." from ".$tableName." where content_id='".$page['content_id']."'");
			
			/* update content title */
			if($contentPage['content_title']!=''){
				
				foreach($this->site->lang() as $langID=>$langVal){
					
					$filedName= 'content_title_'.$langID;
					if($contentPage[$filedName]==''){
						$this->db->execute("update ".$tableName." set ".$filedName."='".$contentPage['content_title']."' where content_id='".$page['content_id']."'");
					}
				}
			}	
			else{
				
				$this->db->execute("update ".$tableName." set content_title='".$contentPage['content_title_'.$this->active_lang()]."' where content_id='".$page['content_id']."'");
			}
			
			/* update content tagline */
			if($contentPage['content_tagline']!=''){
				
				foreach($this->site->lang() as $langID=>$langVal){
					
					$filedName= 'content_tagline_'.$langID;
					if($contentPage[$filedName]==''){
						$this->db->execute("update ".$tableName." set ".$filedName."='".$contentPage['content_tagline']."' where content_id='".$page['content_id']."'");
					}
				}
			}	
			else{
				
				$this->db->execute("update ".$tableName." set content_tagline='".$contentPage['content_tagline_'.$this->active_lang()]."' where content_id='".$page['content_id']."'");
			}
			
			/* update content description */
			if($contentPage['content_description']!=''){
				
				foreach($this->site->lang() as $langID=>$langVal){
					
					$filedName= 'content_description_'.$langID;
					if($contentPage[$filedName]==''){
						$this->db->execute("update ".$tableName." set ".$filedName."='".$contentPage['content_description']."' where content_id='".$page['content_id']."'");
					}
				}
			}	
			else{
				
				$this->db->execute("update ".$tableName." set content_description_='".$contentPage['content_description_'.$this->active_lang()]."' where content_id='".$page['content_id']."'");
			}
			
			/* update content text */
			if($contentPage['content_text']!=''){
				
				foreach($this->site->lang() as $langID=>$langVal){
					
					$filedName= 'content_text_'.$langID;
					if($contentPage[$filedName]==''){
						$this->db->execute("update ".$tableName." set ".$filedName."='".$contentPage['content_text']."' where content_id='".$page['content_id']."'");
					}
				}
			}	
			else{
				
				$this->db->execute("update ".$tableName." set content_text_='".$contentPage['content_text_'.$this->active_lang()]."' where content_id='".$page['content_id']."'");
			}
			
			/* update content tag*/
			if($contentPage['content_tag']!=''){
				
				foreach($this->site->lang() as $langID=>$langVal){
					
					$filedName= 'content_tag_'.$langID;
					if($contentPage[$filedName]==''){
						$this->db->execute("update ".$tableName." set ".$filedName."='".$contentPage['content_tag']."' where content_id='".$page['content_id']."'");
					}
				}
			}	
			else{
				
				$this->db->execute("update ".$tableName." set content_tag_='".$contentPage['content_tag_'.$this->active_lang()]."' where content_id='".$page['content_id']."'");
			}
		}
	}
	
	echo $this->form->alert('success','Page updated');
	
	/*---------------------------------------------------
	Category
	----------------------------------------------------*/	
	$tableName = $this->table_prefix.'category';
	$langField = '';
	
	foreach($this->site->lang() as $langID=>$langVal){
		
		$langField .= ',category_name_'.$langID.',category_tagline_'.$langID.',category_description_'.$langID;
		
		$this->form->isColumnExist($tableName,'category_name',$langID,'category_name');
		$this->form->isColumnExist($tableName,'category_tagline',$langID,'category_tagline');
		$this->form->isColumnExist($tableName,'category_description',$langID,'category_description');
	}
	
	$getPost = $this->db->getAll("select category_id,category_name,category_tagline,category_description".$langField." from ".$tableName);

	foreach($getPost as $post){
		
		/* update category title */
		if($post['category_name']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'category_name_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['category_name']."' where category_id='".$post['category_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_title='".$post['category_name_'.$this->active_lang()]."' where category_id='".$post['category_id']."'");
		}
		
		/* update category tagline */
		if($post['category_tagline']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'category_tagline_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['category_tagline']."' where category_id='".$post['category_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_title='".$post['category_tagline_'.$this->active_lang()]."' where category_id='".$post['category_id']."'");
		}
		
		/* update category description */
		if($post['category_description']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'category_description_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['category_description']."' where category_id='".$post['category_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_title='".$post['category_description_'.$this->active_lang()]."' where category_id='".$post['category_id']."'");
		}
	}
	echo $this->form->alert('success','Category updated');
	
	/*---------------------------------------------------
	POST
	----------------------------------------------------*/	
	$tableName = $this->table_prefix.'posts';
	$langField = '';
	
	foreach($this->site->lang() as $langID=>$langVal){
		
		$langField .= ',post_title_'.$langID.',post_tagline_'.$langID.',post_description_'.$langID.',post_content_'.$langID.',post_tag_'.$langID;
		
		$this->form->isColumnExist($tableName,'post_title',$langID,'post_title');
		$this->form->isColumnExist($tableName,'post_tagline',$langID,'post_tagline');
		$this->form->isColumnExist($tableName,'post_description',$langID,'post_description');
		$this->form->isColumnExist($tableName,'post_content',$langID,'post_content');
		$this->form->isColumnExist($tableName,'post_tag',$langID,'post_tag');
	}
	
	$getPost = $this->db->getAll("select post_id,post_title,post_tagline,post_description,post_content,post_tag".$langField." from ".$tableName);

	foreach($getPost as $post){
		
		/* update post title */
		if($post['post_title']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'post_title_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['post_title']."' where post_id='".$post['post_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_title='".$post['post_title_'.$this->active_lang()]."' where post_id='".$post['post_id']."'");
		}
		
		/* update post tagline */
		if($post['post_tagline']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'post_tagline_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['post_tagline']."' where post_id='".$post['post_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_tagline='".$post['post_tagline_'.$this->active_lang()]."' where post_id='".$post['post_id']."'");
		}
		
		/* update post description */
		if($post['post_description']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'post_description_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['post_description']."' where post_id='".$post['post_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_description='".$post['post_description_'.$this->active_lang()]."' where post_id='".$post['post_id']."'");
		}
		
		/* update post description */
		if($post['post_content']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'post_content_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['post_content']."' where post_id='".$post['post_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_content='".$post['post_content_'.$this->active_lang()]."' where post_id='".$post['post_id']."'");
		}
		
		/* update post description */
		if($post['post_tag']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'post_tag_'.$langID;
				if($post[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$post['post_tag']."' where post_id='".$post['post_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set post_tag='".$post['post_tag_'.$this->active_lang()]."' where post_id='".$post['post_id']."'");
		}
	}
	echo $this->form->alert('success','Post updated');
	
	/*---------------------------------------------------
	WIDGET/BLOCK
	----------------------------------------------------*/	
	$tableName = $this->table_prefix.'blocks';
	$langField = '';
	
	foreach($this->site->lang() as $langID=>$langVal){
		
		$langField .= ',block_title_'.$langID;
		
		$this->form->isColumnExist($tableName,'block_title',$langID,'block_title');
	}
	
	$getPost = $this->db->getAll("select block_id,block_title".$langField." from ".$tableName);
	
	foreach($getPost as $block){
		
		/* update block title */
		if($block['block_title']!=''){
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				$filedName = 'block_title_'.$langID;
				if($block[$filedName]==''){
					$this->db->execute("update ".$tableName." set ".$filedName."='".$block['block_title']."' where block_id='".$block['block_id']."'");
				}
			}
		}	
		else{
			
			$this->db->execute("update ".$tableName." set block_title='".$block['block_title_'.$this->active_lang()]."' where block_id='".$block['block_id']."'");
		}
	}
	echo $this->form->alert('success','Blocks updated');
}
?>