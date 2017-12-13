<?if (!defined('basePath')) exit('No direct script access allowed');

$rsbanner	 = $this->db->execute("select * from ".$this->table_prefix."banner where banner_position='left' and publish='1' order by banner_order");
$imagePath	 = uploadPath.'modules/banner/';
$imageURL	 = uploadURL.'modules/banner/';
$listbanner  = '';

while($databanner = $rsbanner->fetchRow()){	
	
	$src = isFileExist($imagePath,$databanner['image'])?$imageURL.$databanner['image']:'';
	
	if(!empty($src)){
		
		$listbanner .= '
			<li>
				<a href="'.$databanner['link'].'">
					<img src="'.$src.'" alt="'.$databanner['title'].'"  class="image"/>
				</a> 
			</li>
		';
	}
}
$listbanner = !empty($listbanner)?'<ul class="banner">'.$listbanner.'<div class="clear"></div></ul>':'';

echo $listbanner;
?>
