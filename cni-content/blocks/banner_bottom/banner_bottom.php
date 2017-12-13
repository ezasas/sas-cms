<?if (!defined('basePath')) exit('No direct script access allowed');

$rsbanner	 = $this->db->execute("select * from ".$this->table_prefix."banner where banner_position='bottom' and publish='1' order by banner_order");
$imagePath	 = uploadPath.'modules/banner/';
$imageURL	 = uploadURL.'modules/banner/';
$listbanner  = '';

while($databanner = $rsbanner->fetchRow()){	
	
	$src = isFileExist($imagePath,$databanner['banner_image'])?$imageURL.$databanner['banner_image']:'';
	
	if(!empty($src)){
		
		$listbanner .= '
			<li>
				<a href="'.$databanner['banner_link'].'">
					<img src="'.$src.'" alt="'.$databanner['banner_title'].'"  class="image"/>
				</a> 
			</li>
		';
	}
}
$listbanner = !empty($listbanner)?'<ul>'.$listbanner.'<div class="clear"></div></ul>':'';
?>

<div class="widget banner-bottom">
	<?=$listbanner?>
</div>