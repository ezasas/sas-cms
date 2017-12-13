<?php if (!defined('basePath')) exit('No direct script access allowed');

/** CNI - PHP Meta 
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
switch($this->thisModule()){

	/*--- Content ---*/
	case 'config':
	
		if($this->uri(1)!=$this->admin_name and $this->getSwitch()=='_page'){		
		
			$contentId	= $this->db->getOne("select content_id from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");
			$pages 		= $this->db->getAll("select content_title,content_text,content_description,content_tag,content_image from ".$this->table_prefix."pages_content where content_id='".$contentId."'");
			
			foreach($pages as $arrPage){
			
				$metaTitle 		 = $arrPage['content_title'];
				$contentText 	 = strip_tags($arrPage['content_text']);
				$metaDescription = $arrPage['content_description'];
				$metaTag 		 = $arrPage['content_tag'];
				$metaImage 		 = $arrPage['content_image'];
			}

			$metaTitle 		 = !empty($metaTitle)?$metaTitle:strip_tags($this->siteTitle());
			$metaDescription = !empty($metaDescription)?$metaDescription:trimContent(@$contentText,20);
			$metaDescription = !empty($metaDescription)?$metaDescription:$this->site->description();
			$metaTag 		 = !empty($metaTag)?$metaTag:$this->site->keyword();
			$metaImage 		 = !empty($metaImage)?$metaImage:'default.jpg';
			
			$meta 		 = array(
				
				'title' 		=> $metaTitle ,
				'keywords' 		=> $metaTag,
				'description' 	=> $metaDescription
			);
			
			$fbMeta		= array(
			
				'og:title' 		 => $metaTitle,
				'og:description' => $metaDescription,
				'og:image' 		 => uploadURL.'modules/pages/thumbs/'.$metaImage
			);
		}
		else{
			$meta = array();
			$fbMeta = array();
		}
		
		break;
		
	case 'posts':
		
		if($this->uri(1)!=$this->admin_name && $this->uri(1)=='read'){
		    $titlemulti		= $this->site->isMultiLang()?'post_title_'.$this->active_lang():'post_title';
			$descriptmulti	= $this->site->isMultiLang()?'post_description_'.$this->active_lang():'post_description';
			$contentmulti	= $this->site->isMultiLang()?'post_content_'.$this->active_lang():'post_content';
			$tagmulti		= $this->site->isMultiLang()?'post_tag_'.$this->active_lang():'post_tag';
			$metaPostsId 	= intval($this->uri(2));
			$metaQuery	 	= "

				select 
				    ".$titlemulti." as post_title,
					".$descriptmulti." as post_description,
					".$contentmulti." as post_content,
					".$tagmulti." as post_tag,
					post_image
				from ".$this->table_prefix."posts 
				where post_id='".$metaPostsId."' and publish='1'
			";
			//echo $metaQuery;
			$getMeta = $this->db->getRow($metaQuery);
			extract($getMeta);
			
			$metaTitle 		 = !empty($post_title)?$post_title:strip_tags($this->siteTitle());
			$metaDescription = !empty($post_description)?$post_description:trimContent(strip_tags(@$post_content),20);
			$metaDescription = !empty($post_description)?$post_description:$this->site->description();
			$metaDescription = substr($metaDescription,0,150);
			$metaTag 		 = !empty($post_tag)?$post_tag:$this->site->keyword();
			$metaImage 		 = !empty($post_image)?$post_image:'default.jpg';
			
			$meta 		 = array(
				
				'title' 		=> $metaTitle ,
				'keywords' 		=> $metaTag,
				'description' 	=> $metaDescription
			);
			$fbMeta		= array(
			
				'og:title' 		 => $metaTitle,
				'og:description' => $metaDescription,
				'og:image' 		 => uploadURL.'modules/posts/thumbs/small/'.$metaImage
			);
		}
		else{
			$meta = array();
			$fbMeta = array();
		}
		break;
	
	case 'project':
		
		$titlemulti		= $this->site->isMultiLang()?'post_title_'.$this->active_lang():'post_title';
		$descriptmulti	= $this->site->isMultiLang()?'post_description_'.$this->active_lang():'post_description';
		$contentmulti	= $this->site->isMultiLang()?'post_content_'.$this->active_lang():'post_content';
		$tagmulti		= $this->site->isMultiLang()?'post_tag_'.$this->active_lang():'post_tag';
		$metaPostsId 	= intval($this->uri(2));
		$metaQuery	 	= "

			select 
				".$titlemulti." as post_title,
				".$descriptmulti." as post_description,
				".$contentmulti." as post_content,
				".$tagmulti." as post_tag,
				post_image
			from ".$this->table_prefix."posts 
			where post_id='".$metaPostsId."' and publish='1'
		";
		//echo $metaQuery;
		$getMeta = $this->db->getRow($metaQuery);
		extract($getMeta);
		
		$metaTitle 		 = !empty($post_title)?$post_title:strip_tags($this->siteTitle());
		$metaDescription = !empty($post_description)?$post_description:trimContent(strip_tags(@$post_content),20);
		$metaDescription = !empty($post_description)?$post_description:$this->site->description();
		$metaDescription = substr($metaDescription,0,150);
		$metaTag 		 = !empty($post_tag)?$post_tag:$this->site->keyword();
		$metaImage 		 = !empty($post_image)?$post_image:'default.jpg';
		
		$meta 		 = array(
			
			'title' 		=> $metaTitle ,
			'keywords' 		=> $metaTag,
			'description' 	=> $metaDescription
		);
		$fbMeta		= array(
		
			'og:title' 		 => $metaTitle,
			'og:description' => $metaDescription,
			'og:image' 		 => uploadURL.'modules/posts/thumbs/small/'.$metaImage
		);
		break;
		
	default:
		$meta = array();
		$fbMeta = array();
		break;
}
?>