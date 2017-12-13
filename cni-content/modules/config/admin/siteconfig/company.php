<?if (!defined('basePath')) exit('No direct script access allowed');

$sqltable = array(
	'table'	=> $this->table_prefix.'config',
	'id'	=> 1
);

$params = array(

	$this->form->input->text('Name', 'add_company_name',40),
	$this->form->input->textarea('Address', 'add_company_address',40,2),
	$this->form->input->text('Telephone', 'add_company_phone',40),
	$this->form->input->text('Mobile', 'add_company_mobile',40),
	$this->form->input->text('Fax', 'add_company_fax',40),
	$this->form->input->text('Email Account', 'add_email_account',40),
	
	//Hidden Value
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="company">')
);

$this->form->getForm('edit',$sqltable,$params,$formName='company',$submitValue='Save all changes');
?>