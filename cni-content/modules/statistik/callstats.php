<?php if (!defined('basePath')) exit('No direct script access allowed');

if(new visitorTracking()){
	echo 'success';
}
else{
	echo 'error';
}
?>