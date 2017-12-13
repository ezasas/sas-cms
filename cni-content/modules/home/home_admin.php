<?php if (!defined('basePath')) exit('No direct script access allowed');

//adodb_pr($this->session('adminmenu'));

$admin = $this->session('admin');
echo $this->form->alert('ok','Welcome '.ucwords($admin['name']));
$month 	= '';
$year	= '';
?>
<div class="row">
	<div class="col-sm-7">
		<?php $this->stats->displayVisitorStatistic(3,2016); ?>
	</div>
	<div class="col-sm-5">
		<?php $this->stats->displayVisitorReferrer(3,2016); ?>
	</div>
</div>