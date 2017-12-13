<?php if (!defined('basePath')) exit('No direct script access allowed');

//Update Access
$errorMsg = '';

if(isset($_POST['save'])){
	
	$access 	 = serialize($_POST['page']);
	$updateQuery = "update ".$this->table_prefix."user_group set access='".$access."' where group_id='".intval($this->uri(3))."'";
	
	if($this->db->execute($updateQuery)){	
	
		$errorMsg = '
		
			<div class="alert success" id="alert-success">
				<i class="icon-ok-sign"></i>
				<strong>Success!</strong> Data has been successfully updated.
				<span onclick="closeThis(\'alert-success\')" class="close"><i class="icon-remove"></i></span>
			</div>
		';
	}
	else{
	
		$errorMsg = '
		
			<div class="alert error" id="alert-error">
				<i class="icon-remove-sign"></i>
				<strong>Error!</strong> Unable to update data, please try again later.
				<span onclick="closeThis(\'alert-error\')" class="close"><i class="icon-remove"></i></span>
			</div>
		';
	}
}


$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$groupId 	= intval($this->uri(3));
$userAccess = $this->user->getPermission($groupSessId);
$getAccess  = $this->user->getPermission($groupId);

$query 		= "select * from ".$this->table_prefix."pages order by page_name";

if($groupId==1 && $groupSessId!=1){
	$this->_404();
}
else{
	
	$groupID 	 = anti_injection(intval($this->uri(3)));
	$groupName 	 = $this->db->getOne("select name from ".$this->table_prefix."user_group where group_id='".anti_injection($groupID)."'");	
	$widgetTitle = !empty($groupName)?'Set Permission for '.ucwords($groupName):'Set Permission';
	?>	
	<div class="widget-box">
		<div class="widget-header">
			<h5 class="widget-title"><?=$widgetTitle?></h5>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				
				<form action="" method="post">	
					<div class="widget-permission">
						<?=!empty($errorMsg)?$errorMsg:'';?>
						<div class="tree">
							<label><input type="checkbox" id="chkall_page" class="ace"/><span class="lbl"> Check All</span></label>
							<?=$this->user->pages($query,$userAccess,$getAccess);?>
						</div>
					</div>
					
					<div class="form-input-bottom form-actions">
						<button type="submit" name="save" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>Update Permission</button>
					</div>				
				</form>
				
			</div>
		</div>
	</div>
	<?
}
?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#chkall_page").click(function()				
		{
			var checked_status = this.checked;
			$(".chk").each(function()
			{
				this.checked = checked_status;
			});
		});				
	});
</script>

