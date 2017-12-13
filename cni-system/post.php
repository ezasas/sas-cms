<?php

/** CNI - PHP Post Class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class Post{

	function Post($db,$tablePrefix,$site,$data,$permalink,$activeLang){
	
		$this->db 			= $db;
		$this->table_prefix = $tablePrefix;
		$this->site			= $site;
		$this->data			= $data;
		$this->active_lang	= $activeLang;
		$this->readURL 		= baseURL.'read/';
	}
	function getRow($postID){

		if($this->site->isMultiLang()){
			$titleField   	  = 'post_title_'.$this->active_lang.',';
			$taglineField  	  = 'post_tagline_'.$this->active_lang.',';
			$contentField 	  = 'post_content_'.$this->active_lang.',';
			$descriptionField = 'post_description_'.$this->active_lang.',';
			$tagField 		  = 'post_tag_'.$this->active_lang.',';
		}
		
		$query	 = "

			select 
				post_id,
				post_category,
				post_title,
				".@$titleField."
				post_tagline,
				".@$taglineField."
				post_description,
				".@$descriptionField."
				post_content,
				".@$contentField."
				post_tag,
				".@$tagField."
				post_image,
				posts_author,
				post_hits,
				post_rating,
				created_date,
				published_date
			from ".$this->table_prefix."posts 
			where post_id='".$postID."' and publish='1'
		";
		$xpost	 = $this->db->execute($query);

		if($xpost->recordCount()>0){

			$getArray = $this->db->getArray($query);
			$data  	  = array();
			
			foreach($getArray as $key => $val){
				foreach($val as $k => $v){
					if(!is_numeric($k)){
					
						$data[$k] = $v;
					}
				}
			}

			//Get Image
			$uplpadsUrl 	= uploadURL.'modules/posts/';	
			$post 			= new stdClass();
			$postContent	= 'post_content';
			if($this->site->isMultiLang())$postContent = 'post_content_'.$this->active_lang;
			
			if(!empty($data['post_image']) && isFileExist(uploadPath.'modules/posts/',$data['post_image'])){
			
				$post->image 		 	= $data['post_image'];
				$post->imageURL		 	= $uplpadsUrl.$data['post_image'];
				$post->imageUrlLarge	= $uplpadsUrl.'thumbs/large/'.$data['post_image'];
				$post->imageUrlMedium	= $uplpadsUrl.'thumbs/medium/'.$data['post_image'];
				$post->imageUrlSmall	= $uplpadsUrl.'thumbs/small/'.$data['post_image'];
				$post->imageUrlMini		= $uplpadsUrl.'thumbs/mini/'.$data['post_image'];
				$post->getImage 	 	= '<img src="'.$uplpadsUrl.$data['post_image'].'">';
				$post->getThumbLarge 	= '<img src="'.$uplpadsUrl.'thumbs/large/'.$data['post_image'].'">';
				$post->getThumbMedium 	= '<img src="'.$uplpadsUrl.'thumbs/medium/'.$data['post_image'].'">';
				$post->getThumbSmall 	= '<img src="'.$uplpadsUrl.'thumbs/small/'.$data['post_image'].'">';
				$post->getThumbMini 	= '<img src="'.$uplpadsUrl.'thumbs/mini/'.$data['post_image'].'">';
				$post->content 		 	= htmlspecialchars_decode(html_entity_decode($data[$postContent]));
			}
			else{
				
				$postImage	= '<img '.get_string_between(html_entity_decode($data[$postContent]), '<img ', '>').'>';
				$imageSrc	= '';
				$arrSrc		= array();
				
				$doc = new DOMDocument();
				@$doc->loadHTML($postImage);

				$tags = $doc->getElementsByTagName('img');
				
				if(count($tags)>0){
					
					foreach ($tags as $tag) {
						$arrSrc[] = $tag->getAttribute('src');
					}
					$imageSrc = $arrSrc[0];
				}
				$getImage	= str_replace('../media/Image/',uploadURL.'image/',$imageSrc);
				$getImage	= str_replace('../media/',uploadURL.'image/',$getImage);
				$getImage	= str_replace('/media/',uploadURL.'image/',$getImage);
				$content	= str_replace($postImage,'',html_entity_decode($data[$postContent]));


				$post->image 		 	= !empty($imageSrc)?$imageSrc:'';
				$post->imageURL		 	= $imageSrc;
				$post->imageUrlLarge	= $imageSrc;
				$post->imageUrlMedium	= $imageSrc;
				$post->imageUrlSmall	= $imageSrc;
				$post->imageUrlMini		= $imageSrc;
				$post->getImage 	 	= !empty($post->image)?'<img src="'.$getImage.'">':'';
				$post->getThumbLarge 	= !empty($post->image)?'<img src="'.$getImage.'">':'';
				$post->getThumbMedium 	= !empty($post->image)?'<img src="'.$getImage.'">':'';
				$post->getThumbSmall 	= !empty($post->image)?'<img src="'.$getImage.'">':'';
				$post->getThumbMini 	= !empty($post->image)?'<img src="'.$getImage.'">':'';
				$post->content 		 	= htmlspecialchars_decode(html_entity_decode($content));
			}
			
			//Get Categories
			if($cat = @unserialize(html_entity_decode($data['post_category']))){
				$arrCat = $cat;
			}
			else{
				$arrCat = array($data['post_category']);
			}

			$categories = array();
			
			foreach($arrCat as $catID){
				
				$catName = 'category_name';
				$pageURL = 'page_url';
				if($this->site->isMultiLang())$catName = 'category_name_'.$this->active_lang;
				if($this->site->isMultiLang())$pageURL = 'page_url_'.$this->active_lang;
			
				$categoryName = $this->db->getOne("select ".$catName." from ".$this->table_prefix."category where category_id='".$catID."'");
				$categoryURL  = $this->db->getOne("select ".$pageURL." from ".$this->table_prefix."pages where category_id='".$catID."'");
				
				if(!empty($categoryName)){
					
					$categories[$catID] = array('name'=>strDecode($categoryName),'url'=>$categoryURL);
				}
			}
			
			//Define Variables
			$title 				= 'post_title';
			$tagline 			= 'post_tagline';
			$postDescription	= 'post_description';
			if($this->site->isMultiLang())$title = 'post_title_'.$this->active_lang;
			if($this->site->isMultiLang())$tagline = 'post_tagline_'.$this->active_lang;
			if($this->site->isMultiLang())$postDescription = 'post_description_'.$this->active_lang;
			
			$post->id			= $data['post_id'];
			$post->category 	= $categories;
			$post->title 		= htmlspecialchars_decode(html_entity_decode($data[$title]));
			$post->tagline 		= html_entity_decode($data[$tagline]);
			$post->description 	= html_entity_decode($data[$postDescription]);
			$post->getTag 		= preg_replace('/\s+/', '', $data['post_tag']);
			$post->tag 			= explode(',',$post->getTag);
			$post->author 		= html_entity_decode($data['posts_author']);
			$post->hits 		= $data['post_hits'];
			$post->rating 		= $data['post_rating'];
			$post->created		= $data['created_date'];
			$post->published	= $data['published_date'];
			$post->url			= baseURL.'read/'.$postID.'/'.seo_slug($post->title).'.html';
			$post->smallContent	= trimText(html_entity_decode($post->content));
			$post->commentCount	= $this->db->getOne("select count(comment_id) from ".$this->table_prefix."comments where comment_post='".$post->id."' and publish='1'");
			$post->commentURL	= baseURL.'read/'.$postID.'/'.seo_slug($post->title).'.html#comment-list';
			
			//Get First paragraph
			$post->firstParagraph = '';
			if(!empty($post->content)){
				
				$doc = new DOMDocument();
				$doc->loadHTML($post->content);
				$xlength = 1;
				foreach($doc->getElementsByTagName('p') as $paragraph) {
					if($xlength==1)$post->firstParagraph = $doc->saveHTML($paragraph);
					$xlength++;
				}
			}
			
			return $post;
		}
		else{
			return false;
		}
	}
	function getPostByCategory($categotyID){
	
		$query	= "select post_id from ".$this->table_prefix."posts where post_category like '%".$categotyID."%' and publish='1' order by post_id desc";
		$xpost	= $this->db->getAll($query);
		$posts	= array();
		
		foreach($xpost as $key => $data){

			$posts[] = $this->getRow($data['post_id']);
		}
		return $posts;
	}
	function getAll($limit=10){
	
		$query	= "select post_id from ".$this->table_prefix."posts where publish='1' order by post_id desc limit ".$limit;
		$xpost	= $this->db->getAll($query);
		$posts	= array();
		
		foreach($xpost as $key => $data){

			$posts[] = $this->getRow($data['post_id']);
		}
		return $posts;
	}
	function url($postID,$title){
	
		$readUrl = baseURL.'read/'.$postID.'/'.seo_slug($title).'.html';
		return $readUrl;
	}
	function comment($postID=''){
		
		global $system;
		
		$query 		 = "select comment_from, comment_content, comment_date from ".$system->table_prefix."comments where comment_post=".intval($system->uri(2))." and publish='1' order by comment_id";
		$arrComment	 = $system->db->getAll($query);
		$commentList = '';
		
		foreach($arrComment as $comment){
			
			$commentList .='
			
				<li>  
					<img alt="" src="'.$system->themeUrl().'assets/img/avatar/avatar.png"> 
					<div class="comment-item">
						<span class="comment-author">'.$comment['comment_from'].'</span>
						<small class="comment-date">'.date_indo($comment['comment_date'],true).'</small>
						<p>'.$comment['comment_content'].'</p>			   
					</div>
				</li>
			';
		}
		
		$comment = '
	
			<ol id="comment-list">'.$commentList.'</ol>
			<div class="msg">'.@$errorMsg.'</div>
			<form id="frmAddComment" name="frmAddComment" action="'.modulePath.'posts/post.comment.php" method="post">
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="name" placeholder="Nama *" class="form-control">
						</div>
						<div class="col-md-6">
							<input type="email" name="email" placeholder="Email(tidak akan di publikasikan) *" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<textarea name="comment" class="form-control form-comment" placeholder="Komentar *"></textarea>
				</div>
				<span class="comment-progress" style="display:none">
					<img src="'.baseURL.'/cni-admin/themes/ace/assets/img/progress.gif">
				</span>
				<button type="submit" class="btn btn-default">Kirim komentar</button>
				<input type="hidden" name="postid" value="'.intval($system->uri(2)).'">
				<input type="hidden" value="'.$system->data->token('scode').'" name="scode">
			</form>
			
		';
		
		echo $comment;
	}
	function updateHits($postID){
	
		global $system;
		
		$getIP = getClientIP();

		if(@$_SESSION['read']['ip']!=$getIP || !in_array($postID,@$_SESSION['read']['id'])){

			$hits =  $system->db->getOne("select post_hits from ".$system->table_prefix."posts where post_id = '".$postID."'");

			if($system->db->execute("update ".$system->table_prefix."posts set post_hits='".(intval($hits)+1)."' where post_id='".$postID."'")){
				$_SESSION['read']['ip']   		 = $getIP;
				$_SESSION['read']['id'][$postID] = $postID;
			}
		}
	}
	function updateParentCategory($postID=0){
	
		global $system;
		
		if($postID > 0){
			$post = $system->db->getAll("select post_id,post_category from ".$system->table_prefix."posts where post_id='".$postID."'");
		}
		else{
			$post = $system->db->getAll("select post_id,post_category from ".$system->table_prefix."posts");
		}
		foreach($post as $v){
			
			$parentID = $system->getCatParentID($v['post_category']);
			$mainParentID = $system->getCatMainParent($v['post_category']);
			$this->db->execute("update ".$system->table_prefix."posts set post_category_parent='".$parentID."',post_category_main_parent='".$mainParentID."' where post_id='".$v['post_id']."'");
		}
	}
}