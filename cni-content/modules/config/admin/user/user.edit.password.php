<?php if (!defined('basePath')) exit('No direct script access allowed');

if(isset($_POST['changepass'])){

	$pass 	= $_POST['password'];
	
	if(empty($pass)){
		$alert = $this->form->alert('error','Enter password.');
	}
	else{
	
		$password  = md5(base64_encode($pass));			
		$updateQry = "update ".$this->table_prefix."user set pass='".$password."' where id='".intval($this->uri(3))."'";
		
		if($this->db->execute($updateQry)){			
			$alert = $this->form->alert('success','Password updated.');
		}
		else{
			$alert = $this->form->alert('error','Unable to change password.');
		}
	}
}
?>

<form method="post" action="" name="frm_account">
	<?=@$alert?>
	<div class="form-group">
		<label class="control-label">New Password</label>
		<div class="controls">
			<input type="password" class="form-control" value="" name="password">
		</div>
	</div>
	<hr>
	<div class="form-input-bottom form-actions">
		<input type="hidden" name="active_tab" value="password">
		<button type="submit" id="changepass" name="changepass" value="" class="btn btn-sm btn-primary">
			<i class="fa fa-save"></i>Change Password
		</button>
	</div>
</form>