<?php

/** CNI - PHP Function Lib
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
function get_string_before($str,$before){

	$string = substr($str, 0, strpos($str, $before));
	return $string;
}
function get_string_after($str,$after){

	$string = substr($str, strpos($str, $after)+1,strlen($str));
	return $string;
}
function get_string_between($string, $start, $end){

	$string = " ".$string;
	$ini 	= strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
function create_thumb($imageUrl,$thumbPath,$setWidth,$type){

	if(file_exists($imageUrl)){
		
		switch(strtolower($type)){
		
			case 'jpg':
				$source_image 	= imagecreatefromjpeg($imageUrl);
				$width 			= imagesx($source_image);
				$height 		= imagesy($source_image);  
				$setHeight 		= floor($height*($setWidth/$width));
				$virtual_image 	= imagecreatetruecolor($setWidth,$setHeight);
				
				imagecopyresampled($virtual_image,$source_image,0,0,0,0,$setWidth,$setHeight,$width,$height);
				imagejpeg($virtual_image,$thumbPath,99);
			break;
		
			case 'jpeg':
				$source_image 	= imagecreatefromjpeg($imageUrl);
				$width 			= imagesx($source_image);
				$height 		= imagesy($source_image);  
				$setHeight 		= floor($height*($setWidth/$width));
				$virtual_image 	= imagecreatetruecolor($setWidth,$setHeight);
				
				imagecopyresampled($virtual_image,$source_image,0,0,0,0,$setWidth,$setHeight,$width,$height);
				imagejpeg($virtual_image,$thumbPath,99);
			break;
		
			case 'png':
				$source_image 	= imagecreatefrompng($imageUrl);
				$width 			= imagesx($source_image);
				$height 		= imagesy($source_image);  
				$setHeight 		= floor($height*($setWidth/$width));
				$virtual_image 	= imagecreatetruecolor($setWidth,$setHeight);			
				$background 	= imagecolorallocate($virtual_image, 255, 255, 255);
				
				// removing the black from the placeholder
				imagecolortransparent($virtual_image, $background);

				// turning off alpha blending (to ensure alpha channel information is preserved, rather than removed (blending with the rest of the image in the form of black))
				imagealphablending($virtual_image, false);

				// turning on alpha channel information saving (to ensure the full range of transparency is preserved)
				imagesavealpha($virtual_image, true);
				
				imagecopyresampled($virtual_image,$source_image,0,0,0,0,$setWidth,$setHeight,$width,$height);
				imagepng($virtual_image,$thumbPath);
			break;
		
			case 'gif':
				$source_image 	= imagecreatefromgif($imageUrl);
				$width 			= imagesx($source_image);
				$height 		= imagesy($source_image);  
				$setHeight 		= floor($height*($setWidth/$width));
				$virtual_image 	= imagecreatetruecolor($setWidth,$setHeight);
				
				// integer representation of the color black (rgb: 0,0,0)
				$background = imagecolorallocate($virtual_image,  255, 255, 255);
				// removing the black from the placeholder
				imagecolortransparent($virtual_image, $background);
				
				imagecopyresampled($virtual_image,$source_image,0,0,0,0,$setWidth,$setHeight,$width,$height);
				imagegif($virtual_image,$thumbPath);
			break;
		}
	}
}
function clearTemp($temPath){

	if ($handle = opendir($temPath)){
	
		while (false !== ($file = readdir($handle))){
		
			if($file !=='.' and $file !=='..'){				
				
				if(preg_match("/".getSessUser()."/i", $file)){
					unlink($temPath.$file);
				}
			}
		}		
		closedir($handle);
	}
}
function isFileExist($filePath,$fileName){
	
	if(file_exists($filePath.$fileName)){
		return true;
	}
	else{
		return false;
	}
}
function anti_injection($str){
	
	global $config;
	
	if(!in_array($config['db_diver'],$config['drivers'])){
		$filter = 'Unknown database driver.';
	}
	else{
		if($config['db_diver']=='mysql'){
			$filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($str,ENT_QUOTES))));
		}
		elseif($config['db_diver']=='mysqli'){
			$db_host	 	= $config['db_host'];
			$db_user	 	= $config['db_user'];
			$db_password	= $config['db_password'];
			$db_name	 	= $config['db_name'];
			$con 			= mysqli_connect($db_host,$db_user,$db_password,$db_name);

			// escape variables for security	
			$filter = mysqli_real_escape_string($con,stripslashes(strip_tags(htmlspecialchars($str,ENT_QUOTES))));
		}
	}
	return $filter;	
}
function strEncode($str){
	return anti_injection(htmlentities(str_replace('\\','\\\\',mb_convert_encoding($str, 'UTF-8', 'ASCII')),ENT_QUOTES));
}
function strDecode($str){
	return html_entity_decode($str);
}
function seo_slug($str){
	
	$seo = strtolower(str_replace(' ','-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.%&-]/s', '', $str)));
	return $seo;
}
function validateEmail($email) {	
	if(filter_var($email, FILTER_VALIDATE_EMAIL)=== false){return false;}else return true;	
}
function get_date($strDate,$month=array(),$day=array(),$setDay=true,$setTime=false){
	
	$arrDate = explode(' ',$strDate);
	$getDate = @$arrDate[0];
	$getTime = @$arrDate[1];
	$xDate	 = explode('-',$getDate);
	$xTime	 = explode(':',$getTime);
	$getDay  = $setDay==true?$day[date('w', strtotime($getDate))].', ':'';
	$date 	 = '<span class="date"> '.$getDay.@$xDate[2].' '.@$month[$xDate[1]-1].' '.@$xDate[0].'</span>';
	$time 	 = $setTime==true?'<span class="time">'.@$xTime[0].':'.@$xTime[1]:'</span>';
	
	$getDate = !empty($time)?$date.$time:$date;
	
	return $getDate;
}
function date_indo($strDate,$setDay=true,$setTime=false){
	
	$arrDate = explode(' ',$strDate);
	$getDate = @$arrDate[0];
	$getTime = @$arrDate[1];
	$xDate	 = explode('-',$getDate);
	$xTime	 = explode(':',$getTime);
	
	$month = array(
		
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'00' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember'
	);
	
	$day  	= array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
	$getDay = $setDay==true?$day[date('w', strtotime($getDate))].', ':'';
	$date 	= '<span class="date"> '.$getDay.@$xDate[2].' '.@$month[$xDate[1]].' '.@$xDate[0].'</span>';
	$time 	= $setTime==true?'<span class="time">'.date("h:i a", strtotime($getTime)).'</span>':'';
	

	$date_indo = !empty($time)?$date.$time:$date;
	
	return $date_indo;
}
function trimContent($str,$maxWord){
	
	$arrText = explode(' ',strip_tags($str));
	$out	 = '';

	for($i=0;$i<$maxWord;$i++){$out .= @$arrText[$i].' ';}
	
	$out = substr($out,0,-1);	
	$out = count($arrText)>$maxWord?$out.' ...':$out;
	
	return $out;
}
function trimText($str){
	
	$arrText = explode('.',strip_tags($str));
	$out	 = $arrText[0].'.';
	
	return $out;
}
function addThisShare(){

	$addThisShare = '
	
		<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_counter addthis_pill_style"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fd7f9c01d3c94cd"></script>
			<!-- AddThis Button END -->
		</div>
	';
	
	return $addThisShare;
}
function simpleShare(){

	global $system;
	
	$redirectUrl = $system->thisUrl();
	$title		 = $system->pageTitle();
	
	$simpleShare = '
		
		<a class="facebook" href="http://www.facebook.com/sharer.php?u='.$redirectUrl.'" target="_blank"><i class="fa fa-facebook"></i></a>
		<a class="twitter" href="http://twitter.com/share?url='.$redirectUrl.'&text='.$title.'" target="_blank"><i class="fa fa-twitter"></i></a>
		<a class="google-plus" href="https://plus.google.com/share?url='.$redirectUrl.'" target="_blank"><i class="fa fa-google-plus"></i></a>
		<a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url='.$redirectUrl.'" target="_blank"><i class="fa fa-linkedin"></i></a>
		<a class="pinterest" href="javascript:void((function()%7Bvar%20e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.setAttribute(\'charset\',\'UTF-8\');e.setAttribute(\'src\',\'http://assets.pinterest.com/js/pinmarklet.js?r=\'+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="fa fa-pinterest"></i></a>
		<a class="mail" href="mailto:?Subject='.$title.'&Body=I%20saw%20this%20and%20thought%20of%20you!%20 '.$redirectUrl.'"><i class="fa fa-envelope"></i></a>
	';
	
	return $simpleShare;
}
function socialButton(){
	$socialButton = '
		<div class="addthis_toolbox addthis_default_style">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_counter addthis_pill_style"></a>
		</div>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fd7f9c01d3c94cd"></script>
	';
	return $socialButton;
}
function inputMap( $str_value = '', $str_name = '' ,$addClass='inputpesan tbless'){
	
	global $system;
	global $config;	
	
	$name	 = ( $str_name == '' ) ? 'geolocation' : $str_name;	
	$out	 = '';
	$out 	.= '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>';	
	$out 	.= '
	
		<script type="text/javascript">
		$(function(){

			var geocoder = new google.maps.Geocoder();
			
			$(".view'.$name.'").click(function(){
			
				var address  = $(".address_'.$name.'").val();

				geocoder.geocode( { "address": address}, function(results, status) {

					if (status == google.maps.GeocoderStatus.OK) {
					
						var latlang = results[0].geometry.location.lat()+","+results[0].geometry.location.lng();
						document.getElementById("coordinate").value = "("+latlang+")";
						
						var latLng = new google.maps.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
						var mapOptions = {
							zoom: 15,
							center: latLng,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};
						var map 	= new google.maps.Map(document.getElementById("map-'.$name.'"), mapOptions);
						var marker 	= new google.maps.Marker({
							position: latLng,
							title: "Drag to edit marker",
							map: map,
							draggable: true
						});
						google.maps.event.addListener(marker, "drag", function() {
							updateMarkerlatLang(marker.getPosition());
						});
					} 
				});
				return false;
			});

			//Listing map

			var latLng = new google.maps.LatLng('.$str_value.');
			var map = new google.maps.Map(document.getElementById("map-'.$name.'"), {
				zoom: 15,
				center: latLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			var marker = new google.maps.Marker({
				position: latLng,
				title: "Drag to edit marker",
				map: map,
				draggable: true
			});

			// Update current position info.
			updateMarkerlatLang(latLng);

			// Add dragging event listeners. 
			google.maps.event.addListener(marker, "drag", function() {
			updateMarkerlatLang(marker.getPosition());
			});	
		});
		
		function updateMarkerlatLang(latLng) {
			var latLang = latLng.lat()+","+latLng.lng();
			$("#coordinate").attr("value","("+latLang+")");
		}
		</script>
		
		<div class="input-map">
			<div class="input-group">
				<input type="text" class="address_'.$name.' '.$addClass.' form-control" placeholder="Enter address"/>
				<span class="input-group-btn">
					<button class="view'.$name.' btn btn-sm btn-info">Get Map</button>
				</span>
			</div>
			<div class="hr hr-double hr-dotted hr18"></div>
			<div id="map-'.$name.'" class="map-content"></div>
			<input type="hidden" value="('.$str_value.')" name="'.$name.'" id="coordinate"/>
		</div>
	';
	
	return $out;
}

//Mime Content Type
if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $xar = explode('.',$filename);
        $ext = strtolower(array_pop($xar));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

//File Icons
function fileIcon($extension){

	$archive 	= array('zip','rar');
	$audio 		= array('mp3');
	$code 		= array('php','js','css','js');
	$image 		= array('jpg','jpeg','png','gif');
	$movie 		= array('flv','mp4','ogg');

	if(in_array(strtolower($extension),$archive)){
		$fileIcon = 'fa-file-archive-o';
	}
	elseif(in_array(strtolower($extension),$audio)){
		$fileIcon = 'fa-file-audio-o';
	}
	elseif(in_array(strtolower($extension),$code)){
		$fileIcon = 'fa-file-code-o';
	}
	elseif(in_array(strtolower($extension),$image)){
		$fileIcon = 'fa-file-image-o';
	}
	elseif($extension=='xls'){
		$fileIcon = 'fa-file-excel-o';
	}
	elseif($extension=='pdf'){
		$fileIcon = 'fa-file-pdf-o';
	}
	elseif($extension=='ppt'){
		$fileIcon = 'fa-file-powerpoint-o';
	}
	elseif($extension=='doc' || $extension=='docx'){
		$fileIcon = 'fa-file-word-o';
	}
	elseif($extension=='txt'){
		$fileIcon = 'fa-file-text-o';
	}
	else{
		$fileIcon = 'fa-file';
	}
	
	return $fileIcon;
}

/* Remove folder & files */
function removeDir($dir) {

	if (is_dir($dir)) {
	
		$objects = scandir($dir);
		
		foreach ($objects as $object) {
		
		  if ($object != "." && $object != "..") {
			if (filetype($dir."/".$object) == "dir") 
			   removeDir($dir."/".$object).'<br>'; 
			else unlink   ($dir."/".$object).'<br>';
		  }
		}
		reset($objects);
		rmdir($dir);
	}
}

