<?php if (!defined('basePath')) exit('No direct script access allowed');

$sqltable = array(
	'table'	=> $this->table_prefix.'config',
	'id'	=> 1
);

$params = array(
	$this->form->input->image('Logo','add_company_logo',uploadPath.'modules/siteconfig/',uploadPath.'modules/siteconfig/thumbs/'),
	$this->form->input->image('Favicon','add_favicon',uploadPath.'modules/siteconfig/',uploadPath.'modules/siteconfig/thumbs/'),
	$this->form->input->image('Default Image <small class="text-warning">(Best size 1600px x 500px)</small>','add_default_img',uploadPath.'modules/siteconfig/',uploadPath.'modules/siteconfig/thumbs/','image', $setWidth=1600),
	
	//Hidden Value
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="logo">')
);

$this->form->getForm('edit',$sqltable,$params,$formName='general',$submitValue='Save all changes');
?>