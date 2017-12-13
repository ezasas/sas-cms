<?php if (!defined('basePath')) exit('No direct script access allowed');

// Thumbnail
$thumbnail = array(	
	
	'mini'	  => 'Mini',
	'small'	  => 'Small',
	'medium' => 'Medium',
	'large'	  => 'Large'
);


// Update
if(isset($_POST['save_thumb'])){


	if(md5(base64_encode(@$_POST['stoken']))!=@$this->session('stoken')){
	
		$alert = $this->form->alert('error','Session expired, reload your browser and then try again.');
	}
	else{
	
		$query = "update ".$this->table_prefix."config set thumbnail='".serialize($_POST['thumbsize'])."'";

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

foreach($thumbnail as $inputName => $brand){
	
	$value = $this->site->thumbnailVal($inputName);
	$value = !empty($_POST['thumbsize'][$inputName])?$_POST['thumbsize'][$inputName]:$value;
	
	$form .= '
		<div class="control-group">
			<label class="control-label">'.$brand.'</label>
			<input type="text" name="thumbsize['.$inputName.']" class="form-control validateNumber" value="'.$value.'">
		</div>
	';
	$form .= $x<count($thumbnail)?'<hr>':'';
	
	$x++;
}

?>

<form action="" method="POST" enctype="multipart/form-data">
	<?=@$alert?>
	<?=$form?>
	<hr>
	<div class="form-input-bottom">
		<button name="save_thumb" class="btn btn-flat btn-primary" type="submit"><i class="fa fa-save"></i>Save all changes</button>
		<input type="hidden" class="active_tab" name="active_tab" value="thumbnail">
		<input type="hidden" value="<?=$this->data->token('stoken')?>" name="stoken" />
	</div>
</form>