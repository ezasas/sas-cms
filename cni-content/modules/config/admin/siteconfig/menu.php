<?if (!defined('basePath')) exit('No direct script access allowed');

$sqltable = array(
	'table'	=> $this->table_prefix.'config',
	'id'	=> 1
);

#Set Menu Position
$publicMenu = array(
	
	'addcheck' => array(
	
		'main' 		=> 'Main',
		'top' 		=> 'Top',
		'left' 		=> 'Left',
		'bottom' 	=> 'Bottom',
		'right' 	=> 'Right',
		'category' 	=> 'Category',
		'user' 		=> 'User'
	)
);

$adminMenu = array(
	
	'addcheck' => array(
	
		'top' 		=> 'Top',
		'left' 		=> 'Left'
	)
);

$params = array(

	$this->form->input->checkbox('Public Menu','add_menu_public',$publicMenu),
	$this->form->input->checkbox('Admin Menu','add_menu_admin',$adminMenu),
	
	//Hidden Value
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="menu">')
);

echo $this->form->getForm('edit',$sqltable,$params,$formName='siteconfig',$submitValue='Save all changes');
?>