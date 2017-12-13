<?php

/** CNI - PHP SYSTEM class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class System{

	function System(){
	
		global $config;
		
		$this->install();
		$this->dbDriver();
		$this->config 	= $config;
		$this->db 		= NewADOConnection($config['db_diver']);
		
		if (!$this->db->Connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name'])){	
			die( mysql_error() . ' Error while connecting to Database Server');
		}
		$ADODB_FETCH_MODE 	= ADODB_FETCH_ASSOC;
		$this->dbName	 	= $config['db_name'];
		$this->admin_name	= $config['adminName'];
		$this->table_prefix	= $config['tablePrefix'];
		
		$this->site			= new site($this->db,$this->table_prefix);
		$this->auth			= new auth($this->db,$this->table_prefix);
		$this->user			= new user($this->db,$this->table_prefix);
		$this->form			= new form($this->db,$this->table_prefix,$this->site,$this->active_lang(),$this->thisURL(),$this->user,$this->adminTheme(),$this->getThumbnail());
		$this->data			= new data($this->db,$this->table_prefix,$this->site,$this->admin_name,$this->permalink(),$this->thisURL(),$this->thisPage(),$this->adminUrl(),$this->lastUri(),$this->_GET(),$this->active_lang());
		$this->tree			= new tree($this->db,$this->permalink(),$this->lastUri(),$this->adminURL(),$this->thisURL());
		$this->post			= new post($this->db,$this->table_prefix,$this->site,$this->data,$this->permalink(),$this->active_lang());
		$this->device 		= new Mobile_Detect;
		$this->stats		= new stats(); /* Load statistic class */
		//$this->counter		= new counter();
		
		//$this->counter->initSession();
	}
	
	
	/* ---------- Base ---------- */
	
	function thisURI(){
	
		if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
			$uri = 'https://';
		} else {
			$uri = 'http://';
		}
		$uri .= $_SERVER['HTTP_HOST'].'/';
		
		return $uri;
	}
	function uri($segment){

		$requestURI = $this->config['permalink']=='.html'?get_string_before(requestURI,'.html'):requestURI;
		$requestURI = $this->config['permalink']=='.html' && !preg_match('/.html/i',requestURI)?requestURI:$requestURI;
		$this->uri  = explode('/',str_replace($this->config['baseURL'],'',$requestURI));
		
		if(array_key_exists($segment, $this->uri)){
			
			$thisUri = $this->permalink()!='/'?str_replace($this->permalink(),'',$this->uri[$segment]):$this->uri[$segment];
			return $thisUri;
		}
		else{
			return null;
		}
	}
	function lastUri(){
		$arrUri   = $this->uri;
		$uri	  = array();
		foreach($arrUri as $k => $v){
			
			if(!empty($v)){
				$uri[] = $v;
			}
		}

		$countUri = count($uri)-1;
		$lastUri  = @$uri[$countUri];
		return $lastUri;
	}
	function redirect($url){
		header('location:'.$url);
	}
	function logoutURL(){
		$logoutURL = $this->uri(1)==$this->admin_name?$this->adminURL().'logout'.$this->permalink():themeURL.'user/logout'.$this->permalink();
		return $logoutURL;
	}
	function reloginURL(){
		$logoutURL = $this->adminURL().'relogin'.$this->permalink();
		return $logoutURL;
	}
	function adminURL(){
		$adminURL = baseURL.$this->admin_name.'/';
		return $adminURL;
	}
	function activeTheme(){
		if($this->_GET('theme'))setcookie("active_theme", $this->_GET('theme'), time()+3600,"/".$this->config['baseURL']);
		$activeTheme = @$this->cookie('active_theme')?$this->cookie('active_theme'):$this->site->theme();
		$activeTheme = $this->_GET('theme')?$this->_GET('theme'):$activeTheme;
		return $activeTheme;
	}
	function themeURL($path=''){
		if(!empty($path)){
			switch($path){
				case 'admin': $themeURL = baseURL.$this->adminTheme();break;
				case 'public': $themeURL = themeURL.$this->activeTheme().'/';break;
			}
		}
		else{
			$themeURL = $this->uri(1)==$this->admin_name?baseURL.$this->adminTheme():themeURL.$this->activeTheme().'/';
		}
		return $themeURL;
	}
	function themePath($path=''){
		if(!empty($path)){
			switch($path){
				case 'admin': $themePath = basePath.$this->adminTheme();break;
				case 'public': $themePath = themePath.$this->activeTheme().'/';break;
			}
		}
		else{
			$themePath = $this->uri(1)==$this->admin_name?basePath.$this->adminTheme():themePath.$this->activeTheme().'/';
		}
		return $themePath;
	}			
	function thisURL(){
	
		$thisUrl = substr(str_replace($this->config['baseURL'],'',requestURI),1);		
		$thisUrl = baseURL.$thisUrl;
		
		return $thisUrl;
	}
	
	/* ---------- Lang ---------- */
	
	function active_lang(){
		
		$cookieLang  = @$this->cookie('active_lang');		
		$defaultLang = $this->site->default_lang();
		$lang 		 = $this->uri(1)==$this->admin_name?'admin':'public';
		$activeLang  = isset($cookieLang[$lang])?$cookieLang[$lang]:$defaultLang[$lang];
		
		return $activeLang;
	}
	function change_lang($lang,$langID){
		setcookie('active_lang['.$lang.']', $langID, time()+60*60*7, '/', NULL);
	}	
	function langTabs(){
	
		// Create lang tabs
		if($this->site->isMultiLang()){

			$getLang  = $this->site->getLang();	
			$tabNav	  = '<ul class="nav nav-tabs nav-lang">';
			$tabs	  = '';

			foreach($this->site->lang() as $langID=>$langVal){
				
				if($langID == $this->active_lang()){
					$firstTab = '<li id="nav-tab-'.$langID.'" class="active"><a href="#" onclick="return langtabs(\''.$langID.'\')"><span class="flag-icon '.$getLang['icon'][$langID].'"></span>'.$langVal.'</a></li>';
				}
				else{
					$tabs .= '<li id="nav-tab-'.$langID.'"><a href="#" onclick="return langtabs(\''.$langID.'\')"><span class="flag-icon '.$getLang['icon'][$langID].'"></span>'.$langVal.'</a></li>';
				}
			}
			$tabNav .= $firstTab.$tabs;
			$tabNav .= '</ul>';
			$tabNav .= '
				
				<script>
					var activeLangTab = \''.$this->active_lang().'\'
					function langtabs(langID){
						$("#nav-tab-"+activeLangTab).removeClass("active");
						$("#nav-tab-"+langID).addClass("active");
						$(".tab-"+activeLangTab).hide();
						$(".tab-"+langID).show();
						activeLangTab = langID;
						return false;
					}
				</script>
			';
		}
		else{
			$tabNav = '';
		}
		
		return $tabNav;
	}
	
	function langButton(){

		$langButton = '';
		
		if($this->site->isMultiLang()){

			$getLang  	= $this->site->getLang();	
			$langs	   	= '';
			$active     = '';
			$nonactive  = '';
			
			foreach($this->site->lang() as $langID=>$langVal){
				
				if($langID == $this->active_lang()){
					$langs .= '<li id="nav-lang-'.$langID.'" class="active"><span class="flag-icon '.$getLang['icon'][$langID].'"></span>'.$langVal.'</li>';
				}
				else{
					$langs .= '<li id="nav-lang-'.$langID.'"><a href="'.baseURL.'lang/'.$langID.'" title="'.$langVal.'"><span class="flag-icon '.$getLang['icon'][$langID].'"></span>'.$langVal.'</a></li>';
					$nonact=$langID;
				}
			}
			
			$langButton   = '<ul class="lang-button">'.$langs.'</ul>';
		}
		
		return $langButton;
	}
	
	function lang($lang=''){
		$getLang = $this->site->isMultiLang()?$this->active_lang():'en';
		if(file_exists(systemPath.'lang/'.$getLang).'.php'){
			include systemPath.'lang/'.$getLang.'.php';			
			if(!empty($lang))return @$_LANG[$lang];
			else return $_LANG;
		}
		else{
			return 'Lang <strong>'.strtoupper($this->active_lang()).'</strong> doesn\'t exists';
		}		
	}
	
	/* ---------- Theme ---------- */
	
	function loadTheme(){

		$this->activeTheme();if($this->_GET('theme'))$this->redirect(baseURL);
		$this->licence();
		$this->checkTheme();	
		
		if($this->uri(2)=='?'.$this->admin_name) $this->redirect(baseURL.$this->admin_name.'/'); // iki htaccess'e
		
		switch($this->uri(1)){
			
			case $this->admin_name:
			
				if(!$this->auth->admin()){

					$this->session_unset('adminmenu');
					
					if($this->uri(2)!='login'){
					
						$redirectURL = base64_encode($this->thisURL());
						$loginURL	 = base64_encode($this->adminURL());						
						$redirect 	 = $redirectURL!=$loginURL?'?r='.$redirectURL:'';
						
						$this->redirect(baseURL.$this->admin_name.'/login'.$this->permalink().$redirect);exit();
					}
					else{
						
						$this->ErrorLogin = '';
						
						//Submit login
						if(isset($_POST['login'])){
							
							$scode = md5(base64_encode($_POST['scode']));
							if($scode==$this->session('scode')){
								
								$tableName = $this->table_prefix.'user';
								$tableRef  = $this->table_prefix.'user_group';
								
								$usname	= anti_injection($_POST['username']);
								$pswd	= anti_injection(md5(base64_encode($_POST['pass'])));
			
								$query 	= "select ".$tableName.".id,".$tableName.".group_id,".$tableName.".name,".$tableName.".email,".$tableName.".image,".$tableRef.".name as group_name from ".$this->table_prefix."user left join ".$tableRef." on(".$tableName.".group_id=".$tableRef.".group_id) where ".$tableName.".username='".$usname."' and ".$tableName.".pass='".$pswd."' and ".$tableName.".active=1";
								$rsUser	= $this->db->execute($query);
								
								if($rsUser->recordCount()>0){
								
									$userData = $this->db->getArray($query);
									foreach($userData as $v){
										extract($v);
									}
									$user['session']	= $this->session('scode');
									$user['id']			= $v['id'];
									$user['group_id']	= $v['group_id'];
									$user['group_name']	= $v['group_name'];
									$user['name']		= $v['name'];
									$user['email']		= $v['email'];
									$user['image']		= empty($v['image'])?'default.jpg':$v['image'];
									$user['access']		= $this->user->getPermission($user['group_id']);
								
									$lastLogin 			= date('Y-m-d h:i:s');
									$lastLoginFrom 		= getClientIP().':'.$_SERVER['REMOTE_PORT'];
									
									$this->db->execute("
									
										update 
											".$this->table_prefix."user 
										set 
											authsession='".$user['session']."', 
											lastLogin='".$lastLogin."', 
											lastLoginFrom='".$lastLoginFrom."' 
										where 
											id='".$user['id']."'
									");
									
									$this->session_set(array('admin'=>$user));
									$this->session_unset('scode');
									
									$redirect = baseURL.$this->admin_name.'/';
									if($this->_GET('r')){$redirect = base64_decode($this->_GET('r'));}
									
									$this->redirect($redirect);
									exit();
								}
								else{
									$this->ErrorLogin = '<i class="icon-exclamation"></i> Incorect username or password combination';
								}
							}
						}
						//End submit
						
						require($this->themePath().'login.php');
					}
				}
				else{
				
					switch($this->uri(2)){
						
						case 'login':
							$this->redirect(baseURL.$this->admin_name); 
							break;
							
						case 'logout':
							$user = @$this->session('admin');
							$this->db->execute("update ".$this->table_prefix."user set authsession='' where id='".$user['id']."'");
							$this->session_unset('admin');
							$this->session_unset('adminmenu');
							$this->redirect(baseURL.$this->admin_name.'/login'.$this->permalink());
							break;
							
						case 'relogin':
						
							$sessUser  = @$this->session('admin');
							
							$this->db->execute("update ".$this->table_prefix."user set authsession='' where id='".$sessUser['id']."'");
							
							$tableName = $this->table_prefix.'user';
							$tableRef  = $this->table_prefix.'user_group';
		
							$query 	= "select ".$tableName.".id,".$tableName.".group_id,".$tableName.".name,".$tableName.".email,".$tableName.".image,".$tableRef.".name as group_name from ".$this->table_prefix."user left join ".$tableRef." on(".$tableName.".group_id=".$tableRef.".group_id) where ".$tableName.".id='".$sessUser['id']."' and ".$tableName.".active=1";
							$rsUser	= $this->db->execute($query);
							
							$userData = $this->db->getArray($query);
							foreach($userData as $v){
								extract($v);
							}
							
							$this->session_unset('admin');
							$this->session_unset('adminmenu');
							
							$code 		  		= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							$securityCode 		= substr(str_shuffle($code),0,10);							
							$user['session']	= md5(base64_encode($securityCode));
							$user['id']			= $v['id'];
							$user['group_id']	= $v['group_id'];
							$user['group_name']	= $v['group_name'];
							$user['name']		= $v['name'];
							$user['email']		= $v['email'];
							$user['image']		= empty($v['image'])?'default.jpg':$v['image'];
							$user['access']		= $this->user->getPermission($user['group_id']);
						
							$lastLogin 			= date('Y-m-d h:i:s');
							$lastLoginFrom 		= getClientIP().':'.$_SERVER['REMOTE_PORT'];
							adodb_pr($user);
							$this->db->execute("
							
								update 
									".$this->table_prefix."user 
								set 
									authsession='".$user['session']."', 
									lastLogin='".$lastLogin."', 
									lastLoginFrom='".$lastLoginFrom."' 
								where 
									id='".$user['id']."'
							");
							
							$this->session_set(array('admin'=>$user));
							
							$redirect = baseURL.$this->admin_name.'/';
							if($this->_GET('r')){$redirect = base64_decode($this->_GET('r'));}
							
							$this->redirect($redirect);exit();							
							break;
						
						default:
							$adminSess 		= @$this->session('admin'); 
							$getAdminAccess = !is_array(@$adminSess['access'])?array():$adminSess['access'];
							
							if($this->thisPageID() && !in_array($this->thisPageID(),$getAdminAccess)){
								
								if ($this->thisPageID()){
									echo 'access denied';
								}
							}
							else require($this->themePath().'index.php');
							break;
					}	
				}
				break;
			
			case 'system':
				
				if($this->uri(2)=='del'){
					
					if($this->auth->admin()){
						
						$addUri			= '';
						$tablename		= $this->uri(3);
						$tableID		= $this->uri(4);
						$tableValID		= $this->uri(5);
						$getRedirect 	= get_string_between(requestURI, 'redirect=', '&scode=');		
						$getToken	 	= str_replace('scode=','',get_string_after(requestURI,'&scode='));	
					
						if(!$this->config['demo']){
						
							if(md5(base64_encode($getToken))==$this->session('dcode')){	
							
								$addUri = str_replace($mCode,'',$getRedirect);							
								$query 	= "delete from ".$tablename." where ".$tableID." ='".$tableValID."'" ;
								$addUri = !$this->db->execute($query)?'?m=1':'?m=0';								
							}
							$this->redirect($getRedirect);
							exit();
						}
						else{
							$dm 		  = preg_match('/\b\?\b/i',$getRedirect)?'&dm=1':'?dm=1';
							$getRedirect .= $dm;
							$getVar 	  = get_string_after($getRedirect,'?');
							$arrGetVar	  = explode('&',$getVar);
							$arrPostGet	  = array();
							$postGet	  = '';
							
							foreach($arrGetVar as $v){
								if(!in_array($v,$arrPostGet)){
									$postGet .= '&'.$v;
								}
								$arrPostGet[$v] = $v;
							}
							
							$postGet = substr($postGet,1);
							$getRedirect = get_string_before($getRedirect,'?').'?'.$postGet;
							$this->redirect($getRedirect.$xxx);
							exit();
						}
					}
					else { $this->redirect(baseURL); exit(); }					
				}
				elseif($this->uri(2)=='upload'){
					require(systemPath.'form/form.upload.php');
				}
				elseif($this->uri(2)=='uploadfile'){
					require(systemPath.'form/form.uploadfile.php');
				}
				elseif($this->uri(2)=='ajax'){
					$ajaxFile = get_string_after(requestURI,'?');
					$act	  = $this->uri(3);
					require($ajaxFile);
				}
				else{				
					require($this->themePath().'index.php');
				}
				break;	
				
			default:				
				if($this->device->isMobile()&&isFileExist($this->themePath(),'index.mobile.php'))require_once($this->themePath().'index.mobile.php');
				else require_once($this->themePath().'index.php');
				break;
		}
		if($this->uri(1)!=$this->admin_name&&$this->uri(1)!='system'&&!isset($this->cp)){ob_clean();die("This site has no copyright");}
	}	
	function checkTheme(){
		if(!file_exists($this->themePath().'index.php')){
			echo 'Theme '.$this->activeTheme().' can not be found';die();
		}
		if(isFileExist($this->themePath('public'),'function.php'))include_once $this->themePath('public').'function.php';
	}
	function adminTheme(){
		
		$activeTheme = 'sas';
		$adminTheme  = 'cni-admin/themes/'.$activeTheme.'/';
		
		return $adminTheme;
	}
	function copyright(){		
		$this->cp = @$this->config['copyright'];
		return $this->cp;
	}
	function head(){
		$head = $this->meta().$this->siteTitle().$this->favicon().$this->js();
		return $head;
	}
	function siteTitle(){
		$siteTitle = $this->pageTitle()=='Home' || $this->pageTitle()=='home'?$this->site->title():ucwords($this->pageTitle());
		$siteTitle = $siteTitle!=''?$siteTitle:'404 - '.$this->site->title();
		if($this->uri(1)==$this->admin_name && !$this->auth->admin()){
			$siteTitle = 'Login - '.$this->site->title();
		}		
		elseif($this->uri(1)!=$this->admin_name && $this->uri(1)=='read'){
			$metaPostsId 	= intval($this->uri(2));
			$titlemulti		= $this->site->isMultiLang()?'post_title_'.$this->active_lang():'post_title';
			$siteTitle	 	= $this->db->getOne("select ".$titlemulti." as post_title from ".$this->table_prefix."posts where post_id='".$metaPostsId."' and publish='1'");
		}
		$siteTitle = '<title>'.htmlspecialchars_decode(html_entity_decode($siteTitle)).'</title>';
		return $siteTitle;
	}
	function favicon(){
		$favicon = '<link rel="icon" href="'.uploadURL.'modules/siteconfig/'.$this->site->favicon().'" type="image/x-icon" />';
		return $favicon;
	}
	function meta(){
		
		require 'meta.php';
		
		$setMeta   = '';
		$setFbMeta = '';
		
		foreach($meta as $k => $v){
			$setMeta .= '<meta content="'.$v.'" name="'.$k.'">';
		}
		
		foreach($fbMeta as $k => $v){
			$setFbMeta .= '<meta property="'.$k.'" content="'.$v.'" />';
		}

		$meta   = '<meta charset="ISO-8859-1">';
		$meta  .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		
		if(!empty($setMeta)){
			
			$meta  .= $setMeta;
		}
		else{
			$meta .= '<meta content="'.strip_tags($this->siteTitle()).'" name="title">';
			$meta .= '<meta content="'.$this->site->keyword().'" name="keywords">';
			$meta .= '<meta content="'.$this->site->description().'" name="description">';
		}
		return $meta.$setFbMeta;
	}
	function addMeta($name,$content){
		$meta = '<meta name="'.$name.'" content="'.$content.'"/>';
		return $meta;
	}
	function css(){
		$css = '<link rel="stylesheet" type="text/css" href="'.$this->themeURL().'css/style.css">';
		return $css;
	}
	function js(){
		$js = '
		
			<script type="text/javascript">
				var basePath="'.basePath.'";
				var baseURL="'.baseURL.'";
				var systemURL="'.systemURL.'";
				var themeURL="'.$this->themeURL().'";
				var ajaxURL="'.ajaxURL.'?";
			</script>
		';
		
		return $js;
	}
	function load_css($cssPath){
		$load_css = '<link rel="stylesheet" type="text/css" href="'.$cssPath.'?v.'.mt_rand(1,9).'.'.mt_rand(1,9).'">';
		echo $load_css;
	}
	function load_js($jsPath){
		$load_js = '<script type="text/javascript" src="'.$jsPath.'?v.'.mt_rand(1,9).'.'.mt_rand(1,9).'"></script>';
		echo $load_js;
	}
	function load_js_utf8($jsPath){
		$load_js = '<script type="text/javascript" charset="utf-8" src="'.$jsPath.'"></script>';
		echo $load_js;
	}
	function logo(){
		
		$logo = $this->site->logo();
		$logo = '<img src="'.uploadURL.'modules/siteconfig/'.$logo.'" />';

		return $logo;
	}
	function getHeader(){
		$file = $this->themePath().'header.php';
		include($file);
	}
	function getFooter(){
		$file = $this->themePath().'footer.php';
		include($file);
	}
	function getTopbar($position=''){
	
		$fileName = $position==''?'topbar'.$position.'.php':'topbar.'.$position.'.php';
		
		if(isFileExist($this->themePath(),$fileName)){
		
			$file = $this->themePath().$fileName;
			include($file);
		}
		else{
			echo 'file not found : topbar.'.$position.'.php';
		}
	}
	function getSidebar($position=''){
	
		$fileName = $position==''?'sidebar'.$position.'.php':'sidebar.'.$position.'.php';
		
		if(isFileExist($this->themePath(),$fileName)){
		
			$file = $this->themePath().$fileName;
			include($file);
		}
		else{
			echo 'file not found : sidebar.'.$position.'.php';
		}
	}
	
	
	/* ---------- Blocks/Widget ---------- */
	
	function widget($position){
		
		if($this->site->isMultiLang()){
		
		}
		
		$isFront = $this->thisModule()=="home"?" and (block_page='all' or block_page='home')":" and (block_page='all' or block_page='hidehome')";
		$mTitle	 = $this->site->isMultiLang()?',block_title_'.$this->active_lang():'';
		$rsBlock = $this->db->execute("select block_id,block_name,block_title".$mTitle.",block_title_show,block_position,block_params from ".$this->table_prefix."blocks where block_theme='".$this->activeTheme()."' and block_position='".$position."'".$isFront." and active='1' order by block_order");
		
		$blockTag 	  = 'aside';
		$titleTag 	  = 'h2';
		$contentClass = 'widget-content';
		$blockTitle	  = '';
		
		while($block = $rsBlock->fetchRow()){
			
			
			$fileName = $block['block_name'].'.php';

			if(isFileExist(blockPath.$block['block_name'].'/',$fileName)){

				$startBlock = $block['block_position']!='top' && $block['block_position']!='bottom'?'<'.$blockTag.' id="widget-'.$block['block_id'].'" class="widget">':'';
				$endBlock   = $block['block_position']!='top' && $block['block_position']!='bottom'?'</'.$blockTag.'>':'';
				$xTitle	 	= $this->site->isMultiLang()?$block['block_title_'.$this->active_lang()]:$block['block_title'];
				$blockTitle	= $block['block_title_show']==1?'<'.$titleTag.' class="widget-title">'.$xTitle.'</'.$titleTag.'>':'';
				$file 		= blockPath.$block['block_name'].'/'.$fileName;
				
				//echo $startBlock.$blockTitle;
				//echo '<div class="'.$contentClass.'">';
				
				include($file);
				
				//echo '</div>';
				//echo $endBlock;
			}
			elseif(isFileExist($this->themePath().'blocks/'.$block['block_name'].'/',$fileName)){
			
				$startBlock = $block['block_position']!='top' && $block['block_position']!='bottom'?'<'.$blockTag.' id="widget-'.$block['block_id'].'" class="widget">':'';
				$endBlock   = $block['block_position']!='top' && $block['block_position']!='bottom'?'</'.$blockTag.'>':'';
				$blockTitle	= $block['block_title_show']==1?'<'.$titleTag.' class="widget-title">'.$block['block_title'].'</'.$titleTag.'>':'';
				$file 		= $this->themePath().'blocks/'.$block['block_name'].'/'.$fileName;
				
				//echo $startBlock.$blockTitle;
				//echo '<div class="'.$contentClass.'">';
				
				include($file);
				
				//echo '</div>';
				//echo $endBlock;
			}
			else{
				echo 'Widget '.$fileName.' can not be found : '.$fileName;
			}
		}
	}
	function getWidget($widgetName=''){
	
		$fileName 	= $widgetName.'.php';
		
		if(file_exists(blockPath.$widgetName.'/'.$fileName)){
			$file 		= blockPath.$widgetName.'/'.$fileName;
			include($file);
		}
		elseif(file_exists($this->themePath().'blocks/'.$widgetName.'/'.$fileName)){
			$file 		= $this->themePath().'blocks/'.$widgetName.'/'.$fileName;
			include($file);
		}
		else{
			echo 'Widget '.$widgetName.' can not be found.';
		}
	}
	function setWidget($position=''){
		
		$getPosition = explode(',',$position);
		foreach($getPosition as $v){
			$arrPosition[$v]=ucwords($v);
		}
		
		$this->regWidget = $arrPosition;
	}
	function widgetPosition(){
		
		$regPosition = isset($this->regWidget)?$this->regWidget:array();
		
		return $regPosition;
	}
	function registerWidget($blocks=''){
		
		$getBlocks = explode(',',$blocks);
		foreach($getBlocks as $v){
			$arrBlocks[$v]=ucwords($v);
		}
		
		$this->cWidget = $arrBlocks;
	}
	function registeredWidget(){
		
		$regWidget = isset($this->cWidget)?$this->cWidget:array();
		
		return $regWidget;
	}
	
	
	/* ---------- Permalink ---------- */	
	function permalink(){
		
		$permalink = $this->config['permalink'];
		return $permalink;
	}
	
	
	/* ---------- Page ---------- */
	
	function thisPage(){
		
		$xUri		= $this->uri(1)==$this->admin_name?2:1;
		$xUri		= $this->uri($xUri)=='page'?$xUri+2:$xUri;
		$thisPage	= !$this->uri($xUri)||$this->uri($xUri)=='index.html'?'home':$this->uri($xUri);
		$thisPage	= preg_match('/\?/i',$thisPage)?get_string_before($thisPage,'?'):$thisPage;
		$thisPage	= str_replace($this->permalink(),'',$thisPage);
		
		return $thisPage;
	}
	function thisPageID(){

		$columnName		= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
		$columnUrl 		= $this->isColumnExist($this->table_prefix.'pages',$columnName)?$columnName:'page_url';			
		$getPageId  	= $this->db->getOne("select page_id from ".$this->table_prefix."pages where page_url='".$this->thisPage()."'");
		$getPageLangId  = $this->db->getOne("select page_id from ".$this->table_prefix."pages where ".$columnUrl." = '".$this->thisPage()."'");		
		$thisPageId 	= !empty($getPageLangId) && $getPageLangId!=0?$getPageLangId:$getPageId;
		$thisPageId		= $this->thisPage()=='home'?1:$thisPageId;
		
		if($this->thisPage()=='read'){
		
			$postsId 	= intval($this->uri(2));
			$qryPage 	= "select pa.page_id from cni_pages pa left join cni_posts po on(pa.category_id=po.post_category) where po.post_id='".$postsId."'";
			$thisPageId	= $this->db->getOne($qryPage);
		}		
		
		return $thisPageId;
	}
	function pageURL($pageID=''){
	
		$getPageID 	= empty($pageID)?$this->thisPageID():$pageID;
		$urlField	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';		
		$pageURL 	= $this->db->getOne("select ".$urlField." from ".$this->table_prefix."pages where page_id='".$getPageID."'");
		
		return $pageURL;
	}
	function pageTitle(){
		
		$columnName	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
		$pageName 	= $this->isColumnExist($this->table_prefix.'pages',$columnName)?$columnName:'page_url';
		
		if($this->site->isMultiLang()){
			$pageTitle = $this->db->getOne("select page_name_".$this->active_lang()." from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");		
			if(empty($pageTitle)){
				$pageTitle = $this->db->getOne("select page_name from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");
			}
		}
		else{		
			$pageTitle = $this->db->getOne("select page_name from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");		
		}
		
		$pageTitle = $this->thisPage()=='home'?'Home':$pageTitle;
		$pageTitle = $this->thisPage()=='home' && $this->uri(1)==$this->admin_name?'Dashboard':$pageTitle;
		
		if($this->thisPage()=='read'){
		
			$postsId 	= intval($this->uri(2));
			$qryPage 	= "select pa.page_name from cni_pages pa left join cni_posts po on(pa.category_id=po.post_category) where po.post_id='".$postsId."'";
			$pageTitle	= $this->db->getOne($qryPage);
		}
		elseif($this->thisModule()=='project' && intval($this->uri(2)>0)){
		
			$postsId 	= intval($this->uri(2));
			$qryPage 	= "select post_title from cni_posts where post_id='".$postsId."'";
			$pageTitle	= $this->db->getOne($qryPage);
		}
		
		return html_entity_decode($pageTitle);
	}
	function pageTagline(){
	
		$columnName		= $this->site->isMultiLang()?'page_tagline_'.$this->active_lang():'page_tagline';
		$pageName 		= $this->isColumnExist($this->table_prefix.'pages',$columnName)?$columnName:'page_tagline';
		$pageTagline 	= $this->db->getOne("select ".$pageName." as page_tagline from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");
		
		return html_entity_decode($pageTagline);
	}
	function pageParentID($pageID=''){
		$pageParentID = $this->db->getOne("select parent_id from ".$this->table_prefix."pages where page_id='".$pageID."'");
		return $pageParentID;
	}
	function pageMainParentID($pageID=''){
		$pageID = empty($pageID)?$this->thisMenuID():$pageID;
		$menu = $this->db->getAll("select page_id,parent_id from ".$this->table_prefix."pages where page_id='".$pageID."'");
		
		foreach($menu as $v){extract($v);}
		
		$this->getPageParentID = @$page_id;
		
		if(@$parent_id!=0){
			$this->pageMainParentID($parent_id);
			return $this->getPageParentID;			
		}
		else{
			return $this->getPageParentID;
		}
	}
	
	/* ---------- Module ---------- */
	
	function thisModule(){		
		
		$thisModuleID = $this->db->getOne("select module_name from ".$this->table_prefix."modules where module_id='".$this->thisModuleID()."'");
		return $thisModuleID;
	}
	function thisModuleID(){
	
		$thisModuleID = $this->db->getOne("select module_id from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");
		return $thisModuleID;
	}
	function getModule(){
		
		$moduleName = $this->thisModule();				
		$modulePath = modulePath.$moduleName.'/';
		$module 	= $this->uri(1)==$this->admin_name?$modulePath.$moduleName.'_admin.php':$modulePath.$moduleName.'.php';
		
		$thisModuleID = $this->db->getOne("select module_id from ".$this->table_prefix."modules where module_name='".$moduleName."' and status='1'");

		if($thisModuleID > 0){
			
			if(file_exists($module)){
				include($module);
			}
			else{
				echo $this->form->alert('warning','Oops, module <strong>'.$moduleName.'</strong> cannot be found.');
			}
		}
		else{
			$this->_404();
		}
	}
	
	
	/* ---------- Get Content ---------- */
	
	function getContent(){
	
		if($this->uri(1)==$this->admin_name && $this->thisPage()!='edit-post'){
			
			$this->db->execute("update ".$this->table_prefix."posts set edited='0', edited_by='".$this->admin('id')."' where edited_by='".$this->admin('id')."'");		
		}
		$this->getModule();
	}	
	function getSwitch(){
	
		$getSwitch = $this->db->getOne("select page_switch from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");
		return $getSwitch;
	}
	
	
	/* ---------- Menu ---------- */	
	
	function thisMenuID(){
		$isAdmin = $this->uri(1)==$this->admin_name?1:0;
		$menuID  = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->thisPageID()."' and admin_menu='".$isAdmin."'");		
		return $menuID;
	}
	function mainParentID($menuid=''){
		$menuid = empty($menuid)?$this->thisMenuID():$menuid;
		$menu = $this->db->getAll("select menu_id,parent_id from ".$this->table_prefix."menu where menu_id='".$menuid."'");
		
		foreach($menu as $v){extract($v);}
		
		$this->parentID = @$menu_id;
		
		if(@$parent_id!=0){
			$this->mainParentID($parent_id);
			return $this->parentID;			
		}
		else{
			return $this->parentID;
		}
	}
	function getParentID($menuid=''){
		$parentID = $this->db->getOne("select parent_id from ".$this->table_prefix."menu where menu_id='".$menuid."'");
		return $parentID;
	}
	function generateMenuAdmin($arrMenu,$parent,$menuId,$title,$url,$customLinks,$class){
	
		if(isset($arrMenu[$parent])){			
			
			$dropdownMenu = '';
			$menu 	 = $parent==0?'<ul class="'.$class.'">':'<ul class="treeview-menu">';
			$isAdmin = $this->uri(1)==$this->admin_name?1:0;
			
			foreach($arrMenu[$parent] as $value){
				
				$adminUrl = !empty($value[$url])?baseURL.$this->admin_name.'/':baseURL.$this->admin_name;
				
				$seturl = $adminUrl.$value[$url];
				$seturl = $value[$customLinks]==1?$value[$url]:$seturl;
				$seturl = $seturl.$this->permalink();
				$seturl = $value['module_id']==1?$adminUrl:$seturl;
				$target = $value[$customLinks]==1?' target="_blank"':'';
				$icon	= '<i class="menu-icon '.$value['icon'].'"></i>';
				
				/*
				if(!$this->mainParentID()){
					$mainParentID = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->pageMainParentID($this->thisPageID())."' and admin_menu='".$isAdmin."'");
					$thisMenuID   = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->pageParentID($this->thisPageID())."' and admin_menu='".$isAdmin."'");
				}
				else{
					$mainParentID = $this->mainParentID();
					$thisMenuID   = $this->thisMenuID();
				}
				*/
				
				$child  = $this->generateMenuAdmin($arrMenu,$value[$menuId],$menuId,$title,$url,$customLinks,$class);

				if(!empty($value[$title])){
				
					if($child){
						//$active = $value[$menuId]==$this->getParentID($this->thisMenuID())||$value[$menuId]==$mainParentID||$value[$menuId]==$thisMenuID?' class="active open"':'';
						$menu .= '<li'.@$active.' id="m'.$value[$menuId].'" data-child="haschild" class="treeview"><a href="'.$seturl.'" class="dropdown-toggle "'.$target.'>'.$icon.'<span class="menu-text"> '.$value[$title].' </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>'.$child.'</li>';
					}
					else{
						//$active = $value[$menuId]==$mainParentID||$value[$menuId]==$thisMenuID?' class="active"':'';
						$menu .= '<li'.@$active.' id="m'.$value[$menuId].'" data-child="nochild"><a href="'.$seturl.'"'.$target.'>'.$icon.'<span class="menu-text"> '.$value[$title].' </span></a></li>';
					}
				}
			}
			
			$menu .= '</ul>';
			return $menu;
		}
		else{
			return false;	  
		}
	}
	function generateMenuAdminTop($arrMenu,$parent,$menuId,$title,$url,$customLinks){
	
		if(isset($arrMenu[$parent])){			
			
			$dropdownMenu = '';
			$menu 	 = $parent==0?'<ul class="nav nav-list">':'<ul class="submenu">';
			$isAdmin = $this->uri(1)==$this->admin_name?1:0;
			
			foreach($arrMenu[$parent] as $value){
				
				$adminUrl = !empty($value[$url])?baseURL.$this->admin_name.'/':baseURL.$this->admin_name;
				
				$seturl = $adminUrl.$value[$url];
				$seturl = $value[$customLinks]==1?$value[$url]:$seturl;
				$seturl = $seturl.$this->permalink();
				$seturl = $value['module_id']==1?$adminUrl:$seturl;
				$target = $value[$customLinks]==1?' target="_blank"':'';
				$icon	= '<i class="menu-icon '.$value['icon'].'"></i>';
				
				/*
				if(!$this->mainParentID()){
					$mainParentID = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->pageMainParentID($this->thisPageID())."' and admin_menu='".$isAdmin."'");
					$thisMenuID   = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->pageParentID($this->thisPageID())."' and admin_menu='".$isAdmin."'");
				}
				else{
					$mainParentID = $this->mainParentID();
					$thisMenuID   = $this->thisMenuID();
				}
				*/
				
				$child  = $this->generateMenuAdminTop($arrMenu,$value[$menuId],$menuId,$title,$url,$customLinks);

				if(!empty($value[$title])){
				
					if($child){
						//$active = $value[$menuId]==$this->getParentID($this->thisMenuID())||$value[$menuId]==$mainParentID||$value[$menuId]==$thisMenuID?' class="active open"':'';
						$menu .= '<li class="hover"'.@$active.' id="m'.$value[$menuId].'" data-child="haschild"><a href="'.$seturl.'" class="dropdown-toggle "'.$target.'>'.$icon.'<span class="menu-text"> '.$value[$title].' </span><b class="arrow fa fa-angle-down"></b></a><b class="arrow"></b>'.$child.'</li>';
					}
					else{
						//$active = $value[$menuId]==$mainParentID||$value[$menuId]==$thisMenuID?' class="active"':'';
						$menu .= '<li class="hover"'.@$active.' id="m'.$value[$menuId].'" data-child="nochild"><a href="'.$seturl.'"'.$target.'>'.$icon.'<span class="menu-text"> '.$value[$title].' </span></a></li>';
					}
				}
			}
			
			$menu .= '</ul>';
			return $menu;
		}
		else{
			return false;	  
		}
	}
	function generateMenu($arrMenu,$parent,$menuId,$title,$url,$customLinks,$adminMenu,$class,$showIcon=false){
	
		if(isset($arrMenu[$parent])){			
			
			$dropdownMenu = '';
			$menu 	 = $parent==0?'<ul class="'.$class.'">':'<ul class="dropdown-menu submenu">';
			$isAdmin = $this->uri(1)==$this->admin_name?1:0;
			
			foreach($arrMenu[$parent] as $value){
				
				$getUrl   = !empty($value[$url])?baseURL:substr(baseURL,0,-1);
				$adminUrl = !empty($value[$url])?baseURL.$this->admin_name.'/':baseURL.$this->admin_name;
				
				$seturl = $value[$adminMenu]==1?$adminUrl.$value[$url]:$getUrl.$value[$url];
				$seturl = $value[$customLinks]==1?$value[$url]:$seturl;
				$seturl = $seturl.$this->permalink();
				$seturl = $value['module_id']==1?baseURL:$seturl;
				$seturl = $value['module_id']==1 && $value[$adminMenu]==1?$adminUrl:$seturl;
				$target = $value[$customLinks]==1?' target="_blank"':'';
				$icon	= $showIcon==true?'<i class="'.$value['icon'].'"></i>':'';
				
				if(!$this->mainParentID()){
					$mainParentID = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->pageMainParentID($this->thisPageID())."' and admin_menu='".$isAdmin."'");
					$thisMenuID   = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->pageParentID($this->thisPageID())."' and admin_menu='".$isAdmin."'");
				}
				else{
					$mainParentID = $this->mainParentID();
					$thisMenuID   = $this->thisMenuID();
				}
				
				$child  = $this->generateMenu($arrMenu,$value[$menuId],$menuId,$title,$url,$customLinks,$adminMenu,$class,$showIcon);
				
				if(!empty($value[$title])){
				
					if($child){
						$active = $value[$menuId]==$this->getParentID($this->thisMenuID())||$value[$menuId]==$mainParentID||$value[$menuId]==$thisMenuID?' class="active open"':'';
						$menu .= '<li'.@$active.' id="m'.$value[$menuId].'" data-child="haschild"><a href="'.$seturl.'" data-toggle="dropdown" class="dropdown-toggle "'.$target.'>'.$icon.'<span class="menu-text"> '.$value[$title].' </span><b class="arrow icon-angle-down"></b></a>'.$child.'</li>';
					}
					else{
						$active = $value[$menuId]==$mainParentID||$value[$menuId]==$thisMenuID?' class="active"':'';
						$menu .= '<li'.@$active.' id="m'.$value[$menuId].'" data-child="nochild"><a href="'.$seturl.'"'.$target.'>'.$icon.'<span class="menu-text"> '.$value[$title].' </span></a></li>';
					}
				}
			}
			
			$menu .= '</ul>';
			return $menu;
		}
		else{
			return false;	  
		}
	}
	function getMenu($position='',$showIcon=false){	

		$pageName 	= $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
		$pageName	= $this->isColumnExist($this->table_prefix.'pages','page_name_'.$this->active_lang())?$pageName:'page_name';
		$pageUrl 	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
		$pageUrl	= $this->isColumnExist($this->table_prefix.'pages','page_url_'.$this->active_lang())?$pageUrl:'page_url';
		
		$query 		= $this->db->execute("select m.menu_id, m.parent_id, m.page_id, m.admin_menu, m.position as position, m.icon, m.custom_links, m.custom_title, m.custom_url, p.module_id, p.page_name, p.".$pageName." as name, p.page_url, p.".$pageUrl." as url from ".$this->table_prefix."menu m left join ".$this->table_prefix."pages p on(m.page_id=p.page_id) where m.admin_menu=0 and m.publish=1 order by m.menu_order");
		$menu  		= array();
		
		while($row = $query->fetchRow()){
		
			$menuTitle = !empty($row['name'])?$row['name']:$row['page_name'];
			$menuTitle = $row['custom_links']==1?$row['custom_title']:html_entity_decode($menuTitle);
			
			$menu['menu_id']		= $row['menu_id'];
			$menu['parent_id']		= $row['parent_id'];
			$menu['page_id']		= $row['page_id'];
			$menu['module_id']		= $row['module_id'];
			$menu['admin_menu']		= $row['admin_menu'];
			$menu['position']		= $row['position'];
			$menu['icon']			= $row['icon'];
			$menu['title']			= $menuTitle;
			$menu['url']			= !empty($row['url'])?$row['url']:$row['page_url'];
			$menu['url']			= $row['custom_links']==1?$row['custom_url']:$row['url'];
			$menu['custom_links']	= $row['custom_links'];
		
			if(@in_array($position,@unserialize($row['position'])) || $position==$row['position']){
				
				$data[$row['parent_id']][]=$menu;
			}
		}

		if(isset($data)){
			
			$getMenu = $this->generateMenu($data,0,'menu_id','title','url','custom_links','admin_menu',$showIcon);
			return $getMenu;
		}
		else return null;
	}
	
	function adminMenu($position='',$class='nav nav-list'){
		
		$xsessmenu   = @$this->session('adminmenu');
		
		if(!isset($xsessmenu[$position])){
		
			$pageName 	= $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
			$pageName	= $this->isColumnExist($this->table_prefix.'pages','page_name_'.$this->active_lang())?$pageName:'page_name';
			
			$pageUrl 	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
			$pageUrl	= $this->isColumnExist($this->table_prefix.'pages','page_url_'.$this->active_lang())?$pageUrl:'page_url';		
			
			$query 		= $this->db->execute("select m.menu_id, m.parent_id, m.page_id, p.module_id, m.admin_menu, m.position as position, m.icon, m.custom_links, m.custom_title, m.custom_url, p.page_name, p.".$pageName." as name, p.page_url, p.".$pageUrl." as url from ".$this->table_prefix."menu m left join ".$this->table_prefix."pages p on(m.page_id=p.page_id) where m.admin_menu=1 and m.publish=1 order by m.menu_order");
			$menu  		= array();
			
			while($row = $query->fetchRow()){
			
				$adminSess 		= @$this->session('admin'); 
				$getAdminAccess = !is_array(@$adminSess['access'])?array():$adminSess['access'];
				
				if(in_array($row['page_id'],$getAdminAccess)){
					
					$menuTitle = !empty($row['name'])?$row['name']:$row['page_name'];
					$menuTitle = $row['custom_links']==1?$row['custom_title']:$menuTitle;
					$menuTitle = $menuTitle=='home'?'Dashboard':html_entity_decode($menuTitle);
				
					$menu['menu_id']		= $row['menu_id'];
					$menu['parent_id']		= $row['parent_id'];
					$menu['page_id']		= $row['page_id'];
					$menu['module_id']		= $row['module_id'];
					$menu['admin_menu']		= $row['admin_menu'];
					$menu['position']		= $row['position'];
					$menu['icon']			= $row['icon'];
					$menu['title']			= $menuTitle;
					$menu['url']			= !empty($row['url'])?$row['url']:$row['page_url'];
					$menu['url']			= $row['custom_links']==1?$row['custom_url']:$menu['url'];
					$menu['custom_links']	= $row['custom_links'];		
				
					if(@in_array($position,@unserialize($row['position'])) || $position==$row['position']){
						
						$data[$row['parent_id']][]=$menu;
					}
				}
			}

			if(isset($data)){
				
				if($position=='top'){
					$adminMenu = $this->generateMenuAdminTop($data,0,'menu_id','title','url','custom_links',$class);
				}
				else{
					$adminMenu = $this->generateMenuAdmin($data,0,'menu_id','title','url','custom_links',$class);
				}
				$_SESSION['adminmenu'][$position] = $adminMenu;
				//$this->session_set($xsessmenu['adminmenu'][$position]);
				
				return $adminMenu;
			}
			else return null;
		}
		else{
			return $xsessmenu[$position];
		}
	}
	function sitemap($showIcon=false){	

		$pageName 	= $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
		$pageUrl 	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';

		$query 	= $this->db->execute("select m.menu_id, m.parent_id, m.page_id, m.admin_menu, m.position as position, m.icon, m.custom_links, m.custom_title, m.custom_url, p.".$pageName." as name, p.".$pageUrl." as url, p.category_id as postCategory, post.post_id, post.post_title from ".$this->table_prefix."menu m left join ".$this->table_prefix."pages p on(m.page_id=p.page_id)left join ".$this->table_prefix."posts post on(p.category_id=post.post_category) where m.admin_menu=0 and m.publish=1 order by m.menu_order");
		$menu 	= array();
		$post 	= array();
		$unixID = '';
		
		while($row = $query->fetchRow()){

			$menu['menu_id']		= $row['menu_id'];
			$menu['parent_id']		= $row['parent_id'];
			$menu['page_id']		= $row['page_id'];
			$menu['admin_menu']		= $row['admin_menu'];
			$menu['position']		= $row['position'];
			$menu['icon']			= $row['icon'];
			$menu['title']			= $row['custom_links']==1?$row['custom_title']:$row['name'];
			$menu['url']			= $row['custom_links']==1?$row['custom_url']:$row['url'];
			$menu['custom_links']	= $row['custom_links'];	

			if($unixID!=$menu['menu_id']){
				$data[$row['parent_id']][]=$menu;
			}
			if($row['postCategory']!=0 && $row['post_id']!='NULL'){

				$post['menu_id']		= 'post_'.$row['post_id'];
				$post['parent_id']		= $row['menu_id'];
				$post['page_id']		= $row['page_id'];
				$post['admin_menu']		= $row['admin_menu'];
				$post['position']		= $row['position'];
				$post['icon']			= $row['icon'];
				$post['title']			= $row['post_title'];
				$post['url']			= 'read/'.$row['post_id'].'/'.seo_slug($row['post_title']);
				$post['custom_links']	= $row['custom_links'];
		
				if($menu['title']!=''){

					$data[$row['menu_id']][]=$post;
				}
			}
			
			$unixID = $row['menu_id'];
		}

		if(isset($data)){
		
			$getMenu = $this->generateMenu($data,0,'menu_id','title','url','custom_links','admin_menu',$showIcon);
			return $getMenu;
		}
		else return null;
	}	
	function setMenu($position=''){
		
		$getPosition = explode(',',$position);
		foreach($getPosition as $v){
			$arrPosition[$v]=ucwords($v);
		}
		
		$this->regMenu = $arrPosition;
	}
	function menuPosition($isAdmin='public'){
		
		if($isAdmin=='admin'){
		
			if($ck = @unserialize($this->site->menu_position('admin'))){
				$regMenu = $ck;
			}
			else{
				$regMenu = array(strtolower($this->site->menu_position('admin'))=>$this->site->menu_position('admin'));
			}
		}
		else{
		
			if(isset($this->regMenu)){
				$regMenu = $this->regMenu;
			}
			else{
			
				if($ck = @unserialize($this->site->menu_position('public'))){
					$regMenu = $ck;
				}
				else{
					$regMenu = array(strtolower($this->site->menu_position('public'))=>$this->site->menu_position('public'));
				}
			}
		}
		return $regMenu;
	}
	
	/* ---------- Breadcrumb Category ---------- */	
	function getCatParent($parent){
		
		$xcat = $this->db->getAll("select category_id,parent_id from ".$this->table_prefix."category where category_id='".$parent."'");
		
		foreach($xcat as $v){extract( $v);}
		
		$this->catID .= @$category_id.'.'; 

		if(@$parent_id!=0){
			$this->getCatParent(@$parent_id);
			return $this->catID;
		}
		else{
			return $this->catID;
		}
	}
	function getCatParentID($id){
		$this->catID = '';
		$parent = explode('.',$this->getCatParent($id));
		$parent = array_filter($parent);
		return  @$parent[0];
	}
	function getCatMainParent($id){
		$this->catID = '';		
		$parent = explode('.',$this->getCatParent($id));
		$parent = array_filter($parent);
		return end($parent);
	}
	function breadcrumbCategory($id){
		$this->catID = '';		
		$arrCat 		= explode('.',$this->getCatParent($id));
		
		$getbreadcrumb 	= '';
		
		for($i=count($arrCat);$i>-1;$i--){
			
			$catName 		= $this->db->getOne("select category_name from ".$this->table_prefix."category where category_id='".@$arrCat[$i]."'");
			$getbreadcrumb .= !empty($catName)?' &raquo; '.$catName:'';
		}
		return $getbreadcrumb;
	}
	
	
	/* ---------- Breadcrumb Menu ---------- */
	
	function getMenuParent($parent){
		
		$xcat = $this->db->getAll("select menu_id,parent_id from ".$this->table_prefix."menu where menu_id='".$parent."'");
		
		foreach($xcat as $v){extract( $v);}
		
		$this->menuID .= @$menu_id.'.'; 

		if(@$parent_id!=0){
			$this->getMenuParent(@$parent_id);
			return $this->menuID;
		}
		else{
			return $this->menuID;
		}
	}
	function breadcrumbMenu($id){
		
		$arrCat 		= explode('.',$this->getMenuParent($id));
		$getbreadcrumb 	= '';

		for($i=count($arrCat);$i>-1;$i--){
			
			$query			= "select p.page_name from ".$this->table_prefix."pages p left join ".$this->table_prefix."menu m on(p.page_id=m.page_id) where m.menu_id='".@$arrCat[$i]."'";
			$menuTitle 		= $this->db->getOne($query);
			$getbreadcrumb .= !empty($menuTitle)?' &raquo; '.$menuTitle:'';
		}
		return $getbreadcrumb;
	}
	
	
	/* ---------- Breadcrumb ---------- */
	
	function getPageParent($parent){
		
		$xcat = $this->db->getAll("select page_id,parent_id from ".$this->table_prefix."pages where page_id='".$parent."'");
		
		foreach($xcat as $v){extract( $v);}
		
		@$this->pageID .= @$page_id.'.'; 

		if(@$parent_id!=0){
			$this->getPageParent(@$parent_id);
			return $this->pageID;
		}
		else{
			return $this->pageID;
		}
	}
	function breadcrumb(){
		
		$arrMenu = explode('.',$this->getPageParent($this->thisPageID()));
		$pageId	 = array();
		$nav	 = '';
		
		foreach($arrMenu as $k => $v){
			
			if(!empty($v) && !in_array($v,$pageId)){
				
				$pageId[] = $v;
			}
		}
		
		for($i=count($pageId);$i>0;$i--){
		
			$pageName 	 = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
			$pageUrl 	 = $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
			$x 	  = $i-1;
			$menu = $this->db->getAll("select page_id, ".$pageName." as pagemultilang, ".$pageUrl." as pageUrl from ".$this->table_prefix."pages where page_id='".$pageId[$x]."'");
			$page_name = '';
			foreach($menu as $v){extract( $v);}
			$arrow 	 = $i>1?'<span class="divider"><i class="icon-angle-right arrow-icon"></i></span>':'';
			$linkUrl = $this->uri(1)==$this->admin_name?$this->adminURL().$pageUrl.$this->permalink():baseURL.$pageUrl.$this->permalink();
			if(!empty($pagemultilang)){
				$page_name=$pagemultilang;
			}
			$page_name=html_entity_decode($page_name);
			if($i==1){
				$nav 	.= $page_name!='home'?'<li>'.$page_name.'</li>':'';
			}
			else{
				$nav 	.= $page_name!='home'?'<li><a href="'.$linkUrl.'" title="'.$page_name.'">'.$page_name.'</a>'.$arrow.'</li>':'';
			}
		}

		$arrow 	 	= count($pageId)>0 && $this->thisPage()!='home'?'<span class="divider"><i class="icon-angle-right arrow-icon"></i></span>':'';
		$homeUrl	= $this->uri(1)==$this->admin_name?'<li><a href="'.$this->adminURL().'">Dashboard</a>'.$arrow.'</li>':'<li><i class="icon-home home-icon"></i><a href="'.baseURL.'"></i>Home</a>'.$arrow.'</li>';
		$breadcrumb = '<ul class="breadcrumb">'.$homeUrl.$nav.'</ul>';		
		return $breadcrumb;		
	}
	function breadcrumbPage($id){
		
		$arrPage = explode('.',$this->getPageParent($id));

		$getbreadcrumb = '';
		
		for($i=count($arrPage);$i!=1;$i--){
			
			$pageName = $this->db->getOne("select page_name from ".$this->table_prefix."pages where page_id='".@$arrPage[$i]."'");
			$getbreadcrumb .= !empty($pageName)?' &raquo; '.$pageName:'';
		}
		return $getbreadcrumb;
	}
	function breadcrumbTitle(){
	
		if($this->site->isMultiLang()){			
			$pageTitle = $this->db->getOne("select page_name_".$this->active_lang()." from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");		
		}
		else{		
			$pageTitle = $this->db->getOne("select page_name from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");		
		}
		
		$pageTitle = $this->thisPage()=='home'?'Home':$pageTitle;
		$pageTitle = $this->thisPage()=='home' && $this->uri(1)==$this->admin_name?'Dashboard':$pageTitle;
		
		if($this->thisPage()=='read'){
			
			$thisPageId = @$_SESSION['pageTitle'];
		}
		
		@$_SESSION['pageTitle'] = $pageTitle;
		
		return $pageTitle;
	}
	
	
	/* ---------- params ---------- */
	
	function getParams($fiead){
	
		$param = unserialize($this->db->getOne("select ".@$fiead." from ".$this->table_prefix."params where 1"));
		return $param;
	}
	
	
	/* ---------- isColumnExist ---------- */
	
	function isColumnExist($tableName,$columnName){
		
		$newColumn		= $columnName;
		$langColumn		= "select * from information_schema.columns where table_schema='".$this->dbName."' and table_name = '".$tableName."' and column_name='".$newColumn."'";

		if($this->db->getRow($langColumn)){
			
			return true;
		}
		else return false;
	}
	
	
	/* ---------- admin ---------- */
	
	function admin($value=''){
		$arrAdmin = @$this->session('admin');
		$admin	  = $value!=''?$arrAdmin[$value]:$arrAdmin;		
		return $admin;
	}
	
	
	/* ---------- Session ---------- */
	
	function session($strName){
	
		if(is_array(@$strName)){
		
			foreach($strName as $k=>$v){
				$session = @$_SESSION[$k][$v];
			}
		}
		else{
		
			$session = @$_SESSION[$strName];
		}
		return $session;
	}
	function session_set($arrSession){
	
		foreach($arrSession as $k => $v){
			$_SESSION[$k]=$v;
		}
	}
	function session_unset($strName){
	
		unset($_SESSION[$strName]);
	}
	
	
	/* ---------- Licence ---------- */
	
	function getLicence(){if($_SERVER['SERVER_NAME']=='localhost'){return true;}elseif(!file_exists(uploadPath.'cache/licence.txt')){return false;}else{$licence=array_map(trim,file(uploadPath.'cache/licence.txt'));$xlicence=base64_encode(md5(str_replace('www.','',$_SERVER['SERVER_NAME']).$this->dev()));if(!in_array($xlicence,$licence)){return false;}else{return true;}}}function licence(){if(!@$this->getLicence()){echo $this->licenceError();die();}}function licenceError(){$licenceError = 'This site has not obtained a license from <a href="http://citra.web.id">Citraweb</a>';return $licenceError;}function dev(){$dev = 'citraweb';return $dev;}
	
	
	/* ---------- Cookie ---------- */
	
	function cookie($cookieName){
	
		$cookie = $_COOKIE[$cookieName];
		return $cookie;
	}
	function cookie_unset($cookieName){
	
		unset($_COOKIE[$cookieName]);
	}
	
	
	/* ---------- Functions ---------- */
	
	function tabNav($tabs=array()){
		
		$tabNav = '';
	
		foreach($tabs as $tabID=>$tab){
			
			$tabIcon	 = isset($tab['icon'])?'<i class="icon-'.$tab['icon'].'"></i>':'';
			$activeClass = @$tab['active']=='active'?' class="active"':'';
			
			$tabNav .= '<li'.$activeClass.'><a href="'.$tab['url'].'">'.$tabIcon.$tab['title'].'</a></li>';		
		}
		
		$tabNav = '<ul class="nav nav-tabs">'.$tabNav.'</ul>';	
		
		return $tabNav;
	}
	function tab($tabs=array(),$active_tab='',$class='tabbable'){
	
		$arrActiveClass = array();
		
		$activeTab		= !empty($_POST['active_tab'])?@$_POST['active_tab']:$active_tab;
		
		$xTabs			= 0;
		$tabNav	  		= '<form name="formTab" action="" method="post">';
		$tabNav	  		= '<ul class="nav nav-tabs">';
		$tabContent		= '';

		foreach($tabs as $tabID=>$tabVal){
			
			$arrActiveClass[] = $tabID == @$activeTab?'active':'';
		}
		
		foreach($tabs as $tabID=>$tab){			
			
			/* Check active tab*/
			$activeClass = $tabID == @$activeTab?' class="active"':'';
			$activeClass = !in_array('active',$arrActiveClass)&&$xTabs<1?' class="active"':$activeClass;
			$activePane  = $tabID == @$activeTab?' in active':'';
			$activePane  = !in_array('active',$arrActiveClass)&&$xTabs<1?' in active':$activePane;
			
			/* Check icon*/
			$tabIcon	 = isset($tab['icon'])?'<i class="icon-'.$tab['icon'].'"></i>':'';
			
			/* Listing tab*/
			$tabNav 	.= '<li'.$activeClass.'><a data-toggle="tab" href="#'.$tabID.'">'.$tabIcon.$tab['title'].'</a></li>';			
			$tabContent .= '<div id="'.$tabID.'" class="tab-pane'.$activePane.'">';
			$tabContent .= @$tab['content'];
			
			if(isset($tab['file'])){
			
				ob_start();
				include $tab['file'];
				$tabContent .= ob_get_contents();
				ob_end_clean();
			}
			
			$tabContent .= '</div>';
			
			$xTabs++;
		}
		
		$tabNav .= '</ul>';
		$tabNav .= '</form>';
		
		$getTab = '
		
			<div class="nav-tabs-custom">
				'.$tabNav.'
				<div class="tab-content">
					'.$tabContent.'
				</div>
			</div>
		';
		
		return $getTab;
	}
	function addHelp($content='',$file='',$width=200){
	
		$getContent = !empty($content)?$content:'';
		
		if(!empty($file)){
		
			ob_start();
			include $file;
			$getContent .= ob_get_contents();
			ob_end_clean();
		}
		
		$help = '
			
			<div class="help">
				<button class="btn-help">
					<i class="fa fa-cog"></i>
				</button>
				<div class="help-body" style="width:'.$width.'px;">
					'.$getContent.'
				</div>
			</div>
		';
		
		echo $help;
	}
	function errorReporting($int=0){		

		error_reporting(E_ALL);
		ini_set('display_errors',$int);
	}
	function _GET($xvar=''){
		
		$arrURL = explode('?',$this->thisURL());
		$cURL	= count($arrURL);
		$sURL	= '';
		
		for($i=1;$i<$cURL;$i++){$sURL .= '?'.$arrURL[$i];}		
		$sURL 	= substr($sURL,1);		
		
		$arrGET = explode('&',$sURL);
		
		foreach($arrGET as $v){
			
			$var 	 = explode('=',$v);
			$varName = @$var[0];
			$varVal  = @$var[1];
			
			$GET[$varName] = $varVal;
		}
		
		$getVar = $xvar!=''?@$GET[$xvar]:$GET;
		
		return $getVar;
	}
	
	/* ---------- Email ---------- */
	function getEmailTemplate($templateName){
		
		$emailContent = 'email_content';
		$rsTemplate   = $this->db->execute("select email_subject,".$emailContent." as email_content,email_cc,email_bcc,email_from,email_from_name from ".$this->table_prefix."email_template where email_name='".$templateName."'");
		$template     = $rsTemplate->recordCount()>0?$rsTemplate->fetchRow():array();
		
		return $template;
	}
	function replaceEmailContent($content,$post=array()){
		
		foreach($post as $k=>$v){
		
			$content = str_replace('{'.$k.'}',$v,$content);
		}
		return $content;
	}
	function sendMail($sendmail){
	
		$mailContent = html_entity_decode(@$sendmail['content']);
	
		if($this->config['useMailer']){
		
			require_once(systemPath.'plugins/phpmailer/class.phpmailer.php');
		
			$mail = new PHPMailer();
			
			$mail->IsSMTP();
			
			$mail->Host 		= $this->config['emailHost'];
			$mail->SMTPAuth 	= true;
			$mail->Username 	= $this->config['emailUser'];
			$mail->Password 	= $this->config['emailPassword'];

			$mail->From 		= $sendmail['from'];
			$mail->FromName 	= $sendmail['from_name'];
			$mail->WordWrap 	= 100;
			
			$mail->IsHTML(true);
			
			$mail->Subject 		= $sendmail['subject'];
			$mail->Body 		= $mailContent;

			$mail->AddAddress($sendmail['to']);	
			$mail->AddReplyTo($sendmail['from']);

			if($mail->Send()){
				return true;
			}
			else return false;
		}
		else{
		
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$sendmail['from_name'].' <'.$sendmail['from'].'>' . "\r\n";
			$headers .= 'CC: '.$sendmail['cc'] . "\r\n";
			$headers .= 'BCC: '.$sendmail['bcc'] . "\r\n";
			
			if(mail($sendmail['to'], $sendmail['subject'], $mailContent, $headers, '-f '.$sendmail['from'])){
				return true;
			}
			else return false;
		}
	}
	
	
	/* ---------- Thumbnail ---------- */
	
	function getThumbnail(){
		
		$getThumbnail 	= $this->site->thumbnail();
		
		return $getThumbnail;
	}
	
	function thumbnail($size='small'){
		
		$arrThumbnail 	= $this->site->thumbnail();
		$thumbnail 		= $arrThumbnail[$size];
		
		return $thumbnail;
	}
	
	
	/* ---------- Error page ---------- */
	
	function _404(){
		
		if(isFileExist($this->themePath(),'404.php')){
			ob_clean();
			include($this->themePath().'404.php');
			exit;
		}
		else{
			echo 'Page not found';
		}
	}
	function _401(){
	
		if(isFileExist($this->themePath(),'401.php')){
	
			include($this->themePath().'401.php');	
		}
		else{
			echo 'Access denied';
		}
	}
	
	/* ---------- Misc ---------- */
	function seo_slug($str){		

		$seoSlug = seo_slug($str);
		return $seoSlug;
	}
	function extractZip($zipName,$extractTo){
	
		$zip = new ZipArchive;
		if ($zip->open($zipName) === TRUE) {
			$zip->extractTo($extractTo);
			$zip->close();
			$success = true;
		} else {
			
			$success = false;
		}
		return $success;
	}
	
	/* ---------- DB Driver ---------- */
	function dbDriver(){		
		global $config;		
		if(!in_array($config['db_diver'],$config['drivers'])){echo 'Unknown database driver.';exit;}
	}
	
	/* ---------- Install ---------- */
	function install(){
		
		global $config;
		
		if(file_exists(systemPath.'install/install.php')){
			require_once(systemPath.'install/install.php');exit();			
		}
		else{
			//Cek is installed..
		}
	}
}
?>