<?if (!defined('basePath')) exit('No direct script access allowed');

$xTheme = explode('_',$this->lastUri());
$msg	= '';

if(isset($_POST['activate'])){
	
	if($this->db->execute("update ".$this->table_prefix."config set site_theme ='".$_POST['themename']."'")){
		$msg = $this->form->alert('success','Data successfully updated');
	}
	else{
		$this->form->alert('error','Update Failed!');
	}
}

echo $msg;

if($handle = opendir(themePath)){
	
	$siteTheme = $this->db->getOne("select site_theme from ".$this->table_prefix."config where 1");
	
	while (false !== ($file = readdir($handle))){
	
		if($file !=='.' and $file !=='..' and $file !=='..' and $file !=='index.php'){
			
			$themes[$file] = ucwords(str_replace('_',' ',$file));
		}
	}		
	closedir($handle);
}

$templates = '';
foreach($themes as $k=>$v){
	
	$acative = $k==$this->site->theme()?'<font class="blue">Active</font></span>':'<span class="red">Not Active</span>';
	
	if($k==$this->site->theme()){
	
		$activTemplate = '
			
			<div class="template-box span3">
				<div class="image-holder">
					<img src="'.themeURL.$k.'/preview.jpg">
				</div>
				<div class="info">
					<span class="pull-left">'.$v.'</span>
					<span class="text-success pull-right">Active</span>
				</div>
			</div>
		';
	}
	else{
	
		$btnChange = '<input type="hidden" value="'.$k.'" name="themename"><button class="btn-change-template" name="activate"><i class="icon-random"></i></button>';	
		$templates.= '
			
			<div class="template-box span2">
				<div class="image-holder">
					<img src="'.themeURL.$k.'/preview.jpg">
					<span class="bg-transparent"></span>
					<form action="" method="post" class="btn-change">'.$btnChange.'</form>
				</div>
				<div class="info">'.$v.'</div>
			</div>
		';
	}
}
?>

<div class="templates">
	<div class="row-fluid">
	<?=@$activTemplate;?>
	</div>
	<div class="space-24"></div>
	<h3 class="header smaller lighter blue">Available Templates</h3>
	
	<div class="row-fluid">
	<?=$templates;?>
	</div>
</div>