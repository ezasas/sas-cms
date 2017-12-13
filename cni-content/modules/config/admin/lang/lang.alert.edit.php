<?php if (!defined('basePath')) exit('No direct script access allowed');

$postID   = !empty($xContentID)?$xContentID:intval($this->uri(5));
$sqltable = array(
	'table'	=> $this->table_prefix.'lang',
	'id'	=> $postID
);

$params = array(
    $this->form->input->html($this->langTabs()),
	$this->form->input->text('Name', 'add_name',92),
	$this->form->input->text('Value', 'add_value',65,$multilang=true)
);
?>

<h3>Edit Variable</h3>
<?$this->form->getForm('edit',$sqltable,$params,$formName='alert',$submitValue='Update Variable',true);?>