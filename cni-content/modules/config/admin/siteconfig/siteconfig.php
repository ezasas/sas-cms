<?php if (!defined('basePath')) exit('No direct script access allowed');

//$this->addHelp(content,include file,width);
//$this->addHelp('',modulePath.$this->thisModule().'/admin/siteconfig/help/general.php',500);

if($this->admin('group_id')==1){
	$arrTabs  = array(
		
		'general' 		=> array(
								'title'		=>	'General',
								#'content'	=>	'General',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/general.php'
							),
		'company' 	=> array(
								'title'		=>	'Company',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/company.php'
							),
		'socialmedia' 	=> array(
								'title'		=>	'Social Media',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/socialmedia.php'
							),
		'logo' 			=> array(
								'title'		=>	'Logo & Default Image',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/logo.php'
							),
		'admin' 	=> array(
								'title'		=>	'Admin Skin',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/admin.skin.php'
							),
		'thumbnail' 	=> array(
								'title'		=>	'Thumbnail Width',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/thumbnail.php'
							),
		'menu' 	=> array(
								'title'		=>	'Menu',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/menu.php'
							)
	);
}
else{
	
	$arrTabs  = array(
	
		'general' 		=> array(
								'title'		=>	'General',
								#'content'	=>	'General',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/general.php'
							),
		'company' 	=> array(
								'title'		=>	'Company',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/company.php'
							),
		'socialmedia' 	=> array(
								'title'		=>	'Social Media',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/socialmedia.php'
							),
		'logo' 			=> array(
								'title'		=>	'Logo & Default Image',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/logo.php'
							),
		'admin' 	=> array(
								'title'		=>	'Admin Skin',
								'file'		=>	modulePath.$this->thisModule().'/admin/siteconfig/admin.skin.php'
							)
	);
}

$activeTab 	  = isset($_POST['active_tab'])?$_POST['active_tab']:'general';

echo $this->tab($arrTabs);

?>

<!-- Script -->
<script>
	var activeLangTab = '<?=$activeTab?>'
	function langtabs(tabID){
		$("#nav-tab-"+activeLangTab).removeClass("active");
		$("#nav-tab-"+tabID).addClass("active");
		$(".tab-"+activeLangTab).hide();
		$(".tab-"+tabID).show();
		$(".active_tab").val(tabID);
		activeLangTab = tabID;
		return false;
	}
</script>