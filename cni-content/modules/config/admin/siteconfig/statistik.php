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
	$this->form->input->textarea('','add_statistik',65,3,$editor=false,$comment=''),
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="Statistik">'),
	$this->form->input->html('</div>')
);
?>

<div class="widget-container">
	<div class="widget-title">
		<h5>Script Statistik Vistor</h5>
	</div>
	<?=$this->form->getForm('edit',$sqltable,$params,$formName='statistikvisitor',$submitValue='Update Statistik Visitor Script');?>
</div>