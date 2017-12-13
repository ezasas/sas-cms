<?php if (!defined('basePath')) exit('No direct script access allowed');

if(isset($_POST['scan'])){

	$rsModule  = $this->db->execute("select module_name from ".$this->table_prefix."modules");

	while($row = $rsModule->fetchRow()){
		$modules[] = $row['module_name'];
	}
	if($handle = opendir(modulePath)){

		while (false !== ($file = readdir($handle))){
		
			if($file !=='.' and $file !=='..' and $file !=='..' and $file !=='index.php'){
				$arrModule[] = $file;
			}
		}		
		closedir($handle);
	}

	foreach($arrModule as $mdl){
		
		if(!in_array($mdl,$modules)){
			$this->db->execute("insert into ".$this->table_prefix."modules set module_name='".$mdl."'");
		}
	}
}
?>