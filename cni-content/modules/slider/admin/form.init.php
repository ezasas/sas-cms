<?php if (!defined('basePath')) exit('No direct script access allowed'); 
$linkID   = intval($this->uri(3));
$redirect = base64_decode(substr($this->uri(4),3));

// Table Name
$sqltable 	= array(

	'table'	    => $this->table_prefix.'slider',
	'slider_id' => $linkID
);

// Define form field
$params	= array(
	
	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->image('Select image <small class="text-warning">(Best size 1440px x 500px)</small>','add_image',uploadPath.'modules/slider/',uploadPath.'modules/slider/thumbs/','image', $setWidth=1440),
	$this->form->input->text('Title', 'add_title'),
	$this->form->input->text('Tagline', 'add_tagline'),
	$this->form->input->textarea('Description', 'add_description', 20, 3, $editor=false),
	$this->form->input->text('Button label', 'add_btn_caption'),
	$this->form->input->text('Link URL', 'add_url'),
	$this->form->input->html('<div class=" hidden-hr">'),
	$this->form->input->switchcheck('Publish', 'add_publish', $skin=5,$checked=true),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->beforeInsert('cek()');
$this->form->beforeUpdate('cek()');

function cek(){
	
	global $system;
	
	$error = false;
	$alert = '';
	
	@$sc = '
		
		elseif(empty($_POST[\'postImages\'][\'name\'][0])){
			$error = true;
			$alert = "Image required.";
		}
		elseif(empty($_POST[\'add_title\'])){
			$error = true;
			$alert = "Title required.";
		}
	';
	
	$sc = substr(trim($sc),4);
	
	eval($sc);
	
	$response = array(
		
		'error' => $error,
		'alert' => $alert
	);
	
	return $response;	
}
?>