/* Get client IP*/
function getClientIP(){
	
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
	$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
	$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
	$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
	$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
	$ipaddress = getenv('REMOTE_ADDR');
	else
	$ipaddress = 'UNKNOWN';

	return $ipaddress; 
}

/* Session user */
function getSessUser() {
	
	if(isset($_SESSION['admin']['session'])){
		
		$sessUser = $_SESSION['admin']['session'];
	}
	else{
		$sessUser = getClientIP();
	}
	
	return $sessUser;
}

/* ---------- Get Youtube ID from URL ---------- */
function getYouTubeId($url){

	$url_string = parse_url($url, PHP_URL_QUERY);
	parse_str($url_string, $args);	
	return isset($args['v'])?$args['v']:$url;
}

/* ---------- Get Youtube Detail ---------- */
function getYoutubeData($youtubeID){
	
	global $config;
	$key = $config['youtubeKey'];
	$jasonURL = 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id='.$youtubeID.'&key='.$key;

	$xml = @file_get_contents($jasonURL);
	$youtube = array();
	
	if ($data = json_decode($xml, true)){
		
		$vData = $data['items'][0];
		
		$youtube['title'] = $vData['snippet']['title'];
		$youtube['description'] = $vData['snippet']['description'];
		$youtube['channelTitle'] = $vData['snippet']['channelTitle'];
		$youtube['duration'] = covtime($vData['contentDetails']['duration']);
		$youtube['viewCount'] = $vData['statistics']['viewCount'];
		
		return $youtube;
	}
	else{
		return null;
	}
}

