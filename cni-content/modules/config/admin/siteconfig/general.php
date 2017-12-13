<? if (!defined('basePath')) exit('No direct script access allowed');

$sqltable = array(
	'table'	=> $this->table_prefix.'config',
	'id'	=> 1
);

$params = array(
    $this->form->input->html($this->langTabs()),
	$this->form->input->text('Site Title', 'add_site_title',92),
	$this->form->input->text('Site Tagline', 'add_site_tagline',92),
	$this->form->input->textarea('Description', 'add_site_description',65,5,$editor=false,$multilang=true,$comment='Deskripsi singkat website'),
	$this->form->input->textarea('Keyword', 'add_site_keyword',65,3,$editor=false,$multilang=true,$comment='Antar keyword pisahkan dengan koma (,)'),
	$this->form->input->textarea('Footer', 'add_site_footer',65,2,$editor=false),
	
	//Hidden Value
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="general">')
);

$this->form->getForm('edit',$sqltable,$params,$formName='general',$submitValue='Save all changes');
?>