<?php
$sas_path = dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME']))));
require $sas_path.'/config/config.php';
require $sas_path.'/constants.php';
require $sas_path.'/load.php';

$sas = new system;

function checkAuth($sas) {
	
	if($sas->auth->admin()){

		if(!isset($_SESSION['KCFINDER']['disabled'])) {
			$_SESSION['KCFINDER']['disabled'] = false;
		}
		$_SESSION['KCFINDER']['_check4htaccess'] = false;
		$_SESSION['KCFINDER']['uploadURL'] = '/'.uploadURL.'files/';
		$_SESSION['KCFINDER']['uploadDir'] = uploadPath.'files/';
		$_SESSION['KCFINDER']['theme'] = 'default';
	}
	else{
		@$_SESSION['KCFINDER'] = array();
	}
}
checkAuth($sas);
?>