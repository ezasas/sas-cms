<?php if (!defined('basePath')) exit('No direct script access allowed');

$addUrl 		 = $this->adminUrl().'add-slider'.$this->permalink().'?r='.base64_encode($this->thisUrl());

$tablename  = $this->table_prefix.'slider';
$query		= 'select * from '.$tablename.' where 1 order by slider_order';
$data 		= array(

	'Slider'	=> 'image.custom.getImage.align="left".width="100"',
	'Title' 	=> 'title.text..align="left"',
	'Order'		=> 'slider_order.inputText..width="20".class="input-order"',
	'Publish'	=> 'publish.checkbox..width="60".align="center"',
	'Edit'		=> 'slider_id.edit.edit-slider'
);

function getImage($data,$params){	
	
	$image 	  = empty($data['image'])?'noimage.jpg':$data['image'];
	$imgUrl	  = uploadURL.'modules/slider/thumbs/mini/'.$image;	
	$getImage = '<div class="image-holder"><img src="'.$imgUrl.'"/><span></span></div>';
	
	return $getImage;
}

$this->data->addSearch('title');
$this->data->removeImage('image','modules/slider/');
$this->data->init($query,10,5);
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<h4 class="widget-title">Pages</h4>
			<div class="widget-toolbar">
				<a href="<?php echo $addUrl; ?>" class="btn btn-sm btn-flat btn-info"><i class="ace-icon fa fa-plus"></i> Add New</a>
			</div>
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
			<div class="default-form form-actions-inner">				
				<?php $this->data->getPage($tablename,'slider_id',$data);?>
			</div>
		</div>
	</div>	
</div>