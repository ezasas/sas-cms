<?php if (!defined('basePath')) exit('No direct script access allowed'); 

if(isFileExist($this->themePath().'blocks/'.$block['block_name'].'/','breadcrumb.php')){
	include $this->themePath().'blocks/'.$block['block_name'].'/breadcrumb.php';
}
else{
	?>
	<div class="site-description">
		<div class="container">
			<h1 class="heading"><?=$this->PageTitle();?></h1>
		</div>
	</div>
	<?php
	}
?>