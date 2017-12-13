<?php if (!defined('basePath')) exit('No direct script access allowed'); 

$slider			= new stdClass();
$slider->items  = $this->db->getAll("select title,tagline,image,btn_caption,url from ".$this->table_prefix."slider where publish='1' order by slider_order");
$slider->url 	= uploadURL.'modules/slider/';
$xgetSlider		= '';
$indicators		= '';
$sliderLength	= 0;

foreach($slider->items as $xslider){
	
	if(isFileExist(uploadPath.'modules/slider/',$xslider['image'])){
		
		$itemActive  = $sliderLength==0?' active':'';
		$itemTitle 	 = !empty($xslider['title'])?'<h2 class="title">'.$xslider['title'].'</h2>':'';
		$itemTagline = !empty($xslider['tagline'])?'<p class="info">'.$xslider['tagline'].'</p>':'';
		$itemButton	 = !empty($xslider['url'])&&!empty($xslider['btn_caption'])?'<p class="button"><a class="btn btn-lg btn-default" href="'.$xslider['url'].'" role="button">'.$xslider['btn_caption'].'</a></p>':'';
		$xgetSlider .= '
			
			<div class="item'.$itemActive.'">
				<img src="'.$slider->url.$xslider['image'].'" alt="'.$xslider['title'].'">
				<div class="container">
					<div class="carousel-caption">
						'.$itemTitle.'
						'.$itemTagline.'
						'.$itemButton.'
					</div>
				</div>
			</div>
		';
		$indicators .= '<li data-target="#slider" data-slide-to="'.$sliderLength.'" class="'.$itemActive.'"></li>';		
		$sliderLength++;
	}
}
$sliderIndicators 	= count($slider->items)>1?'<ol class="carousel-indicators">'.$indicators.'</ol>':'';
$sliderControl 		= count($slider->items)>1?'<a class="left carousel-control" href="#slider" data-slide="prev"><i class="fa fa-angle-left"></i></a><a class="right carousel-control" href="#slider" data-slide="next"><i class="fa fa-angle-right"></i></a>':'';
$sliderProgress 	= count($slider->items)>1?'<div class="carousel-progress"><span class="carousel-bar" style="width: 43%;"></span></div>':'';

if(isFileExist($this->themePath().'blocks/'.$block['block_name'].'/','slider.php')){
	include $this->themePath().'blocks/'.$block['block_name'].'/slider.php';
}
else{

	?>
	<div id="slider" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<?php echo $sliderIndicators; ?>
		<div class="carousel-inner">
			<?php echo $xgetSlider; ?>
		</div>		
		<?php echo $sliderControl; ?>
		<?php echo $sliderProgress; ?>
	</div>
	<?
}
?>