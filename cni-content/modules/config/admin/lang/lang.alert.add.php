<?php if (!defined('basePath')) exit('No direct script access allowed');

$sqltable = array(
	'table'	=> $this->table_prefix.'lang'
);

$params = array(
    $this->form->input->html($this->langTabs()),
	$this->form->input->text('Name', 'add_name',92),
	$this->form->input->text('Value', 'add_value',65,$multilang=true)
);
?>

<h3>Add Variable</h3>
<?$this->form->getForm('add',$sqltable,$params,$formName='alert',$submitValue='Add Variable',true);?>