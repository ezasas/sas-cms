<?php

/** CNI - PHP Upload File
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
 
$sessUser		 = getSessUser();
$fileName   	 = $_FILES['file']['name'];
$type 			 = $_FILES['file']['type'];
$type 			 = preg_match('/(.*)\.zip/',$_FILES['file']['name'])?'zip':$type;
$extension		 = $ext = pathinfo($fileName, PATHINFO_EXTENSION);
#$uploadto		 = tmpPath.$fileName;
$fileUpload		 = date("Ymdhis").'.'.$extension;
$fileUpload		 = $sessUser.'_'.$fileUpload;
$uploadto		 = tmpPath.$fileUpload;
$fileElementName = 'file';
$allowedTypes	 = @$this->uri(3);
$maxsize	 	 = @$this->uri(4);
$error 		 	 = "";
$msg 			 = "";
$id 			 = "";
$size 			 = "";
$width 			 = "";
$height			 = "";
$allowed 		 = false;

if(!empty($_FILES[$fileElementName]['error'])){

	switch($_FILES[$fileElementName]['error']){

		case '1':
			$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			break;
		case '2':
			$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			break;
		case '3':
			$error = 'The uploaded file was only partially uploaded';
			break;
		case '4':
			$error = 'No file was uploaded.';
			break;

		case '6':
			$error = 'Missing a temporary folder';
			break;
		case '7':
			$error = 'Failed to write file to disk';
			break;
		case '8':
			$error = 'File upload stopped by extension';
			break;
		case '999':
		default:
			$error = 'No error code avaiable';
	}
}
elseif(empty($_FILES['file']['tmp_name']) || $_FILES['file']['tmp_name'] == 'none'){

	$error = "No file was uploaded.";
}
else{
	
	//Get Type
	$arrTypes = explode(',',$allowedTypes);
	$arrTypes = count($arrTypes)>1?$arrTypes:array($allowedTypes);
	
	if(ereg($allowedTypes,$type)){
		$allowed = true;
	}
	elseif(in_array($extension,$arrTypes)){
		$allowed = true;
	}
	
	//Start Upload	
	if(!$allowed){
		$error = "Not allowed file type";
	}
	
	//Start Upload			
	if(!$allowed){
		$error = "<div class=errorUpload>Not allowed file type</div>";
	}	
	elseif($_FILES['file']['size'] > $maxsize){
		
		//Get file size
		$size		  = $_FILES['file']['size'];
		$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");			
		$fileSize	  = $size!='' | $size!=0? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
		$maxFileSize  = $maxsize!='' | $maxsize!=0? round($maxsize/pow(1024, ($i = floor(log($maxsize, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
		
		$error = "<div class=errorUpload>Maximum upload size is ".$maxFileSize."</div>";
	}	
	else{
		
		if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadto)){
		
			for($i=0;$i<5;$i++){
				$id .= rand(0,9);
			}
			
			//Get width height
			list($width, $height, $type, $attr) = getimagesize($uploadto);
			
			$msg = '<img src="'.tmpURL.$fileUpload.'"/>';
		}
		else{
			$error = "<div class=errorUpload>Unable to upload  to FTP server ".$uploadto."</div>";
		}
	}
}		
echo "{";
echo	"id: '".$id."',\n";
echo	"name: '".$_FILES['file']['name']."',\n";
echo	"type: '".$_FILES['file']['type']."',\n";
echo	"size: '".$size."',\n";
echo	"dimension: '".$width." x ".$height."',\n";
echo	"error: '".$error."',\n";
echo	"msg: '". $msg ."',\n";
echo	"fileName: '".$fileUpload."'\n";
echo "}";
?>