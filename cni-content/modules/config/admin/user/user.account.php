<?php if (!defined('basePath')) exit('No direct script access allowed');

$username 	  = $this->db->getOne("select username from ".$this->table_prefix."user where id='".$this->admin('id')."'");
$authsession  = $this->db->getOne("select authsession from ".$this->table_prefix."user where id='".$this->admin('id')."'");
$email	  	  = $this->db->getOne("select email from ".$this->table_prefix."user where id='".$this->admin('id')."'");
$email	  	  = isset($_POST['add_email'])?$_POST['add_email']:$email;
$adminsession = substr(get_string_after(requestURI,'?'),2);
$alert		  = '';

//Update Account
if(isset($_POST['changepass'])){

	$getoldpass	= $this->db->getOne("select pass from ".$this->table_prefix."user where id='".$this->admin('id')."'");		
	$oldpass 	= $_POST['oldpass'];
	$newpass 	= $_POST['newpass'];
	$repass  	= $_POST['repass'];
	
	if(empty($oldpass)){
		$alert = '<div class="space"></div>'.$this->form->alert('error','Enter your old password.');
	}
	elseif(md5(base64_encode($oldpass))!=$getoldpass){
		$alert = '<div class="space"></div>'.$this->form->alert('error','Incorect password.');
	}
	elseif(empty($newpass)){
		$alert = '<div class="space"></div>'.$this->form->alert('error','Enter your new password.');
	}
	elseif(empty($repass)){
		$alert = '<div class="space"></div>'.$this->form->alert('error','Repeat your password.');
	}
	elseif($newpass!=$repass){
		$alert = '<div class="space"></div>'.$this->form->alert('error','Password does not match.');
	}
	else{
			
		$password  = md5(base64_encode($newpass));			
		$updateQry = "update ".$this->table_prefix."user set pass='".$password."' where id='".$this->admin('id')."'";
		
		if($authsession==$adminsession && $this->db->execute($updateQry)){			
			$alert = '<div class="space"></div>'.$this->form->alert('success','Password updated.');
		}
		else{
			$alert = '<div class="space"></div>'.$this->form->alert('error','Unable to change password.');
		}
	}
}


$sqltable = array(

	'table' => $this->table_prefix.'user',
	'id'	=> $this->admin('id')
);

$params = array(

	$this->form->input->html('<div class="space"></div>'),
	$this->form->input->html('<label>Username</label>'),
	$this->form->input->html('<div class="input-prepend">'),
	$this->form->input->html('<span class="add-on"><i class="icon-user"></i></span>'),
	$this->form->input->html('<input type="text" name="username" value="'.$username.'" disabled="disabled" class="disabled">'),
	$this->form->input->html('</div>'),
	$this->form->input->html('<hr>'),
	$this->form->input->html('<label>Email</label>'),
	
	$this->form->input->html('<div class="input-prepend">'),
	$this->form->input->html('<span class="add-on"><i class="icon-envelope"></i></span>'),
	$this->form->input->html('<input type="email" name="add_email" value="'.$email.'">'),
	$this->form->input->html('</div>')
);


//Tab nav
$arrTabs  = array(
	
	'account'  => 'Update Account',
	'password' => 'Change Password'
);

$tabNav	  = '<ul class="nav nav-tabs">';
$tabs	  = '';

$activeTab 	  = isset($_POST['active_tab'])?$_POST['active_tab']:'account';
$generalClass = $activeTab=='account'?'':' style="display:none"';
$menuClass    = $activeTab=='password'?'':' style="display:none"';

foreach($arrTabs as $tabID=>$tabVal){
	
	$activeClass = $tabID == $activeTab?' class="active"':'';
	$tabs .= '<li id="nav-tab-'.$tabID.'"'.$activeClass.'><a href="#" onclick="return langtabs(\''.$tabID.'\')">'.$tabVal.'</a></li>';
}
$tabNav .= $tabs;
$tabNav .= '<div class="clearfix"></div></ul>';

$accountClass  = $activeTab!='account'?' style="display:none"':'';
$passwordClass = $activeTab!='password'?' style="display:none"':'';
?>

<div class="widget-container">

	<?=$tabNav?>

	<div id="input-pass" class="tab-account"<?=$accountClass?>>
		<? $this->form->getForm('edit',$sqltable,$params,$formName='frm_pass',$submitValue='Save Changes');?>
	</div>			
	
	<div id="input-pass" class="tab-password"<?=$passwordClass?>>
		<form method="post" action="" name="frm_account">
			<div class="form-input">
				<?=$alert?>

				<div class="widget-content">
					<div class="space"></div>
					<div class="control-group">
						<label>Old Password</label>
						<div class="input-prepend">
							<span class="add-on"><i class="icon-key"></i></span>
							<input type="password" class="text" size="25" value="" name="oldpass">
						</div>
					</div>
					<hr>
					<div class="control-group">
						<label>New Password</label>
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span>
							<input type="password" class="text" size="25" value="" name="newpass">
						</div>
					</div>
					<hr>
					<div class="control-group">
						<label>Retype Password</label>
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span>
							<input type="password" class="text" size="25" value="" name="repass">
						</div>
					</div>
				</div>
				<div class="form-input-bottom">
					<input type="hidden" name="active_tab" value="password">
					<button id="changepass" type="submit" name="changepass" class="btn btn-small btn-primary"><i class="icon-save"></i>Save Changes</button>
				</div>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>	
</div>


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