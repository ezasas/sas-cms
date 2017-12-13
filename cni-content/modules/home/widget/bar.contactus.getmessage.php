<?php if(!defined('basePath')) exit('No direct script access allowed'); 

$arrNewContact 	= $this->db->getAll("select contact_id,contact_name,contact_email,contact_message,contact_date from ".$this->table_prefix."contact where contact_type='contact' and contact_reply=0 order by contact_id desc");
$contatUrl		= $this->adminUrl().'contact-us'.$this->permalink();
$nContactList  	= '';

$i = 0;
foreach($arrNewContact as $xContact){
	
	$contactDate = get_date($xContact['contact_date'],$this->lang('month'),$this->lang('day'),$setDay=false);
	$nContactList .= '
		
		<li class="message-item">
			<a href="'.$this->adminUrl().'reply-contact/'.$xContact['contact_id'].$this->permalink().'" class="btn-contact-detail" data-id="'.$xContact['contact_id'].'" data-name="'.$xContact['contact_name'].'" data-email="'.$xContact['contact_email'].'" data-message="'.nl2br($xContact['contact_message']).'" data-date="'.htmlentities($contactDate).'">
				<span class="msg-title">
					<span class="blue">'.$xContact['contact_name'].':</span>
					'.trimContent($xContact['contact_message'],8).'
				</span>

				<span class="msg-time">
					<i class="icon-time"></i>
					<span>'.$contactDate.'</span>
				</span>
			</a>
		</li>
	';
	$i++;
	//if($i==5)break;
}

$totalNContact	= count($arrNewContact);
$getMessageList = empty($nContactList)?'':'<ul class="contact-list">'.$nContactList.'</ul>';
//$getMessageList = empty($nContactList)?'':$nContactList;

$response = array(

	'totalMessage' => $totalNContact,
	'getMessageList' => $getMessageList,
	'contatUrl' => $contatUrl
);

echo json_encode($response);
?>