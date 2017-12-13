<?php if(!defined('basePath')) exit('No direct script access allowed'); 

$arrNewContact 	= $this->db->getAll("select contact_id,contact_name,contact_email,contact_message,contact_date from ".$this->table_prefix."contact where contact_type='contact' and contact_reply=0 order by contact_id desc");
$contatUrl		= $this->adminUrl().'contact-us'.$this->permalink();
$nContactList  	= '';

$i = 0;
foreach($arrNewContact as $xContact){
	
	$contactDate = get_date($xContact['contact_date'],$this->lang('month'),$this->lang('day'),$setDay=false);
	$nContactList .= '
		
		<li>
			<a href="'.$this->adminUrl().'reply-contact/'.$xContact['contact_id'].$this->permalink().'" class="btn-contact-detail" data-id="'.$xContact['contact_id'].'" data-name="'.$xContact['contact_name'].'" data-email="'.$xContact['contact_email'].'" data-message="'.$xContact['contact_message'].'" data-date="'.htmlentities($contactDate).'">
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
	if($i==5)break;
}

$cUlClass		= 'pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer';
$totalNContact	= count($arrNewContact);
$getMessageList = empty($nContactList)?'':'	<ul class="'.$cUlClass.'"><li class="nav-header"><i class="icon-envelope-alt"></i>'.$totalNContact.' Messages</li>'.$nContactList.'<li><a href="'.$contatUrl.'">See all messages<i class="icon-arrow-right"></i></a></li></ul>';

$response = array(

	'totalMessage' => $totalNContact,
	'getMessageList' => $getMessageList
);

echo json_encode($response);
?>