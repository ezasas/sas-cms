<?php
class tree{
	
	function tree($db,$permalink,$lastUri,$adminUrl,$thisUrl){	
		
		global $config;
	
		$this->db 		 	= $db;
		$this->permalink 	= $permalink;
		$this->lastUri 		= $lastUri;
		$this->thisUrl 		= $thisUrl;
		$this->adminUrl		= $adminUrl;
		$this->config	 	= $config;
		$this->uri	 	 	= explode('/',str_replace($config['baseURL'],'',requestURI));	
		$this->xlast	 	= strlen($this->lastUri());
		$this->xfirst 	 	= $this->xlast-5;
		$this->xUri		 	= '';
		$this->xPage	 	= false;		
		
		foreach($this->uri as $k=>$v){
			
			if($v=='parent'){
			
				$this->xUri   = $this->xUri==''?$k+1:$this->xUri;
			}			
			elseif($this->xUri=='' && $v=='page'){
			
				$this->xUri  = $this->xUri==''?$k:$this->xUri;
				$this->xPage = true;
			}
		}
	}
	function linkUrl(){
	
		$arrLastUri = explode('?',$this->lastUri);
		$isGet		= $arrLastUri[0]=='search'||$arrLastUri[0]=='display'?true:false;
		$xUri 	 	= $this->xUri;
		$linkUrl 	= '';
		
		if(!empty($xUri)){
			
			for($i=0;$i<$xUri;$i++){
			
				if(!empty($this->uri[$i])){$linkUrl .= $this->uri[$i].'/';}
			}
			$linkUrl = $this->xPage == true?$linkUrl.'parent/':$linkUrl;
		}
		else{
		
			for($i=0;$i<count($this->uri);$i++){
				
				if($isGet){
					if($this->uri[$i]!=$this->lastUri){
						if(!empty($this->uri[$i])){$linkUrl .= $this->uri[$i].'/';}
					}
				}
				else{
					if(!empty($this->uri[$i])){$linkUrl .= $this->uri[$i].'/';}
				}
			}
			$linkUrl = $this->permalink=='.html'?str_replace('.html','',$linkUrl):$linkUrl;
			$linkUrl = $linkUrl.'parent/';
		}

		$linkUrl = baseURL.$linkUrl;
		return $linkUrl;
	}
	function parent_id(){
		
		$uri 	   = $this->xUri;
		$uri 	   = empty($uri)?'':$this->xUri;
		$parent_id = @$this->uri[$uri];
		
		return $parent_id ;
	}
	function lastUri(){
		$arrUri   = explode('/',str_replace($this->config['baseURL'],'',requestURI));
		
		foreach($arrUri as $k => $v){
			
			if(!empty($v)){
				$uri[] = $v;
			}
		}

		$countUri = count(@$uri)-1;
		$lastUri  = @$uri[$countUri];
		return $lastUri;
	}
	function getParent($xtable,$menuId,$parent=''){
		
		$parent = empty($parent)?$this->parent_id():$parent;
		$menu 	= $this->db->getAll("select ".$menuId.",parent_id from ".$xtable." where ".$menuId."='".$parent."'");

		foreach($menu as $v){extract($v);}
		
		@$this->id .= @$$menuId.'.'; 
		
		if(@$parent_id!=0){
			$this->getParent($xtable,$menuId,$parent_id);
			return $this->id;
		}
		else{
			return $this->id;
		}
	}
	function getArrParent($xtable,$menuId){

		$arrMenu = explode('.',$this->getParent($xtable,$menuId));
		$menu_id = array();

		foreach($arrMenu as $k => $v){
			
			if(!empty($v) && !in_array($v,$menu_id)){
				
				$menu_id[] = $v;
			}
		}
		
		return $menu_id;
	}
	function getMenuTree($arrMenu,$parent,$xtable,$menuId){
	
		global $system;
		
		if(isset($arrMenu[$parent])){ 		

			$display = in_array($parent,$this->getArrParent($xtable,$menuId))?'block':'none';
			$menu 	 = $parent==0?'<ul class="parent">':'<li class="parent"><ul id="'.$parent.'" parent="'.$parent.'" style="display:'.$display.'">';
			
			foreach($arrMenu[$parent] as $value){
                $xpgName = $system->site->isMultiLang()?'page_name_'.$system->active_lang():'page_name';
				$xpgNamex  = !empty($value[$xpgName])?$value[$xpgName]:@$value['page_name'];
				$menuTitle = $value['page_id']==0 && $value['custom_title']!=''?$value['custom_title']:$xpgNamex;
				$menuTitle = html_entity_decode($menuTitle);
				
				$linkUrl = $this->linkUrl().$value[$menuId].'/'.seo_slug($menuTitle).$this->permalink;
				$child   = $this->getMenuTree($arrMenu,$value[$menuId],$xtable,$menuId); 
				$menu   .= $parent==0?'<li>':'</li><li>';
				
				if($child){
					#$icon  = in_array($value[$menuId],$this->getArrParent($xtable,$menuId))?'treemin.jpg':'treeplus.jpg';
					$icon  = in_array($value[$menuId],$this->getArrParent($xtable,$menuId))?'minus':'plus';
					#$icon  = $this->lastUri()==$value[$menuId]?'treeopen.jpg':$icon;
					$icon  = $this->lastUri()==$value[$menuId]?'minus':$icon;
					#$menu .= '<a href="javascript:openTree('.$value[$menuId].')"><img src="'.systemURL.'form/tree/images/'.$icon.'" align="absbottom" id="img'.$value[$menuId].'"></a><a href="'.$linkUrl.'" onclick="javascript:openTree('.$value[$menuId].')">'.$menuTitle.'</a>';
					$menu .= '<i class="ace-icon tree-'.$icon.'" onclick="openTree('.$value[$menuId].')" id="icon'.$value[$menuId].'"></i><a href="'.$linkUrl.'" onclick="javascript:openTree('.$value[$menuId].')">'.$menuTitle.'</a>';
				}
				else{
					#$icon  = $this->lastUri()==$value[$menuId]?'fopen.jpg':'fclose.jpg';
					#$menu .= '<img src="'.systemURL.'form/tree/images/'.$icon.'" align="absbottom"><a href="'.$linkUrl.'">'.$menuTitle.'</a>';
					$icon  = $this->lastUri()==$value[$menuId]?'nochild active':'nochild';
					$menu .= '<span class="'.$icon.'"><i></i></span><a href="'.$linkUrl.'">'.$menuTitle.'</a>';
				}
				$menu .= '</li>';
				if($child) $menu .= $child;
			}
			$menu .= '</ul>';
			return $menu;
		}
		else return false;	  
	}
	
