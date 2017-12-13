<?php if (!defined('basePath')) exit('No direct script access allowed');

$arrTabs  = array(
	
	'profile'	=> 	array(
						'title'		=>	'Edit Profile',
						'file'		=>	modulePath.$this->thisModule().'/admin/user/user.edit.profile.php'
					),
	'password' 	=>	array(
						'title'		=>	'Change Password',
						'file'		=>	modulePath.$this->thisModule().'/admin/user/user.edit.password.php'
					)
);

echo $this->tab($arrTabs);
?>