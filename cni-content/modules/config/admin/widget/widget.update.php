<?php if (!defined('basePath')) exit('No direct script access allowed');

if(isset($_POST['widget']) && isset($_POST['position'])){

	$post 		= json_decode(stripslashes($_POST['widget']));
	$position	= $_POST['position'];
	$arrWidgets	= array();
	$widgets	= array();
	$newWidget	= '';

	/* create widgets array from post */
	foreach($post as $k=>$v){
		$widgets[]	= trim($v->id);
	}

	/* select active widgets from db */
	$getWidget = $this->db->getAll("select block_name from ".$this->table_prefix."blocks where block_position='".$position."' and block_theme='".$this->site->theme()."'");

	if($getWidget){

		foreach($getWidget as $gw){
			
			$arrWidgets[]	= $gw['block_name'];
		}
	}
	else $arrWidgets = array();

	/* insert/update bloks */
	if(count($widgets)>0){
		
		foreach($widgets as $sid => $w){
			
			$wparam = isset($_POST['block_params'])?base64_encode(htmlentities($_POST['block_params'])):'';
			$fieldTitle = '';
			
			if($this->site->isMultiLang()){
				
				foreach($this->site->lang() as $langID=>$langVal){
					
					$fieldTitle .= "block_title_".$langID."='".ucwords(str_replace('_',' ',$w))."',";
				}
			}
			
			$sid += 1;
			if(!in_array($w,$arrWidgets)){
				
				$qry 		= "insert into ".$this->table_prefix."blocks set block_name='".$w."',block_position='".$position."',block_order='".$sid."',block_theme='".$this->site->theme()."',block_title='".ucwords(str_replace('_',' ',$w))."',".$fieldTitle."block_page='home',block_params='".$wparam."',block_title_show='1',active='1'";
				$newWidget 	= $w;
			}
			else{
			
				$qry = "update ".$this->table_prefix."blocks set block_order='".$sid."' where block_name='".$w."' and block_position='".$position."' and block_theme='".$this->site->theme()."'";
			}
			$this->db->execute($qry);
		}
	}

	/* delete bloks */
	if(count($arrWidgets)>0){

		foreach($arrWidgets as $w){

			if(!in_array($w,$widgets)){
			
				$qry = "delete from ".$this->table_prefix."blocks where block_name='".$w."' and block_position='".$position."' and block_theme='".$this->site->theme()."'";			
				$this->db->execute($qry);
			}
		}
	}
	
	$response = array(
		
		'act' 		=> 'updateAll',
		'newWidget' => $newWidget,
		'position' 	=> $position
	);
}
elseif(@$_POST['updateWidget']==1){

	if($this->site->isMultiLang()){
	
		foreach($this->site->lang() as $langID=>$langVal){
			
			@$fieldTitle .= "block_title_".$langID."='".$_POST['title_'.$langID]."',";
		}
	}

    $title		= $_POST['title'];
	$display	= $_POST['display'];
    $blockName	= $_POST['blockName'];
    $position	= $_POST['position'];
	$wparam 	= isset($_POST['block_params'])?base64_encode(htmlentities(str_replace('<?','',str_replace('<?php','',str_replace('?>','',$_POST['block_params']))))):'';
    $active		= isset($_POST['active'])?1:0;
	
	$qry = "
	
		update 
			".$this->table_prefix."blocks 
		set 
			block_title			= '".$title."',
			".@$fieldTitle."
			block_page			= '".$display."',
			block_title_show	= '".$active."',
			block_params		= '".$wparam."'
		where 
			block_name		= '".$blockName."' and 
			block_position	= '".$position."' and 
			block_theme		= '".$this->site->theme()."'
	";
	
	$this->db->execute($qry);
	
	$response = array(
		
		'act' 		=> 'updateWidget',
		'newWidget' => '',
		'position' 	=> $position
	);
}

echo json_encode($response);
?>