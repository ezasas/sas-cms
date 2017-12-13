<?php if (!defined('basePath')) exit('No direct script access allowed');

$postsId 		= intval($this->uri(2));
$posts 	 		= new stdClass;
$posts->getRow 	= $this->post->getRow($postsId);
$post 			= $posts->getRow;
$postImage		= '';

if(!empty($post->imageURL)){
	
	$postImage = '
		
		<div class="post-head">
			<a href="'.$post->url.'">
				<div class="thumb-overlay"><i class="fa fa-arrows-alt"></i></div>
				<div class="main-image"><img alt="" src="'.$post->imageURL.'"></div>
			</a>
		</div>
	';
}

if($post){
	$this->post->updateHits($postsId);
	if(isFileExist($this->themePath(),'post.detail.php')){
		include $this->themePath().'post.detail.php';
	}
	else{
		
		/* Default */
		$getTags  = '';
		foreach($post->tag as $tag){			
			$getTags .= '<a href="#">'.$tag.'</a>, ';
		}
		?>		
		<div class="blog-post standard-post">
			<!-- Post Thumb -->
			<?php echo $postImage; ?>
			<!-- Post Content -->
			<div class="post-content">
				<div class="post-type"><i class="fa fa-pencil"></i></div>
				<h2><a href="<?php echo $post->url ?>"><?php echo $post->title; ?></a></h2>
				<ul class="post-meta">
					<li>By <a href="#"><?php echo $post->author;?></a></li>
					<li><?php echo date_indo($post->created); ?></li>
					<li><?php echo $getTags;?></li>
					<li></li>
				</ul>
				<?php echo $post->content; ?>
			</div>
		</div>
		<div class="post-bottom">
		  <div class="post-share">
			<span>Share This Post:</span>
			<?php echo simpleShare(); ?>
		  </div>
		</div>
		<?		
	}
}
else{
	echo 'Data not available.';
}
?>