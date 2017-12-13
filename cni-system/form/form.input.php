<?php

/** SAS - PHP Form Input class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 SAS Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class input{

	function plaintext($label, $name, $size=150,$comment='') {
	
		$params['type']	 		= 'plaintext';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['size']  		= $size;
		$params['comment'] 		= $comment;
		
		return $params;
	}

	function text($label, $name, $size=25, $multilang=false, $value='', $extra='class="form-control"', $comment='') {
	
		$params['type']	 		= 'text';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['size']  		= $size;
		$params['multilang'] 	= $multilang;
		$params['value'] 		= $value;
		$params['extra'] 		= $extra;
		$params['comment']  	= $comment;
		
		return $params;
	}
	function password($label, $name, $size=25, $value='', $extra='class="form-control"'){	
		
		$params['type']	 		= 'password';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['size']  		= $size;
		$params['value'] 		= $value;
		$params['extra'] 		= $extra;
		
		return $params;
	}
	function hidden($name, $value='', $extra=''){
		
		$params['type']	 		= 'hidden';
		$params['name']  		= $name;
		$params['value'] 		= $value;
		$params['extra'] 		= $extra;
		
		return $params;
	}
	function textarea($label, $name, $cols, $rows, $editor=false, $multilang=false, $comment='', $value='', $extra='class="form-control"'){
		
		$params['type']	 		= 'textarea';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['cols']  		= $cols;
		$params['rows'] 		= $rows;
		$params['editor'] 		= $editor;
		$params['multilang'] 	= $multilang;
		$params['comment'] 		= $comment;
		$params['value'] 		= $value;
		$params['extra'] 		= $extra;
		
		return $params;
	}
	function select($label, $name, $arrOption=array(), $multiple=false, $extra='class="select2 form-control"'){
		
		$params['type']	 		= 'select';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['arrOption']	= $arrOption;
		$params['multiple'] 	= $multiple;
		$params['extra'] 		= $extra;
		
		return $params;
	}
	function checkbox($label, $name, $arrCheck=array(),$checked=false, $extra=''){
		
		$params['type']	 		= 'checkbox';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['arrCheck']		= $arrCheck;
		$params['checked'] 		= $checked;
		$params['extra'] 		= $extra;
		
		return $params;
	}
	function switchcheck($label, $name, $skin=1,$checked=false, $addClass=''){
		
		$params['type']	 		= 'switchcheck';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['skin']  		= $skin;
		$params['checked'] 		= $checked;
		$params['addClass']  	= $addClass;
		
		return $params;
	}
	function radio($label, $name, $arrRadio=array(),$checked=false, $extra='class="form-control"'){
		
		$params['type']	 		= 'radio';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['arrRadio']		= $arrRadio;
		$params['checked'] 		= $checked;
		$params['extra'] 		= $extra;
		
		return $params;
	}
	function image($label, $name, $path, $thumbPath='', $allowedTypes='image', $width=600, $maxsize=1048576, $extra='class="form-control"'){
		
		$params['type']	 		= 'image';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['path'] 		= $path;
		$params['thumbPath'] 	= $thumbPath;
		$params['allowedTypes'] = $allowedTypes;
		$params['maxsize']  	= $maxsize;
		$params['width']  		= $width;
		$params['extra'] 		= $extra;
		
		return $params;
	}
	function file($label, $name, $path, $allowedTypes='', $maxsize='', $comment=''){
		
		$params['type']	 		= 'file';
		$params['label'] 		= $label;
		$params['name']  		= $name;
		$params['path'] 		= $path;
		$params['allowedTypes'] = $allowedTypes;
		$params['maxsize']  	= $maxsize;
		$params['comment']  	= $comment;
		
		return $params;
	}
	function html($value){
		
		$params['type']	 		= 'html';
		$params['value'] 		= $value;
		
		return $params;
	}
	function icon($label, $name, $id=''){
		
		$params['type']	 		= 'icon';
		$params['label'] 		= $label;	
		$params['name']  		= $name;
		$params['id'] 			= $id;
		
		return $params;
	}
	function datePicker($label, $name){
		
		$params['type']	 		= 'datepicker';
		$params['label'] 		= $label;	
		$params['name']  		= $name;
		
		return $params;
	}
	function dateTimePicker($label, $name){
		
		$params['type']	 		= 'datetimepicker';
		$params['label'] 		= $label;	
		$params['name']  		= $name;
		
		return $params;
	}
	function timePicker($label, $name){
		
		$params['type']	 		= 'timepicker';
		$params['label'] 		= $label;	
		$params['name']  		= $name;
		
		return $params;
	}
	function dateRangePicker($label, $name){
		
		$params['type']	 		= 'daterangepicker';
		$params['label'] 		= $label;	
		$params['name']  		= $name;
		
		return $params;
	}
	function colorPicker($label, $name){
		
		$params['type']	 		= 'colorpicker';
		$params['label'] 		= $label;	
		$params['name']  		= $name;
		
		return $params;
	}
}
?>