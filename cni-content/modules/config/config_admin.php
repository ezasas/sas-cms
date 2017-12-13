<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){	
	
	/* Appearence */
	case 'appearence':
		include modulePath.$this->thisModule().'/admin/appearence/appearence.php';
		include modulePath.$this->thisModule().'/help/appearence.php';
		$this->addHelp($help,'',400);
		break;
	
	/* Configuration */
	case 'config':
		include modulePath.$this->thisModule().'/admin/configuration/configuration.php';
		include modulePath.$this->thisModule().'/help/configuration.php';
		$this->addHelp($help,'',400);
		break;
	
	/* Menu */
	case 'menu':
		include modulePath.$this->thisModule().'/admin/menu/menu.php';
		include modulePath.$this->thisModule().'/help/main_menu.php';
		$this->addHelp($help,'',400);
	break;	
	case 'menu_edit':
		include modulePath.$this->thisModule().'/admin/menu/menu.edit.php';
		include modulePath.$this->thisModule().'/help/edit_menu.php';
		$this->addHelp($help,'',400);
		break;	
	
	/* Pages */
	case '_page':
		include modulePath.$this->thisModule().'/admin/pages/pages.edit.php';
		include modulePath.$this->thisModule().'/help/edit.php';
		$this->addHelp($help,'',400);
		break;	
	case 'page':
		include modulePath.$this->thisModule().'/admin/pages/pages.php';
		include modulePath.$this->thisModule().'/help/main.php';
		$this->addHelp($help,'',400);
		break;	
	case 'page_add':
		include modulePath.$this->thisModule().'/admin/pages/pages.add.php';
		include modulePath.$this->thisModule().'/help/add.php';
		$this->addHelp($help,'',400);
		break;	
	case 'page_edit':
		include modulePath.$this->thisModule().'/admin/pages/pages.edit.php';
		break;	
	
	/* Settings */
	case 'site_config':
		include modulePath.$this->thisModule().'/admin/siteconfig/siteconfig.php';	
		include modulePath.$this->thisModule().'/admin/siteconfig/help/siteconfig.php';
		$this->addHelp($help,'',400);
	break;
	
	/* User */
	case 'user':
		include modulePath.$this->thisModule().'/admin/user/user.list.php';
		include modulePath.$this->thisModule().'/help/main_user.php';
		$this->addHelp($help,'',400);
		break;	
	case 'user_add':
		include modulePath.$this->thisModule().'/admin/user/user.add.php';
		include modulePath.$this->thisModule().'/help/add_user.php';
		$this->addHelp($help,'',400);
		break;	
	case 'user_edit':
		include modulePath.$this->thisModule().'/admin/user/user.edit.php';
		include modulePath.$this->thisModule().'/help/edit_user.php';
		$this->addHelp($help,'',400);
		break;	
	case 'user_profile':
		include modulePath.$this->thisModule().'/admin/user/user.profile.php';
		break;	
	case 'user_account':
		include modulePath.$this->thisModule().'/admin/user/user.account.php';
		break;	
	case 'group':
		include modulePath.$this->thisModule().'/admin/user/group.php';
		break;	
	case 'group_permission':
		include modulePath.$this->thisModule().'/admin/user/group.permission.php';
		break;	
	
	/* modules */
	case 'modules':	
		require modulePath.'config/admin/modules/module.scan.php';
		include modulePath.$this->thisModule().'/admin/modules/module.php';	
		break;	
	
	/* widget */
	case 'widget_main':	
		require modulePath.'config/admin/widget/widget.php';
		include modulePath.$this->thisModule().'/help/main_widget.php';
		$this->addHelp($help,'',400);
		break;		
	case 'widget_add':	
		require modulePath.'config/admin/widget/widget.add.php';
		break;		
	case 'widget_edit':	
		require modulePath.'config/admin/widget/widget.edit.php';
		break;	
	
	/* templates */
	case 'templates':	
		include modulePath.$this->thisModule().'/admin/templates/templates.php';	
		break;	
	
	/* slider */
	case 'slider':
		include modulePath.$this->thisModule().'/admin/slider/slider.php';	
		break;	
	
	/* welcome */
	case 'welcome':
		include modulePath.$this->thisModule().'/admin/welcome/welcome.php';	
		break;		
		
	/* language */
	case 'lang_main':
		include modulePath.$this->thisModule().'/admin/lang/lang.php';	
	break;	
	
	/* tools */
    case 'tools':
		include modulePath.$this->thisModule().'/admin/tools/tools.php';	
	break;
	
	/* default */
	default:
		$this->_404();
		break;
}
?>