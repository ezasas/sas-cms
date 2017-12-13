<?php if (!defined('basePath')) exit('No direct script access allowed');

$postList = '';

foreach($posts->data as $dataPost){
	
	$post 		= $this->post->getRow($dataPost['post_id']);	
	$postImage 	= '';
	$getCategory	= '';
	
	foreach($post->category as $catID => $category){
		
		$getCategory .= '<a href="'.baseURL.$category['url'].'">'.$category['name'].'</a>, ';
	}
	$getCategory = substr($getCategory,0,-2);
	
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
	$postList .= '
		
		<div class="blog-post standard-post">
			<!-- Post Thumb -->
			'.$postImage.'
			<!-- Post Content -->
			<div class="post-content">
				<div class="post-type"><i class="fa fa-pencil"></i></div>
				<h2><a href="'.$post->url.'">'.$post->title.'</a></h2>
				<ul class="post-meta">
					<li>By '.$post->author.'</li>
					<li>'.date_indo($post->created).'</li>
					<li>'.$getCategory.'</li>
				</ul>
				<p>'.$post->smallContent.'</p>
				<a class="btn btn-default" href="'.$post->url.'">Read More <i class="fa fa-angle-right"></i></a>
			</div>
		</div>
	';
}
?>

<div class="post">
	<div class="post-content">
		<?=$postList?>
	</div>
	<div class="page-nav"><?=$this->data->getNav();?></div>
</div>