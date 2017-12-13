<?php if (!defined('basePath')) exit('No direct script access allowed');

$linkID   = intval($this->uri(3));
$redirect = base64_decode(substr($this->uri(4),3));

// Table Name
$sqltable 	= array(

	'table'	    => $this->table_prefix.'params',
	'params_id' => 1
);

// Define form field
$params	= array(
	
	$this->form->input->html('<div class="widget-content">'),
	$this->form->input->text('','add_running_text'),
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="Runningtext">'),
	$this->form->input->html('</div>')
);
?>

<div class="widget-container">
	<div class="widget-title">
		<h5>Running Text</h5>
	</div>
	<?=$this->form->getForm('edit',$sqltable,$params,$formName='runningtext',$submitValue='Update Running Text');?>
</div>