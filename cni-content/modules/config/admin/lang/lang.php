<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->uri(3)){
	
	case 'manage':
	
		$includeFile 	= modulePath.$this->thisModule().'/admin/lang/lang.manage.php';
		$generalActive 	= 'nav-menu';
		$manageActive 	= 'nav-menu active';
	break;
		
	default:
		$includeFile = modulePath.$this->thisModule().'/admin/lang/lang.main.php';
		$generalActive 	= 'nav-menu active';
		$manageActive 	= 'nav-menu';
		break;
}

$arrTabs  = array(
	
	'general' 	=> array(
							'title'		=>	'General',
							'icon'		=>	'bookmark',
							'active'	=>	$generalActive,
							'url'		=>	$this->adminURL().'language'.$this->permalink()
						),
	'manage' 	=> array(
							'title'		=>	'Manage Language',
							'icon'		=>	'flag',
							'active'	=>	$manageActive,
							'url'		=>	$this->adminURL().'language/manage'.$this->permalink()
						)
);
$navMenu = '';
foreach($arrTabs as $v){
	$navMenu .= '<li class="'.$v['active'].'"><a href="'.$v['url'].'">'.$v['title'].'</a></li>';
}
$navMenu = '<ul class="nav-group">'.$navMenu.'</ul>';
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<?php echo $navMenu?>
		</div>
	</div>	
	<div class="box-body">
		<div class="widget-main">
			<div class="dd" id="data-menu">
				<?php include($includeFile); ?>
			</div>
		</div>
	</div>
</div>