<?php if (!defined('basePath')) exit('No direct script access allowed');

if(!empty($page->image)){
	echo '<div class="main-image"><img src="' . $page->image . '"></div>';
}
echo $page->content;
?>