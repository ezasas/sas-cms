<?php if (!defined('basePath')) exit('No direct script access allowed');?>

<?php $this->getHeader()?>
<?php $this->widget('top')?>
<?php $this->widget('content')?>
<?php
if($this->thisModuleID()!='1'){
	?>
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<?php echo $this->getContent(); ?>
				</div>
				<div class="col-md-3 sidebar">
					<?php $this->widget('right')?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>

<?php $this->getFooter()?>