	function getMenu($query,$menuURL,$xtable,$id){
	
		$menuTree = '
			
			<script language="javascript">
				function openTree(id){
					var elm = $("ul[parent="+id+"]"); 					
					if(elm != undefined){
						 if(elm.css("display") == "none"){
							elm.show();
							$("#icon"+id).attr("class","ace-icon tree-minus");
						}
						else{
							elm.hide();
							$("#icon"+id).attr("class","ace-icon tree-plus");
						}
					}
				}
			</script> 
		';
		$rsQuery = $this->db->execute($query);

		while($row = $rsQuery->fetchRow()){
			$data[$row['parent_id']][]=$row;
		}

		$menuTree .= '<span class="main-parent"><i class="fa fa-th-large"></i></span><a href="'.$menuURL.'" class="main-parent">Main Parent</a>';
		$menuTree .= $this->getMenuTree(@$data,0,$xtable,$id);
		return $menuTree;
	}
	
	
	function generateTree($arrMenu,$parent,$xtable,$menuId,$title){
		
		if(isset($arrMenu[$parent])){ 		

			$display = in_array($parent,$this->getArrParent($xtable,$menuId))?'block':'none';
			$menu 	 = $parent==0?'<ul class="parent">':'<li class="parent"><ul id="'.$parent.'" parent="'.$parent.'" style="display:'.$display.'">';
			
			foreach($arrMenu[$parent] as $value){
			
				$linkUrl = $this->linkUrl().$value[$menuId].'/'.seo_slug($value[$title]).$this->permalink;
				$child   = $this->generateTree($arrMenu,$value[$menuId],$xtable,$menuId,$title); 
				$menu   .= $parent==0?'<li>':'</li><li>';
				
				if($child){
					$icon  = in_array($value[$menuId],$this->getArrParent($xtable,$menuId))?'minus':'plus';
					$icon  = $this->lastUri()==$value[$menuId]?'minus':$icon;
					$menu .= '<i class="ace-icon tree-'.$icon.'" onclick="openTree('.$value[$menuId].')" id="icon'.$value[$menuId].'"></i><a href="'.$linkUrl.'" onclick="javascript:openTree('.$value[$menuId].')">'.strDecode($value[$title]).'</a>';
				}
				else{
					$icon  = $this->lastUri()==$value[$menuId]?'nochild active':'nochild';
					$menu .= '<span class="'.$icon.'"><i></i></span><a href="'.$linkUrl.'">'.strDecode($value[$title]).'</a>';
				}
				
				$menu .= '</li>';
				if($child) $menu .= $child;
			}
			
			$menu .= '</ul>';
			return $menu;
		}
		else return false;	  
	}
	
