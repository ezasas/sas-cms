<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->uri(3)){
		
	case 'icons':
		$includeFile 	= modulePath.$this->thisModule().'/admin/tools/icons.php';
		$formActive 	= 'nav-menu';
		$generalActive 	= 'nav-menu';
		$iconActive 	= 'nav-menu active';
		$syncActive 	= 'nav-menu';
		break;
	
	case 'general':	
		$includeFile 	= modulePath.$this->thisModule().'/admin/tools/tools.main.php';
		$formActive 	= 'nav-menu';
		$generalActive 	= 'nav-menu active';
		$iconActive 	= 'nav-menu';
		$syncActive 	= 'nav-menu';
		break;
	
	case 'sync':	
		$includeFile 	= modulePath.$this->thisModule().'/admin/tools/update.page.php';
		$formActive 	= 'nav-menu';
		$generalActive 	= 'nav-menu';
		$iconActive 	= 'nav-menu';
		$syncActive 	= 'nav-menu active';
		break;

	default:
		$includeFile 	= modulePath.$this->thisModule().'/admin/tools/form.php';
		$formActive 	= 'nav-menu active';
		$generalActive 	= 'nav-menu';
		$iconActive 	= 'nav-menu';
		$syncActive 	= 'nav-menu';
		break;
}

/*
$arrTabs  = array(
	
	'form' 		=> array(
							'title'		=>	'Form Element',
							'icon'		=>	'bookmark',
							'nav-menu active'	=>	$formActive,
							'url'		=>	$this->adminURL().'tools/form'.$this->permalink()
						),
	
	'general' 	=> array(
							'title'		=>	'General',
							'icon'		=>	'bookmark',
							'nav-menu active'	=>	$generalActive,
							'url'		=>	$this->adminURL().'tools/general'.$this->permalink()
						),
	'icons' 	=> array(
							'title'		=>	'Icons',
							'icon'		=>	'flag',
							'nav-menu active'	=>	$iconActive,
							'url'		=>	$this->adminURL().'tools/icons'.$this->permalink()
						)
);
*/

$arrTabs  = array(
	
	'form' 		=> array(
							'title'		=>	'Form Element',
							'icon'		=>	'bookmark',
							'nav-menu active'	=>	$formActive,
							'url'		=>	$this->adminURL().'tools/form'.$this->permalink()
						),	
	'sync' 		=> array(
							'title'		=>	'Synchronize Page',
							'icon'		=>	'bookmark',
							'nav-menu active'	=>	$syncActive,
							'url'		=>	$this->adminURL().'tools/sync'.$this->permalink()
						)
);

$navMenu = '';
foreach($arrTabs as $v){
	$navMenu .= '<li class="'.$v['nav-menu active'].'"><a href="'.$v['url'].'">'.$v['title'].'</a></li>';
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