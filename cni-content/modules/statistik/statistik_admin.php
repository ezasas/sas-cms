<?if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){
	
	case 'statistics_main':
		include modulePath.$this->thisModule().'/admin/statistik.php';
	break;
}
?>