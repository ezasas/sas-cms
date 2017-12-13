<?php

/** CNI - PHP Datagrid Class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
require systemPath.'pagination.php';

class Data{

	function data($db,$tablePrefix,$site,$adminName,$permalink,$thisURL,$thisPage,$adminUrl,$lastUri,$getVar,$activeLang){			
	
		global $config;
		
		$this->db 				= $db;
		$this->tablePrefix		= $tablePrefix;
		$this->adminName		= $adminName;
		$this->adminUrl			= $adminUrl;
		$this->permalink		= $permalink;
		$this->thisURL			= $thisURL;
		$this->thisPage			= $thisPage;
		$this->lastUri			= $lastUri;
		$this->_GET				= $getVar;
		$this->config 			= new stdClass();
		$this->config->baseurl 	= $config['baseURL'];
		$this->activeLang		= $activeLang;
		$this->site				= $site;
		$this->isMultiLang		= $this->site->isMultiLang();
	}
	
	function getLang($lang=''){
		$getLang = $this->isMultiLang?$this->activeLang:'en';
		if(file_exists(systemPath.'lang/'.$getLang).'.php'){
			include systemPath.'lang/'.$getLang.'.php';			
			if(!empty($lang))return @$_LANG[$lang];
			else return $_LANG;
		}
		else{
			return 'Lang <strong>'.strtoupper($this->activeLang).'</strong> doesn\'t exists';
		}		
	}
	
	function onUpdate($function=''){
	
		$this->functionUpdate = $function;
		return $this->functionUpdate;
	}
	
	function onDelete($function=''){
	
		$this->functionDelete = $function;
		return $this->functionDelete;
	}
	
	function addSearch($field=''){
		$this->searchInput 	= $field!=''?true:false;
		$this->xSearch 		= $field;
	}
	
	function addWhere(){
		$addWhere = $this->xSearch;
		return $addWhere;
	}
	
	function init($query,$numRows=10,$navNumber=5){
		
		$numRows	= isset($this->_GET['d'])?$this->_GET['d']:$numRows;		
		$arrQuery 	= explode('where',$query);	
		$order		= isset($arrQuery[1])?explode('order by',@$arrQuery[1]):explode('order by',@$arrQuery[0]);
		$orderBy	= isset($order[1])?'order by'.@$order[1]:'';
		$select		= str_replace($orderBy,'',@$arrQuery[0]);
		$condition	= str_replace($orderBy,'',@$arrQuery[1]);
		$searchCond	= '';
		$getWhere 	= '';

		if(@$this->searchInput){
		
			$searchKeyword 	= urldecode(@$this->_GET['k']);
			$fieldKey 		= explode(',',$this->xSearch);
			
			foreach($fieldKey as $vWhere){
				
				$searchCond .= ' or '.$vWhere.' like\'%'.anti_injection($searchKeyword).'%\'';
			}
			
			$searchCond = substr($searchCond,4);
			$searchCond = '('.$searchCond.')';
		}
		
		$getWhere = !empty($condition) && empty($searchCond)?' where '.$condition:$getWhere;
		$getWhere = !empty($condition) && !empty($searchCond)?' where '.$condition.' and '.$searchCond:$getWhere;
		$getWhere = empty($condition) && !empty($searchCond)?' where '.$searchCond:$getWhere;
		$getWhere.= ' '.$orderBy;
		
		$getQuery = $select.' '.$getWhere;

		$this->pagination = new pagination($this->db,$getQuery,$numRows,$navNumber,$this->permalink,$this->thisPage,$this->lastUri);
	}
	
	function getRows(){
		$getRows = $this->pagination->getRows();
		return $getRows;
	}
	
	function arrData(){
		$arrData = $this->pagination->arrData();
		return $arrData;
	}
	function getNav(){
		$getRows = $this->pagination->pageNav();
		return $getRows;
	}
	function debug($debug=false){
		$this->isDebug = $debug;
	}
	function getPage($tablename,$tableId,$data,$deleteButton=true,$savebutton=true,$formName='form',$addHtml='',$static=false){
		
		global $system;
		
		/* Debug [check query] */
		if(@$this->isDebug){adodb_pr($this->pagination->getQuery());}
		
		/* Listing data */
		$errorMsg = '';
		$types	  = '';
		$th		  = '';
		$row	  = '';
		$out	  = '';
		$token 	  = $this->token('dcode');
		
		if(isset($_POST['save'.$formName])){
			if(!$system->config['demo']){
				$errorMsg = !$this->update($tablename,$tableId,@$_POST['data'])?$this->alert('success',$this->getLang('update_success')):$this->alert('error',$this->getLang('update_error'));
			}
			else{
				$errorMsg = $this->alert('error',$this->getLang('disable_update'));
			}
		}
		if(isset($_POST['delete'.$formName])){
			
			if(!$this->delete($tablename,$tableId,@$_POST['cek'],@$this->dataImage)){
				$errorMsg = $this->alert('success',$this->getLang('delete_success'));
			}
			else {
				$errorDel = $this->demo?$this->getLang('disable_delete'):$this->getLang('delete_error');
				$errorMsg = $this->alert('error',$errorDel);
			}
		}
		if($system->_GET('dm')=='1'){
			$errorMsg = $this->alert('error',$this->getLang('disable_delete'));
		}
		$varMsg   = 'errorMsg'.$formName;		
		$$varMsg  = !empty($errorMsg)?$errorMsg:'';		
		
		$cData 	= count($data);
		
		foreach($data as $k => $v){
			
			$xField			= explode('.',$v);
			$title[]		= $k;
			$field[]		= array_key_exists(0, $xField)?$xField[0]:'';
			$type[]			= array_key_exists(1, $xField)?$xField[1]:'';
			$imgUrl[]		= array_key_exists(2, $xField)?$xField[2]:'';
			$option[]		= array_key_exists(2, $xField)?$xField[2]:'';
			$modul[]		= array_key_exists(2, $xField)?$xField[2]:'';
			$caption[]		= array_key_exists(2, $xField)?$xField[2]:'';
			$function[]		= array_key_exists(2, $xField)?$xField[2]:'';
			$extra['th'][]	= array_key_exists(3, $xField)?$xField[3]:'';
			$extra['td'][]	= array_key_exists(4, $xField)?$xField[4]:'';
			$sortable[]		= array_key_exists(5, $xField)?$xField[5]:'';
			$types     	   .= $xField[1].',';
		}
		$getSortable  = '';
		if(!$static){
			$th   		 .= '<th width="16"><label class="position-relative"><input class="ace" type="checkbox" id="chkall"/><span class="lbl"></span></label></th>';
			$getSortable  = '{"bSortable": false }';
		}

		$addJs 	 	  = '';
		
		for($i=0;$i<$cData;$i++){
		
			$thClass = $type[$i] == 'select' ? ' class="catTh"':'';
			$thTitle = $type[$i] == 'checkbox'?'<th class="thCheck" '.$extra['th'][$i].'>'.$title[$i].'</th>':'<th'.$thClass.' '.$extra['th'][$i].'>'.$title[$i].'</th>';
			$thTitle = $type[$i] == 'search'?'':$thTitle;
			$th 	.= $type[$i] == 'edit' || $type[$i] == 'delete' || $type[$i] == 'reply'? '':$thTitle;
			
			if($type[$i] != 'edit' && $type[$i] != 'delete' && $type[$i] != 'reply'){
				
				$xSort	= $sortable[$i]=='sortable'?'null':'{"bSortable": false }';
				$getSortable .= ','.$xSort;
			}
		}
		
		$getSortable = !$static?$getSortable:substr($getSortable,1);

		$threply   = preg_match('/\breply\b/i',$types)?1:0;
		$thedit    = preg_match('/\bedit\b/i',$types)?1:0;
		$thdelete  = preg_match('/\bdelete\b/i',$types)?1:0;
		if($threply==1 || $thedit==1 || $thdelete==1){ 
			$th	.= '<th width="65">Option</th>';
			$getSortable .= ',{"bSortable": false }';
		}
		$th = '<thead><tr>'.$th.'</tr></thead>';
		
		if(count($this->arrData())>0){
		
			foreach($this->arrData() as $data){
			
				$row   .= '<tr>';
				
				if(!$static){
				
					$row   .= '<td class="checkAll"><label><input class="ace" type="checkbox" name="cek[]" value="'.$data[$tableId].'" class="chk"/><span class="lbl"></span></label></td>';
				}
				$edit 	= false;
				$delete = false;
				
				$btnOption = array();
				
				for($i=0;$i<$cData;$i++){
					
					$vField 	= $field[$i];
					$optionVal 	= '';
					$fValue 	= strDecode(@$data[$vField]);

					switch ($type[$i]){
						
						case 'inputText':
						
							$sData = '<td '.$extra['td'][$i].'><input type="text" class="form-control" name="data['.$data[$tableId].']['.$vField.']" value="'.$fValue.'" '.$option[$i].'/></td>';
							break;
						
						case 'text':
						
							$sData = '<td '.$extra['td'][$i].'>'.$fValue.'</td>';
							break;
						
						case 'custom':
							$params = array(
								
								'adminName'   => $this->adminName,
								'adminURL'    => $this->adminUrl,
								'tablePrefix' => $this->tablePrefix,
								'permalink'   => $this->permalink,
								'thisURL'     => $this->thisURL
							);
							$sData = '<td '.$extra['td'][$i].'>'.$function[$i]($data,$params).'</td>';
							break;
							
						case 'image':
						
							$sData = '<td '.$extra['td'][$i].'><img src="'.$imgUrl[$i].$data[$vField].'" '.$extra['td'][$i].' /></td>';
							break;
							
						case 'select':
						
							$sdata  = 'select';
							$isRef  = strpos($option[$i],'refTable');						
							$ref    = $isRef !== false ? 1:0;
							$sClass = 'select2';
							
							if($ref == 1){
								
								$xSelect  	= explode(':',$option[$i]);
								$xRef	  	= explode(',',$xSelect[1]);
								$refID		= get_string_between($xRef[1],'(',')');
								$refField 	= get_string_before($xRef[1],'(');
								$refTable 	= $xRef[0];
								$qry	 	= "select ".$refID.",".$refField." from ".$refTable;							
								$rsSelect	= $this->db->execute($qry);
								$optionVal .= '<option value="0">None</option>';
								
								while($rOption = $rsSelect->fetchRow()){
									
									$idRef	  	= $rOption[$refID];
									$selected 	= $rOption[$refID] == $data[$vField] ? 'selected="true"':'';							
									$optionVal .= '<option value="'.$idRef.'" '.$selected.'>'.$rOption[$refField].'</option>';
								}						
								
								$sData = '<td '.$extra['td'][$i].'><select name="data['.$data[$tableId].']['.$vField.']" class="'.$sClass.'">'.$optionVal.'</select></td>';						
							}
							elseif($ref == 0){
							
								$xSelect = explode(',',get_string_between($option[$i],'(',')'));
								$cSelect = count($xSelect);
								
								for($x=0;$x<$cSelect;$x++){
									$options 	= explode(' => ',$xSelect[$x]);
									$optionID 	= str_replace(' ','',$options[0]);
									$vOption 	= $options[1];
									$selected	= $optionID == $data[$vField] ? 'selected="true"':'';	
									$optionVal .= '<option value="'.$optionID.'" '.$selected.'>'.$vOption.'</option>';
								}
								
								$sData = '<td '.$extra['td'][$i].'><select name="data['.$data[$tableId].']['.$vField.']" class="'.$sClass.'">'.$optionVal.'</select></td>';
							}
							break;
						
						case 'checkbox':
						
							$checked = @$data[$vField]==1?'checked':'';
							$sData 	 = '
								<td '.$extra['td'][$i].'>								
									<label><input type="checkbox" class="ace" name="checkbox['.$data[$tableId].']['.$vField.']" value="1" '.$checked.' class="chk_'.$vField.'" /><span class="lbl"></span></label>
									'.$caption[$i].'
									<input type ="hidden" name="data['.$data[$tableId].']['.$vField.']" value="0"/>
								</td>
							';	
							break;
						
						case 'switchcheck':
						
							$checked = @$data[$vField]==1?'checked':'';
							$sData 	 = '
								<td '.$extra['td'][$i].'>
									<div class="switch-box">
										<input type="checkbox" value="1" class="ace ace-switch ace-switch-5" name="checkbox['.$data[$tableId].']['.$vField.']" '.$checked.'>							
										<span class="lbl"></span>
									</div>									
									<input type ="hidden" name="data['.$data[$tableId].']['.$vField.']" value="0"/>
								</td>
							';	
							break;
						
						case 'link':
						
							$getLink = @$modul[$i];
							$sData   = '<td '.$extra['td'][$i].'>
											<a href="'.baseURL.$getLink.'/'.@$data[$field[$i]].@$data[$tableId].'" >'.$vField.'</a>
										</td>
									   ';
							break;
						
						case 'reply':
						
							$redirectPage = substr(str_replace($this->config->baseurl,'',requestURI),1);
							$replyLink 	  = $modul[$i].'/'.$data[$tableId].'/?r='.base64_encode(baseURL.$redirectPage);
							$replyLink 	  = baseURL.$this->adminName.'/'.$replyLink;
							$sData  	  = '';
							$xreply   	  = true;
							$btnOption[]  = 'reply';
							break;
						
						case 'edit':
						
							$redirectPage = substr(str_replace($this->config->baseurl,'',requestURI),1);
							$editLink 	  = $modul[$i].'/'.$data[$tableId].'/?r='.base64_encode(baseURL.$redirectPage);
							$editLink 	  = baseURL.$this->adminName.'/'.$editLink;
							$sData  	  = '';
							$xedit   	  = true;
							$btnOption[]  = 'edit';
							break;
						
						case 'delete':						
						
							$redirectPage = substr(str_replace($this->config->baseurl,'',requestURI),1);
							$delLink 	  = baseURL.'system/del/'.$tablename.'/'.$tableId.'/'.$data[$tableId].'/?redirect='.baseURL.$redirectPage.'&scode='.$token.'" del_id="'.$data[$tableId];
							$sData		  = '';
							$xdelete 	  = true;
							$btnOption[]  = 'delete';
							break;
					}

					$row   .= $sData;
				}
				
				$buttonDesktop	= '';
				$buttonPhone 	= '';
				$btnOptions 	= false;
				
				foreach($btnOption as $btnID){
				
					$onclick = $btnID=='delete'?' onclick="if(!confirm(\''.$this->getLang('delete_confirm').'\'))return false;"':'';
					
					switch($btnID){
						
						case 'reply':
							$optLink	= $replyLink;
							$btnClass	= 'blue';
							$btnIcon	= 'reply';
						break;
						
						case 'edit':
							$optLink	= $editLink;
							$btnClass	= 'green';
							$btnIcon	= 'pencil';
						break;
						
						case 'delete':
							$optLink	= $delLink;
							$btnClass	= 'red';
							$btnIcon	= 'trash';
						break;
					}
					
					if(count($btnOption)>1){
						
						$buttonPhone .= '
							
							<li>
								<a class="button" href="'.$optLink.'" class="data-edt" title="Reply">
									<span class="'.$btnClass.'">
										<i class="fa fa-'.$btnIcon.' bigger-120"></i>
									</span>
								</a>
							</li>
						';
						$btnOptions = true;
					}
					$buttonDesktop .= '<a class="'.$btnClass.'" href="'.$optLink.'" class="data-edt" title="'.ucwords($btnID).'"'.$onclick.'><i class="fa fa-'.$btnIcon.' bigger-130"></i></a>';
				}
				
				if(!$static){
				
					if(count($btnOption)>0){
					
						if($btnOptions){
							
							$row .= '
								
								<td align="center" class="td-actions">
									
									<div class="hidden-phone visible-desktop action-buttons">
										'.$buttonDesktop.'
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline position-relative">
											<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
												<i class="fa fa-caret-down fa fa-only bigger-120"></i>
											</button>

											<ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
												'.$buttonPhone.'
											</ul>
										</div>
									</div>
								</td>
							';
						}
						else{
							$row .= '<td align="center" class="td-actions">'.$buttonDesktop.'</td>';
						}
					}
				}
				
				$row .= '</tr>';
			}
		}
		else{
			$row .= '<tr>';
			$row .= '<td colspan="'.(count($type)+1).'">';
			$row .= '<div class="no-data">No data available</div>';
			$row .= '</td>';
			$row .= '</tr>';
		}
		
		/* table top */
		$action = $this->thisURL;
		
		/* display */		
		$arrDisplay = array('10','25','50','100',);
		$display	= '';
		
		foreach($arrDisplay as $n){
			$selected = $n==@$this->_GET['d']?' selected="selected"':'';
			$display .= '<option value="'.$n.'"'.$selected.'>'.$n.'</option>';
		}
		
		$display = '<div class="display-box hide-search"><select name="d" onchange="this.form.submit()" class="select2 form-control">'.$display.'</select></div>';
		
		foreach($this->_GET as $getKey => $getVal){
			$display .= '<input type="hidden" name="'.$getKey.'" value="'.$getVal.'"/>';
		}
		
		/* search */
		if(@$this->searchInput){
		
			$xuri 			= explode('/',str_replace($this->config->baseurl,'',requestURI));
			$pageKeys	 	= array_search('page',$xuri);
			$activepageKeys = $pageKeys+1;
			
			if($this->permalink=='/'){
			
				if(!empty($pageKeys)){
					
					$actionUrl = '';
					
					foreach($xuri as $v){
						
						$arrKeys 	= array_search($v,$xuri);
						$actionUrl .= !empty($v)&&$arrKeys!=$pageKeys&&$arrKeys!=$activepageKeys?$v.'/':'';
					}
				
					$actionUrl	= substr($actionUrl,0,-1);
					$action 	= baseURL.$actionUrl.$this->permalink;		
				}
			}
			elseif($this->permalink=='.html'){
			
				if(preg_match('/page-/i',requestURI)){
				
					foreach($xuri as $v){						
						@$actionUrl .=!empty($v)&&$v!=$this->lastUri.'.html'?$v.'/':'';
					}
					$actionUrl = substr($actionUrl ,0,-1);
					$action = baseURL.$actionUrl.$this->permalink;
				}
			}
			
			$searchInput = '
			
				<div class="dataTables_filter table-search">
					<div class="form-group has-feedback">
						<input id="searchInput-'.$formName.'" type="text" name="k" autocomplete="off" class="form-control input-small nav-search-input" placeholder="Search ..." value="'.urldecode(@$this->_GET['k']).'">
						<span class="glyphicon glyphicon-search form-control-feedback icon-search" aria-hidden="true"></span>
					</div>				
				</div>
				<script>
				$("#searchInput-'.$formName.'").on("keyup", function(e) {
					
					if (e.which == 13) {
						$("#form-top-'.$formName.'").submit();
					}
				});
				</script>
			';
		}
		$span		 	= $cData+1;
		$saveBtn	 	= !$savebutton?'':'<button type="submit" name="save'.$formName.'" class="btn btn-flat btn-primary"><i class="fa fa-save bigger-110"></i>'.$this->getLang('btn_save').'</button>';
		$deleteBtn		= !$deleteButton?'':'<button type="submit" name="delete'.$formName.'" class="btn btn-flat bg-maroon" onclick="if(!confirm(\''.$this->getLang('delete_confirm').'\'))return false;"><i class="fa fa-trash bigger-110"></i>'.$this->getLang('btn_delete').'</button>';		
		$tableTop 	= '
			
			<form method="get" id="form-top-'.$formName.'" action="'.$action.'" name="'.$formName.'_top" enctype="multipart/form-data">
				<div class="row">
					<div class="col-xs-6">
						<div class="dataTables_length" id="sample-table-2_length">
							<label>
								Display 
								'.$display.'
								<span class="total-data" style="margin-left:10px">'.$this->pagination->totalData().'</span>
							</label>
						</div>
					</div>
					<div class="col-xs-6">
						'.@$searchInput.'
					</div>
				</div>
			</form>
		';
		
		$tableBottom 	= '
			
			<div class="table-bottom">	
				<div class="table-buttons">'.$saveBtn.$deleteBtn.'</div>				
				<div class="pagination-wrapper">'.$this->getNav().'</div>				
			</div>
		';
		
		#$out .= $addJs;
		$out .= $$varMsg;
		$out .= '<div class="box-body">';
		$out .= $tableTop;	
		$out .= '<form id="'.$formName.'" class="form-table" method="post" action="" name="'.$formName.'">';
		$out .= !empty($addHtml)?$addHtml:'';
		$out .= '<table id="table-'.$formName.'" class="table table-bordered table-hover dataTable">';
		$out .= $th.$row;
		$out .= '</table>';
		$out .= $tableBottom;
		$out .= '</form>';
		$out .= '</div>';
		
		if(count($this->arrData())>0){
		
			$dataTable = '
			
				<script>
				$(function() {
					var oTable1 = $("#table-'.$formName.'").dataTable( {
						"aoColumns": ['.$getSortable.'],
						"aaSorting": [],
						"bPaginate": false,
						"bFilter": false,
						"bInfo": false,
						"sWrapper": "cc",
						"bDestroy": true
					});
					$("#table-'.$formName.'_wrapper").removeClass("dataTables_wrapper");
					$(\'.dataTable th[class*="sorting_"]\').css("color","inherit");
				})
				</script>
			';
		}
		echo $out.@$dataTable;
	}	
	function removeImage($fieldName,$path){		
		$this->dataImage = array($fieldName,$path);
	}
	function delete($tablename,$tableId,$data,$dataImage=array()){
		
		global $config;
		
		$errorDelete = true;
		$status		 = array();
		$this->demo	 = false;
		
		if(!$config['demo']){
			
			
			if(is_array($data)){
			
				foreach($data as $id){
				
					$qry 		= "delete from ".$tablename." where ".$tableId."='".$id."'";
					$rsImage 	= "select ".$dataImage[0]." from ".$tablename." where ".$tableId."='".$id."'";
					$thisImg 	= $this->db->getOne($rsImage);
					
					if($tablename==$this->tablePrefix.'pages'){
					
						$dataImage	= array('content_image','modules/pages/');
						$contentID 	= $this->db->getOne("select content_id from ".$tablename." where ".$tableId."='".$id."'");
						$rsImage 	= "select ".$dataImage[0]." from ".$this->tablePrefix."pages_content where content_id='".$contentID."'";
						$thisImg 	= $this->db->getOne($rsImage);
					}
					
					if(!$this->db->execute($qry)){
						$status[] = 'error';
					}
					else{
						
						/* call functinon delete */
						$function 	 = @$this->functionDelete;
						if(!empty($function)){
						
							$functionName = get_string_before($this->functionDelete,'(');
							$params	  	  = get_string_between($this->functionDelete, '(', ')');	
							
							eval("$functionName($params);");
						}
						
						/* Remove image */
						$imgDefault = uploadPath.$dataImage[1].$thisImg;
						$imgMini 	= uploadPath.$dataImage[1].'thumbs/mini/'.$thisImg;
						$imgSmall	= uploadPath.$dataImage[1].'thumbs/small/'.$thisImg;
						$imgMedium 	= uploadPath.$dataImage[1].'thumbs/medium/'.$thisImg;
						$imgLarge 	= uploadPath.$dataImage[1].'thumbs/large/'.$thisImg;

						if (@getimagesize($imgDefault))unlink($imgDefault);
						if (@getimagesize($imgMini))unlink($imgMini);
						if (@getimagesize($imgSmall))unlink($imgSmall);
						if (@getimagesize($imgMedium))unlink($imgMedium);
						if (@getimagesize($imgLarge))unlink($imgLarge);
						
						/* Delete Content Page */
						if($tablename==$this->tablePrefix.'pages'){
						
							$delContentPage = "delete from ".$this->tablePrefix."pages_content where content_id='".$contentID."'";
							$this->db->getOne($delContentPage);
						}
					}
				}
			}
			$errorDelete = in_array('error',$status)?true:false;
		}
		else $this->demo = true;
		
		return $errorDelete;
	}
	
	function update($tablename,$tableId,$data){
	
		$errorUpdate = true;
		
		if(!is_array(@$data)){
			$errorUpdate = true;
		}
		else{
			
			foreach($data as $id => $value){
		
				$qry  = 'update '.$tablename.' set '; 
				$set  = '';	
				
				foreach($value as $k => $v){
					
					$val = isset($_POST['checkbox'][$id][$k])?$_POST['checkbox'][$id][$k]:anti_injection(htmlentities(str_replace('\\','\\\\',$v),ENT_QUOTES));	
					$set .= $k."='".$val."',";
				}
				
				$set  = substr($set,0,-1);
				$qry .= $set." where ".$tableId."='".$id."'"; 

				if($this->db->execute($qry)){
				
					$errorUpdate = false;
					$function  	 = @$this->functionUpdate;	
					
					if(!empty($function)){
					
						$functionName = get_string_before($this->functionUpdate,'(');
						$params	  	  = get_string_between($this->functionUpdate, '(', ')');	
						
						eval("$functionName($params);");
					}
				}
			}
		}		
		return $errorUpdate;		
	}
	
	function token($token){
	
		$code 		  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$securityCode = substr(str_shuffle($code),0,10);
		
		$_SESSION[$token] = md5(base64_encode($securityCode));
		return $securityCode;		
	}
	
	function alert($alert,$message){
		
		switch($alert){
			
			case'warning':
			
				$getAlert = '
					
					<div class="alert alert-warning">						
						<button data-dismiss="alert" class="close" type="button">&times;</button>
						<strong>
							<i class="fa fa-exclamation-sign"></i>
							Warning!
						</strong>
						'.$message.'
						<br>
					</div>
				';
				break;
				
			case'success':
			
				$getAlert = '
					
					<div class="alert alert-success">
						<button data-dismiss="alert" class="close" type="button">&times;</button>
						<strong>
							<i class="fa fa-ok-sign"></i>
							Success!
						</strong>
						'.$message.'
						<br>
					</div>
				';
				break;
				
			case'error':
			
				$getAlert = '
					
					<div class="alert alert-danger">						
						<button data-dismiss="alert" class="close" type="button">&times;</button>
						<strong>
							<i class="fa fa-remove-sign"></i>
							Error!
						</strong>
						'.$message.'
						<br>
					</div>
				';
				break;
				
			case'info':
			
				$getAlert = '
					
					<div class="alert alert-info">						
						<button data-dismiss="alert" class="close" type="button">&times;</button>
						<strong>
							<i class="fa fa-info-sign"></i>
							Info!
						</strong>
						'.$message.'
						<br>
					</div>
				';
				break;
			
		}
		
		return $getAlert;
	}
}
?>