/* ---------- Get Youtube Video Duration ---------- */
function getYoutubeVideo($videoid){

	# YouTube api v2 url
	$apiURL = 'http://gdata.youtube.com/feeds/api/videos/'. $videoid .'?v=2&alt=jsonc';

	# curl options
	$options = array(
		CURLOPT_URL	=> $apiURL,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_BINARYTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_TIMEOUT => 5 );

	# connect api server through cURL
	$ch = curl_init();
	curl_setopt_array($ch, $options);
	# execute cURL
	$json = curl_exec($ch) or die( curl_error($ch) );
	# close cURL connect
	curl_close($ch);

	# decode json encoded data
	if ($data = json_decode($json)){
		return (object) @$data->data;
	}
	else{
		return false;
	}
}

function covtime($youtube_time) {
    preg_match_all('/(\d+)/',$youtube_time,$parts);

    // Put in zeros if we have less than 3 numbers.
    if (count($parts[0]) == 1) {
        array_unshift($parts[0], "0", "0");
    } elseif (count($parts[0]) == 2) {
        array_unshift($parts[0], "0");
    }

    $sec_init = $parts[0][2];
    $seconds = $sec_init%60;
    $seconds_overflow = floor($sec_init/60);

    $min_init = $parts[0][1] + $seconds_overflow;
    $minutes = ($min_init)%60;
    $minutes_overflow = floor(($min_init)/60);

    $hours = $parts[0][0] + $minutes_overflow;

    if($hours != 0)
        return $hours.':'.$minutes.':'.$seconds;
    else
        return $minutes.':'.$seconds;
}
/* ---------- Convert second to time[h:i:s] ---------- */
function getTime($seconds) {

	$t = round($seconds);
	
	$h = sprintf('%02d', ($t/3600));
	$i = sprintf('%02d', ($t/60%60));
	$s = sprintf('%02d', ($t%60));
	
	$h = $h!=00?$h.':':'';
	$i = $i!=00?$i.':':'';
	$s = $s!=00?$s:'';
	
	return $h.$i.$s;
}
function rupiah($nilai, $pecahan = 0) {
    return number_format($nilai, $pecahan, ',', '.');
}
?>