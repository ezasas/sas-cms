<?php if (!defined('basePath')) exit('No direct script access allowed');

$error 	    = true;
$errorMsg   = '';
$newComment = '';

if(empty($_POST['name'])){
	$errorMsg = 'Name is required';
}
elseif(empty($_POST['email'])){
	$errorMsg = 'Email is required';
}
elseif(empty($_POST['comment'])){
	$errorMsg = 'Comment is required';
}
else{
	
	$postid 	= anti_injection($_POST['postid']);
	$name 		= anti_injection($_POST['name']);
	$email 		= anti_injection($_POST['email']);
	$comment 	= anti_injection($_POST['comment']);
	$date 		= date('Y-m-d h:i:s');
	
	$addQuery = "insert into ".$this->table_prefix."comments set comment_post='".$postid."', comment_from='".$name."', comment_email='".$email."', comment_content='".$comment."', comment_date='".$date."'";
	
	if($this->db->execute($addQuery)){
	
		$error 	  	= false;
		$newComment	= '
			
			<li>
				<img alt="" src="'.$this->themeUrl().'assets/img/avatar/avatar.png" class="avatar">
				<div class="comment-item">
					<span class="comment-author">'.$name.'</span>
					<small class="comment-date">'.$date.'</small>
					<p>'.str_replace(array("\\r\\n","\\n","\\r"),"<br/>",$comment).'</p>
					<em>Waiting for approval</em>
				</div>
			</li>
		';
	}
	else{
		$errorMsg = 'Unable to sent your comment, please try again later';
	}
}

$response = array(
	
	'error'			=> $error,
	'alert'			=> $errorMsg,
	'newComment'	=> $newComment
);

echo json_encode($response);