	function getTree($query,$menuURL,$xtable,$id,$title){
	
		$menuTree = '
			
			<script language="javascript">
				function openTree(id){
					var elm = $("ul[parent="+id+"]"); 					
					if(elm != undefined){
						 if(elm.css("display") == "none"){
							elm.show();
							$("#icon"+id).attr("class","ace-icon tree-minus");
						}
						else{
							elm.hide();
							$("#icon"+id).attr("class","ace-icon tree-plus");
						}
					}
				}
			</script>
		';
		$rsQuery = $this->db->execute($query);

		while($row = $rsQuery->fetchRow()){
			$data[$row['parent_id']][]=$row;
		}

		$menuTree .= '<span class="main-parent"></span><a href="'.$menuURL.'" class="main-parent">Main Parent</a>';
		$menuTree .= $this->generateTree(@$data,0,$xtable,$id,$title);
		return $menuTree;
	}
	
	function generateMenuTree($arrMenu,$parent,$xtable,$menuId){
		global $system;
		if(isset($arrMenu[$parent])){
		
			$menu 	 = '<ol class="dd-list">';
			
			foreach($arrMenu[$parent] as $value){
			
                $xpgName   = $system->site->isMultiLang()?'page_name_'.$system->active_lang():'page_name';
				$xpgNamex  = !empty($value[$xpgName])?$value[$xpgName]:@$value['page_name'];
				$xpgNamex  = !empty($xpgNamex)?$xpgNamex:@$value['name'];
				$menuTitle = $value['page_id']==0 && $value['custom_title']!=''?$value['custom_title']:$xpgNamex;
				$menuTitle = html_entity_decode($menuTitle);
				$linkUrl   = $this->adminUrl.'edit-menu/'.$value[$menuId].'/'.seo_slug($menuTitle).$this->permalink.'?r='.base64_encode($this->thisUrl);
				$child     = $this->generateMenuTree($arrMenu,$value[$menuId],$xtable,$menuId);
				$menu     .='<li id="dd-item'.$value[$menuId].'" class="dd-item" data-id="'.$value['menu_id'].'">';
				$menu     .= '
				
					<div class="dd-handle">
						'.$menuTitle.'
						<span class="btn-handle pull-right">
							<a href="'.$linkUrl.'" class="btn-handle-edit"><i class="fa fa-pencil"></i></a>
							<a href="javascript:void(0)" class="btn-handle-trash" onclick="$(\'#tmeline'.$value[$menuId].'\').slideDown(\'fast\');return false;"><i class="fa fa-trash"></i></a>
						</span>
					</div>
					<div id="tmeline'.$value[$menuId].'" class="dd-tmeline">
						<div id="dd-progress'.$value[$menuId].'" class="dd-progress">
							Deleting..
						</div>
						<div id="dd-info'.$value[$menuId].'" class="dd-info">
							You are about to delete <strong>'.$menuTitle.'</strong> from menu
							<a hrtef="#" id="'.$value[$menuId].'" class="button" onclick="return deleteMenu(this.id)">Continue</a>
							<a hrtef="javascript:void(0)" class="button" onclick="$(\'#tmeline'.$value[$menuId].'\').slideUp(\'fast\');return false;">Cancel</a>
						</div>
					</div>
				';
				
				if($child){$menu .= $child.'</li>';}else{$menu .= '</li>';}
			}
			$menu .= '</ol>';
			return $menu;
		}
		else return false;	  
	}
	
	function getDataMenu($query,$menuURL,$xtable,$id){
	
		$rsQuery = $this->db->execute($query);

		while($row = $rsQuery->fetchRow()){
			$data[$row['parent_id']][]=$row;
		}
		@$menuTree .= $this->generateMenuTree(@$data,0,$xtable,$id);
		return $menuTree;
	}
}
?>