<?php if (!defined('basePath')) exit('No direct script access allowed');

// Table Name
$sqltable = array(

	'table'	=> $this->table_prefix.'config',
	'id' 	=> 1
);


// Define arr input

$params 	= array(
	
	$this->form->input->textarea('', 'add_site_welcome',60,30,$editor=true),	$this->form->input->html('</div>')
);
?>

<div class="widget-container">
	<div class="widget-title">
		<i class="icon-th-list"></i>
		<h5>Welcome</h5>
	</div>
	<div>
		<?$this->form->getForm('edit',$sqltable,$params,$formName='welcome',$submitValue='Update Welcome');?>
	</div>
</div>