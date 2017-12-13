<?if (!defined('basePath')) exit('No direct script access allowed');

// Social Media
$socialMedia = array(	
	
	'facebook'	  => 'Facebook',
	'twitter'	  => 'Twitter',
	'google_plus' => 'Google Plus+',
	'instagram'   => 'Instagram',
	'youtube'	  => 'YouTube',
	'linkedin'	  => 'LinkedIn',
	'pinterest'	  => 'Pinterest',	
	'flickr'	  => 'Flickr',
	'dribbble'	  => 'Dribbble',
	'skype'	 	  => 'Skype'
);


// Update
if(isset($_POST['save_social'])){

	if(md5(base64_encode($_POST['token']))!=@$this->session('token')){
	
		$alert = $this->form->alert('error','Session expired, reload your browser and then try again.');
	}
	else{
	
		$query = "update ".$this->table_prefix."config set socila_media='".serialize($_POST['social'])."'";

		if($this->db->execute($query)){
		
			$alert = $this->form->alert('success','Data has been successfully updated.');
		}
		else{
		
			$alert = $this->form->alert('error','Unable to update data.');
		}
	}
}

// Create Form
$form = '';
$x 	  = 1;

foreach($socialMedia as $inputName => $brand){
	
	$value = $this->site->social_media($inputName);
	$value = !empty($_POST['social'][$inputName])?$_POST['social'][$inputName]:$value;
	
	$form .= '
	
		<div class="control-group">
			<label class="control-label">'.$brand.'</label>
			<div class="input-group input-append">
				<span class="add-on input-group-addon pointer"><i class="fa fa-'.str_replace('_','-',$inputName).'"></i></span>
				<input type="text" name="social['.$inputName.']" class="form-control" value="'.$value.'">
			</div>
		</div>
	';
	$form .= $x<count($socialMedia)?'<hr>':'';
	
	$x++;
}
?>

<form action="" method="POST" enctype="multipart/form-data">
	<?=@$alert?>
	<?=$form?>
	<hr>
	<div class="form-input-bottom form-actions">
		<button name="save_social" class="btn btn-flat btn-primary" type="submit"><i class="fa fa-save"></i>Save all changes</button>
		<input type="hidden" class="active_tab" name="active_tab" value="socialmedia">
		<input type="hidden" value="<?=$this->data->token('token')?>" name="token" />
	</div>
</form>