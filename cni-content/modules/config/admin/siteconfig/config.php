<?php if (!defined('basePath')) exit('No direct script access allowed');

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
	
		'main' 		=> 'Main',
		'top' 		=> 'Top',
		'bottom' 	=> 'Bottom',
		'left' 		=> 'Left',
		'right' 	=> 'Right'
	)
);

#Lang
$lang = array(
	
	'in' 		=> 'Indonesia',
	'en' 		=> 'English'
);
$arrLang = array(

	$this->form->input->radio('Default Language','add_default_lang',$lang)
);


$params = array(

	//General
	$this->form->input->html('<div class="tab-general"'.$generalClass.'>'),
		#$this->form->input->text('Domain', 'add_site_domain',40, $comment='Ex : www.domain.com'),
		$this->form->input->radio('Default Language','add_default_lang',$lang),
		$this->form->input->text('Site Title', 'add_site_title',92),
		$this->form->input->textarea('Description', 'add_site_description',65,5,$editor=false,$comment='Deskripsi singkat website'),
		$this->form->input->textarea('Keyword', 'add_site_keyword',65,3,$editor=false,$comment='Antar keyword pisahkan dengan koma (,)'),
		$this->form->input->text('Email Account', 'add_email_account',40),
		$this->form->input->text('Email Alternatif', 'add_alternate_email',40),
		$this->form->input->file('Logo','add_company_logo',uploadPath.'modules/siteconfig/','','image'),
		$this->form->input->file('Favicon','add_favicon',uploadPath.'modules/siteconfig/','','image'),
		$this->form->input->textarea('Footer', 'add_site_footer',65,2,$editor=false),
	$this->form->input->html('</div>'),
	
	//Social Media
	$this->form->input->html('<div class="tab-ss"'.$menuClass.'>'),		
		$this->form->input->text('Twitter Link', 'add_twitter',40),
		$this->form->input->text('Facebook Link', 'add_facebook',40),
	$this->form->input->html('</div>'),
	
	//Menu
	$this->form->input->html('<div class="tab-menu"'.$menuClass.'>'),
		$this->form->input->checkbox('Public','add_menu_public',$publicMenu),
		$this->form->input->checkbox('Admin','add_menu_admin',$adminMenu),
	$this->form->input->html('</div>'),
	
	//Hidden Value
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="general">')
);

echo $this->form->getForm('edit',$sqltable,$params,$formName='siteconfig');
?>