<? if (!defined('basePath')) exit('No direct script access allowed');

$xTheme = explode('_',$this->lastUri());
$msg	= '';

if(isset($_POST['activate'])){
	
	if($this->db->execute("update ".$this->table_prefix."config set site_theme ='".$_POST['themename']."'")){
		setcookie("active_theme", $_POST['themename'], time()+3600,"/".$this->config['baseURL']);
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

$templates  = '';
$xItem		= 0;

foreach($themes as $k=>$v){
	
	$acative = $k==$this->site->theme()?'<font class="blue">Active</font></span>':'<span class="red">Not Active</span>';
	
	
	if($k==$this->site->theme()){
	
		$activTemplate = '
			
			<div class="col-md-3">
				<div class="image-holder">
					<img src="'.themeURL.$k.'/preview.jpg">
				</div>
				<div class="meta-info">
					<div class="meta-name">'.$v.'</div>
					<div class="meta-action">
						<span class="rounded-green"><i class="fa fa-check"></i></span>
					</div>
				</div>
			</div>
		';
	}
	else{
	
		if($xItem!=0 && $xItem%4==0){
			$templates .= '</div><div class="row">';
		}
	
		$btnChange = '<input type="hidden" value="'.$k.'" name="themename"><button class="btn btn-primary btn-flat btn-xs" name="activate" title="activated">Activate</button>';	
		$templates.= '
		
			<div class="col-md-3">
				<div class="template-list">
				<div class="image-holder">
					<img src="'.themeURL.$k.'/preview.jpg" alt="150x150">
				</div>
				<div class="meta-info">
					<div class="meta-name">'.$v.'</div>
					<div class="meta-action">
						<form action="" method="post" class="btn-change">'.$btnChange.'</form>
					</div>
					<div class="clearfix"></div>
				</div>
				</div>	
			</div>			
		';
		$xItem++;
	}
}
?>

<div class="templates">
	<div class="box">
		<div class="box-header with-border">
			<div class="widget-header">
				<h4 class="widget-title">Active Template</h4>
			</div>
		</div>
		<div id="page" class="box-body collapse in">
			<div class="widget-main">
				<div class="default-form form-actions-inner">
					<?php echo $activTemplate; ?>
				</div>
			</div>
		</div>	
	</div>
	<div class="box">
		<div class="box-header with-border">
			<div class="widget-header">
				<h4 class="widget-title">Available Template</h4>
			</div>
		</div>
		<div id="page" class="box-body collapse in">
			<div class="widget-main">
				<div class="default-form form-actions-inner">
        <?php echo $templates; ?>
				</div>
			</div>
		</div>	
	</div>
</div>