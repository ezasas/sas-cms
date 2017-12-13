<?php if (!defined('basePath')) exit('No direct script access allowed');

$this->form->beforeInsert('cek()');

function cek(){
	
	global $system;
	
	$error = false;
	$alert = '';
	
	if($system->site->isMultiLang()){
	
		foreach($system->site->lang() as $langID=>$langVal){
			
			@$sc .= '
			
				elseif(empty($_POST[\'add_post_title_'.$langID.'\'])){
					$error = true;
					$alert = "Title '.strtoupper($langVal).' cannot be empty.";
				}
				elseif(empty($_POST[\'add_post_content_'.$langID.'\'])){
					$error = true;
					$alert = "Content Text '.strtoupper($langVal).' cannot be empty.";
				}
				elseif(empty($_POST[\'add_post_description_'.$langID.'\'])){
					$error = true;
					$alert = "Description '.strtoupper($langVal).' cannot be empty.";
				}
				elseif(empty($_POST[\'postImages\'][\'name\'][0])){
					$error = true;
					$alert = "Featured Image required.";
				}
			';
		}
	}
	else{
	
		@$sc = '
			
			elseif(empty($_POST[\'add_post_title\'])){
				$error = true;
				$alert = "Title cannot be empty.";
			}
			elseif(empty($_POST[\'add_post_content\'])){
				$error = true;
				$alert = "Content Text cannot be empty.";
			}
			elseif(empty($_POST[\'add_post_description\'])){
				$error = true;
				$alert = "Description cannot be empty.";
			}
			elseif(empty($_POST[\'postImages\'][\'name\'][0])){
					$error = true;
					$alert = "Featured Image required.";
				}
		';
	}
	
	$sc = substr(trim($sc),4);
	
	eval($sc);
	
	$response = array(
		
		'error' => $error,
		'alert' => $alert
	);
	
	return $response;	
}

$this->form->getForm('add',$sqltable,$params,$formName='content',$submitValue='Add Post',$finishButton=true,false);
?>