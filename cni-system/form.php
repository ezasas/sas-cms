<?php

/** SAS - PHP Form class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
class form{
	
	function form($db,$table_prefix,$site,$activeLang,$thisURL,$user,$adminTheme,$thumbnail){
	
		global $config;
		
		require systemPath.'form/form.input.php';
		require systemPath.'form/form.data.php';
		
		$this->db 	 		= $db;
		$this->dbName	 	= $config['db_name'];
		$this->site			= $site;
		$this->isMultiLang	= $this->site->isMultiLang();
		$this->lang			= $this->site->lang();
		$this->activeLang	= $activeLang;
		$this->user			= $user;
		$this->adminTheme	= $adminTheme;
		$this->thisURL		= $thisURL;
		$this->table_prefix	= $table_prefix;
		$this->thumbnail	= $thumbnail;
		$this->input 		= new input;
	}
	
	function getLang($lang=''){
		$getLang = $this->isMultiLang?$this->activeLang:'en';
		if(file_exists(systemPath.'lang/'.$getLang).'.php'){
			require_once systemPath.'lang/'.$getLang.'.php';
			return @$_LANG[$lang];
		}
		else{
			return 'Lang <strong>'.strtoupper($this->active_lang()).'</strong> doesn\'t exists';
		}
		
	}
	
	function isColumnExist($tableName,$columnName,$langID,$after){
		
		$newColumn		= $columnName.'_'.$langID;
		$defaultColumn 	= "select COLUMN_TYPE ,IS_NULLABLE from information_schema.columns where table_schema='".$this->dbName."' and table_name = '".$tableName."' and column_name='".$columnName."'";
		$langColumn		= "select * from information_schema.columns where table_schema='".$this->dbName."' and table_name = '".$tableName."' and column_name='".$newColumn."'";

		if($table = $this->db->getRow($defaultColumn)){

			$isNullable = $table['IS_NULLABLE']=='NO'?' NOT NULL':'';
			
			if(!$this->db->getRow($langColumn)){
			
				$createColumn = "ALTER TABLE `".$tableName."` ADD `".$newColumn."` ".$table['COLUMN_TYPE'].$isNullable." AFTER `".$after."` ;";
			
				if(!$this->db->execute($createColumn)){
					echo 'can not create column '.$newColumn.' on table '.$tableName;
				}
			}
		}
	}
	
	function beforeInsert($function=''){
	
		$this->functionBeforeInsert = $function;
		return $this->functionBeforeInsert;
	}
	
	function beforeUpdate($function=''){
	
		$this->functionBeforeUpdate = $function;
		return $this->functionBeforeUpdate;
	}
	
	function onInsert($function=''){
	
		$this->functionInsert = $function;
		return $this->functionInsert;
	}
	
	function onUpdate($function=''){
	
		$this->functionUpdate = $function;
		return $this->functionUpdate;
	}
	
	function userLog($post,$query,$tableName){
		
		$table  	= str_replace($this->table_prefix,'',$tableName);
		$actions 	= explode(' ',$query);
		$action  	= $actions[0];
		$action	 	= $action=='insert'?'add new':$action;
		$accessPage	= $this->thisURL;
		
		switch($table){
			
			case 'banner':
			
				$title 		= isset($post['add_title'])?$post['add_title']:'';
				$activity 	= $action.' '.$table.'';
				break;
			
			case 'blocks':
			
				$title 		= isset($post['add_block_name'])?$post['add_block_name']:'';
				$activity 	= '';
				break;
			
			case 'category':
			
				$title 		= isset($post['add_category_name'])?$post['add_category_name']:'';
				$activity 	= '';
				break;
			
			case 'config':
			
				$title 		= '';
				$activity 	= '';
				break;
			
			case 'links':
			
				$title 		= isset($post['add_link_title'])?$post['add_link_title']:'';
				$activity 	= '';
				break;
			
			case 'menu':
			
				$title 		= '';
				$activity 	= '';
				break;
			
			case 'modules':
			
				$title 		= isset($post['add_module_name'])?$post['add_module_name']:'';
				$activity 	= '';
				break;
			
			case 'pages':
			
				$title 		= isset($post['add_page_name'])?$post['add_page_name']:'';
				$activity 	= '';
				break;
			
			case 'pages_content':
			
				$title 		= isset($post['add_content_title'])?$post['add_content_title']:'';
				$activity 	= '';
				break;
			
			case 'pesanpublik':
			
				$title 		= isset($post['add_pesan_title'])?$post['add_pesan_title']:'';
				$activity 	= '';
				break;
			
			case 'posts':
			
				$title 		= isset($post['add_post_title'])?$post['add_post_title']:'';
				$activity 	= '';
				break;
			
			case 'user':
			
				$title 		= isset($post['add_name'])?$post['add_name']:'';
				$activity 	= '';
				break;
			
			case 'user_group':
			
				$title 		= isset($post['add_name'])?$post['add_name']:'';
				$activity 	= '';
				break;
		}
		
		$activity = $action.' '.$table.' <strong>'.@$title.'</strong>';
		
		$query_log = "
			
			insert into ".$this->table_prefix."user_log set 
			log_date 	= now(),
			user_id 	= '".$_SESSION['admin']['id']."',
			query		= '".base64_encode($query)."',
			activity	= '".htmlspecialchars($activity)."',
			aceess_page	= '".$accessPage."'
		";
		
		$this->db->execute($query_log);
	}
	function insert($post,$tableName){
		
		global $config;
		
		if(!$config['demo']){
	
			$flds 			= $this->getFlds($post);	
			$out 			= empty($flds)?'':"insert into ".$tableName." set ".$flds."";
			$function 		= @$this->functionInsert;
			$functionBefore	= @$this->functionBeforeInsert;
			$bfResponse 	= array('error'=>false,'alert'=>'');
			
			if(!empty($functionBefore)){
				
				$functionBeforeName = get_string_before($this->functionBeforeInsert,'(');
				$params	  	  		= get_string_between($this->functionBeforeInsert,'(', ')');	
				eval("\$bfResponse  = $functionBeforeName($params);");			
			}
			
			if($bfResponse['error']){
				$errorInsert = $this->alert('error',$bfResponse['alert']);
			}
			else{
				if($this->db->execute($out)){
				
					if(!empty($function)){
					
						$functionName = get_string_before($this->functionInsert,'(');
						$params	  	  = get_string_between($this->functionInsert, '(', ')');	
						
						eval("$functionName($params);");
					}
					$errorInsert = $this->alert('success',$this->getLang('insert_success'));
					unset($_POST);
				
					//$this->userLog($post,$out,$tableName);
				}
				else $errorInsert = empty($flds)?'':$this->alert('error',$this->getLang('insert_failed'));
			}
		}
		else $errorInsert = $this->alert('error',$this->getLang('disable_insert'));
		
		return $errorInsert;
	}
	function update($post,$tableName,$tableID,$tableKey){
		
		global $config;
		
		if(!$config['demo']){
			
			$flds 			= $this->getFlds($post);
			$out 			= empty($flds)?'':"update ".$tableName." set ".$flds." where ".$tableID."='".$tableKey."'";
			$function 		= @$this->functionUpdate;
			$functionBefore	= @$this->functionBeforeUpdate;
			$bfResponse 	= array('error'=>false,'alert'=>'');
			
			if(!empty($functionBefore)){
				
				$functionBeforeName = get_string_before($this->functionBeforeUpdate,'(');
				$params	  	  		= get_string_between($this->functionBeforeUpdate,'(', ')');	
				eval("\$bfResponse  = $functionBeforeName($params);");			
			}
			
			if($bfResponse['error']){
				$errorUpdate = $this->alert('error',$bfResponse['alert']);
			}
			else{
				if($this->db->execute($out)){
				
					if(!empty($function)){
					
						$functionName = get_string_before($this->functionUpdate,'(');
						$params	  	  = get_string_between($this->functionUpdate, '(', ')');	
						
						eval("$functionName($params);");
					}
					$errorUpdate = $this->alert('success',$this->getLang('update_success'));
					
					//$this->userLog($post,$out,$tableName);
				}
				else $errorUpdate = empty($flds)?'':$this->alert('error',$this->getLang('update_failed'));
			}
		}
		else $errorUpdate = $this->alert('error',$this->getLang('disable_update'));
		
		return @$errorUpdate;
	}	
	function getFlds($post){
		
		$out 	 = '';
		$setFile = '';
		$arrPost = array();

		if(isset($post['postImages'])){
	
			$i=0;
			foreach($post['postImages']['name'] as $val){
				
				$fieldFile  = str_replace('add_','',$post['postImages']['field'][$i]);
				
				if((!empty($post['postImages']['name'][$i])&&$post['postImages']['name'][$i]!=$post['postImages']['filename'][$i]) && preg_match('/add_/i',$post['postImages']['field'][$i])){
					
					$fileName		 = str_replace(getSessUser().'_','',$post['postImages']['name'][$i]);
					$setFile   		.= $fieldFile.'=\''.$fileName.'\', '; 
					$moveFile		 = tmpPath.$post['postImages']['name'][$i];
					$moveTo			 = $post['postImages']['path'][$i].$fileName;
					$thumbPath		 = $post['postImages']['thumbPath'][$i];
					$thumbPathMini	 = $post['postImages']['thumbPath'][$i].'mini/';
					$thumbPathSmall	 = $post['postImages']['thumbPath'][$i].'small/';
					$thumbPathMedium = $post['postImages']['thumbPath'][$i].'medium/';
					$thumbPathLarge	 = $post['postImages']['thumbPath'][$i].'large/';
					$extension		 = $ext = pathinfo($fileName, PATHINFO_EXTENSION);
					$mimeType 		 = explode('/',mime_content_type($moveFile));					
					
					if(!file_exists($post['postImages']['path'][$i]))mkdir($post['postImages']['path'][$i], 0777);
					if(!file_exists($thumbPath))mkdir($thumbPath, 0777);
					
					if(isFileExist($post['postImages']['path'][$i],$post['postImages']['filename'][$i])){
						@unlink($post['postImages']['path'][$i].$post['postImages']['filename'][$i]);
					}
					if(isFileExist($post['postImages']['thumbPath'][$i].'mini/',$post['postImages']['filename'][$i])){
						@unlink($post['postImages']['thumbPath'][$i].'mini/'.$post['postImages']['filename'][$i]);
					}
					if(isFileExist($post['postImages']['thumbPath'][$i].'small/',$post['postImages']['filename'][$i])){
						@unlink($post['postImages']['thumbPath'][$i].'small/'.$post['postImages']['filename'][$i]);
					}
					if(isFileExist($post['postImages']['thumbPath'][$i].'medium/',$post['postImages']['filename'][$i])){
						@unlink($post['postImages']['thumbPath'][$i].'medium/'.$post['postImages']['filename'][$i]);
					}
					if(isFileExist($post['postImages']['thumbPath'][$i].'large/',$post['postImages']['filename'][$i])){
						@unlink($post['postImages']['thumbPath'][$i].'large/'.$post['postImages']['filename'][$i]);
					}
					
					if($mimeType[0]=='image'){					
						
						$width 			= $post['postImages']['width'][$i];
						$error['copy'] 	= create_thumb($moveFile,$moveTo,$width,$extension)?0:1;

						if(!empty($post['postImages']['thumbPath'][$i])){
						
							if(!file_exists($thumbPath.'mini/'))mkdir($thumbPath.'mini', 0777);
							if(!file_exists($thumbPath.'small/'))mkdir($thumbPath.'small', 0777);
							if(!file_exists($thumbPath.'medium/'))mkdir($thumbPath.'medium', 0777);
							if(!file_exists($thumbPath.'large/'))mkdir($thumbPath.'large', 0777);
							
							$error['createThumb'] = create_thumb($moveFile,$thumbPathMini.$fileName,$setWidth=$this->thumbnail['mini'],$extension)?0:1; // mini
							$error['createThumb'] = create_thumb($moveFile,$thumbPathSmall.$fileName,$setWidth=$this->thumbnail['small'],$extension)?0:1; // small
							$error['createThumb'] = create_thumb($moveFile,$thumbPathMedium.$fileName,$setWidth=$this->thumbnail['medium'],$extension)?0:1; // medium
							$error['createThumb'] = create_thumb($moveFile,$thumbPathLarge.$fileName,$setWidth=$this->thumbnail['large'],$extension)?0:1; // large
						}
					}
					else{
						$error['copy'] = copy($moveFile, $moveTo);
					}					
				}
				elseif(empty($post['postImages']['name'][$i])&&!empty($post['postImages']['filename'][$i])){
					
					$functionBefore	= @$this->functionBeforeUpdate;
					$bfResponse 	= array('error'=>false,'alert'=>'');
					
					if(!empty($functionBefore)){
						
						$functionBeforeName = get_string_before($this->functionBeforeUpdate,'(');
						$params	  	  		= get_string_between($this->functionBeforeUpdate,'(', ')');	
						eval("\$bfResponse  = $functionBeforeName($params);");			
					}
					
					if(!$bfResponse['error']){
						$fileName	= $post['postImages']['filename'][$i];
						$setFile   .= $fieldFile.'=\'\', ';
						
						if(isFileExist($post['postImages']['path'][$i],$fileName)){
							unlink($post['postImages']['path'][$i].$fileName);
						}
						if(isFileExist($post['postImages']['thumbPath'][$i].'mini/',$fileName)){
							unlink($post['postImages']['thumbPath'][$i].'mini/'.$fileName);
						}
						if(isFileExist($post['postImages']['thumbPath'][$i].'small/',$fileName)){
							unlink($post['postImages']['thumbPath'][$i].'small/'.$fileName);
						}
						if(isFileExist($post['postImages']['thumbPath'][$i].'medium/',$fileName)){
							unlink($post['postImages']['thumbPath'][$i].'medium/'.$fileName);
						}
						if(isFileExist($post['postImages']['thumbPath'][$i].'large/',$fileName)){
							unlink($post['postImages']['thumbPath'][$i].'large/'.$fileName);
						}
					}
				}
				
				$preview[]	= 'preview_'.$post['postImages']['field'][$i];
				$i++;
			}
		}
		if(isset($post['postFiles'])){
	
			$i=0;
			foreach($post['postFiles']['name'] as $val){
				
				$fieldFile  = str_replace('add_','',$post['postFiles']['field'][$i]);
				
				if((!empty($post['postFiles']['name'][$i])&&$post['postFiles']['name'][$i]!=$post['postFiles']['filename'][$i]) && preg_match('/add_/i',$post['postFiles']['field'][$i])){
					
					$fileName		 = str_replace(getSessUser().'_','',$post['postFiles']['name'][$i]);
					$setFile   		.= $fieldFile.'=\''.$fileName.'\', '; 
					$moveFile		 = tmpPath.$post['postFiles']['name'][$i];
					$moveTo			 = $post['postFiles']['path'][$i].$fileName;
					$extension		 = $ext = pathinfo($fileName, PATHINFO_EXTENSION);
					$mimeType 		 = explode('/',mime_content_type($moveFile));
					
					if(isFileExist($post['postFiles']['path'][$i],$post['postFiles']['filename'][$i])){
						@unlink($post['postFiles']['path'][$i].$post['postFiles']['filename'][$i]);
					}
					
					$error['copy'] = copy($moveFile, $moveTo);
				}
				elseif(empty($post['postFiles']['name'][$i])&&!empty($post['postFiles']['filename'][$i])){
				
					$fileName	= $post['postFiles']['filename'][$i];
					$setFile   .= $fieldFile.'=\'\', ';
					
					if(isFileExist($post['postFiles']['path'][$i],$fileName)){
						unlink($post['postFiles']['path'][$i].$fileName);
					}					
				}
				$i++;
			}
		}
		if(!empty($post)){

			foreach($post as $k => $v){

				if($k == 'checkbox'){
					
					foreach($v['value'] as $xid => $xval){$xcheck[$xid] = '';}	
					
					if(is_array(@$v['check'])){
					
						foreach($v['check'] as $checkfield => $checkvalue){
						
							if(is_array($checkvalue)){
								
								if(count($checkvalue)>1){
									$xv = serialize($checkvalue);
								}
								else{
									foreach($checkvalue as $xval){
										$xv = $xval;
									}
								}
								$vcheck[$checkfield] = $xv;
							}
						}					
					}
					foreach($xcheck as $cid => $cval){

						$v   = !empty($vcheck[$cid])?$vcheck[$cid]:$cval;
						$out.= !in_array($cid,$arrPost)?str_replace('add_','',$cid).'=\''.$v.'\', ':'';
						
						$arrPost[] = $cid;
					}
				}
				elseif($k == 'switchcheck'){
				
					foreach($post['switchcheck'] as $fieldName => $postVar){
						
						$xField = @$postVar['value']==@$postVar['field'] && preg_match('/add_/i',$fieldName)?true:false;
						
						if(preg_match('/add_/i',$fieldName)){
						
							$getVal  = $xField?1:0;
							$out	.= str_replace('add_','',$fieldName).'=\''.$getVal.'\', ';
						}						
					}					
				}
				elseif(preg_match('/add_/i',$k)){
					
					if(preg_match('/md5/i',$k)){
				
						$k		= substr($k,8);
						$field  = str_replace('add_','',$k);
						$out   .= !in_array($k,$arrPost)?$field.'=\''.anti_injection(md5(base64_encode($v))).'\', ':'';
					}else{
						
						if(is_array($v)){
							
							if(count($v)>1){
								$xv = serialize($v);
							}
							else{
								foreach($v as $xval){
									$xv = $xval;
								}
							}
							$v = $xv;
						}
						$field  = str_replace('add_','',$k);
						$out   .= !in_array($k,$arrPost)?$field.'=\''.strEncode($v).'\', ':'';
					}
					$arrPost[] = $k;
				}
			}
		}

		$out = $out.$setFile;
		$out = substr($out,0,-2);

		return $out;
	}
	
	function getTable($sqltable){
	
		if(is_array($sqltable)){
			foreach($sqltable as $k=>$v){
				$key[] = $k;
				$val[] = $v;
			}
			$table['name'] = $val[0];
			$table['id']   = @$key[1];
			$table['key']  = @$val[1];
		}
		else{
			$table['name'] = $sqltable;
		}
		return $table;
	}
	
	function getForm($act,$sqltable,$arrInput,$formName='form',$submitValue='Submit',$finishBotton=false,$resetBotton=false,$extra=''){
	
		$form  		= '';	
		$msg   		= '';		
		$table 		= $this->getTable($sqltable);
		$divClass  = 'form-group';
		
		
		if($finishBotton){
			
			$redirect = base64_decode(substr(get_string_after(requestURI,'r='),1));
		}
		
		switch($act){
		
			case 'add':

				$row = array();
				if(isset($_POST['save_'.$formName])){$msg = $this->insert($_POST,$table['name']);clearTemp(tmpPath);}				
				break;
			
			case 'edit':
				
				$getRow = $this->db->getAll("select * from ".$table['name']." where ".$table['id']."='".$table['key']."'");

				foreach($getRow as $v){
					extract($v);
					$row = $v;
				}
				if(isset($_POST['save_'.$formName])){$msg = $this->update($_POST,$table['name'],$table['id'],$table['key']);clearTemp(tmpPath);}				
				break;
		}

		$form .= '<script type="text/javascript" src="'.systemURL.'plugins/js/upload.file.js"></script>';		
		$form .= '<script type="text/javascript" src="'.systemURL.'form/ckeditor/ckeditor/ckeditor.js"></script>';
		$form .= '<form enctype="multipart/form-data" method="POST" action="" name="'.$act.strtolower($formName).'" id="'.$act.strtolower($formName).'" '.$extra.'>';

		$form .= $msg;
		
		$i 	= 0;
		$xi = 0;
		foreach($arrInput as $input){
		
			if(preg_match('/add_/i',@$input['name'])){

				if(preg_match('/md5/i',$input['name'])){
					$field	= substr($input['name'],0,-3);
					$field  = str_replace('add_','',$input['name']);
				}else{
					$field  = str_replace('add_','',$input['name']);
				}
			}			
			if(isset($_POST['checkbox']['value'][@$input['name']])){

				$valCheckbox = array();
				foreach($_POST['checkbox']['value'][$input['name']] as $xid => $xval){
					$valCheckbox[] = isset($_POST['checkbox']['check'][$input['name']][$xid])?$_POST['checkbox']['check'][$input['name']][$xid]:$_POST['checkbox']['value'][$input['name']][$xid];
				}
				$_POST[$input['name']] = $valCheckbox;
			}
			
			$postValue = '';
			if(isset($_POST[@$input['name']])){
				$postValue = $_POST[@$input['name']];
				if(!is_array($_POST[@$input['name']])){
					$postValue = htmlspecialchars($_POST[@$input['name']]);
				}
			}
			
			$value 		= isset($row[@$field])?$row[$field]:@$input['value'];
			$value 		= isset($_POST[@$input['name']])?$postValue:html_entity_decode($value);
			$comment	= !empty($input['comment'])?' <small class="text-warning">'.$input['comment'].'</small>':'';
			$label 		= !empty($input['label'])?'<label class="control-label">'.$input['label'].$comment.'</label>':'';
			
			switch($input['type']){
				
				case 'plaintext':
				
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '<span class="text" style="width:'.$input['size'].'px;display:block;">'.$value.'</span>';
					$form .= '<input type="hidden" name="'.$input['name'].'" value="'.$value.'" />';
					$form .= !empty($input['comment'])?'<span class="help-inline">'.$input['comment'].'</span>':'';
					$form .= '</div>';
					break;
				
				case 'text':
					
					$inputText	= '';
					
					if($this->site->isMultiLang()){

						if($input['multilang']){
			
							$getLang	= $this->site->getLang();	
							$lang		= $this->site->lang();							
							$getInput	= '';
							$selectLang = '';
							$activeLang = '';
							$addJs 		= '';
							$after		= str_replace('add_','',$input['name']);
							
							foreach($this->site->lang() as $langID=>$langVal){								
								
								$this->isColumnExist($table['name'],str_replace('add_','',$input['name']),$langID,$after);								
								
								$value 		 = isset($row[@$field.'_'.$langID])?$row[$field.'_'.$langID]:@$input['value'];
								$value 		 = isset($_POST[$input['name'].'_'.$langID])?$_POST[$input['name'].'_'.$langID]:$value;
								$comment 	 = !empty($input['comment'])?' <small class="text-warning">'.$input['comment'].'</small>':'';
								$display	 = $langID!=$this->activeLang?' style="display:none;"':'';
								$label 		 = '<label class="control-label">'.$input['label'].' '.$langVal.$comment.'</label>';
								$getInput   .= '<div class="tab-'.$langID.'"'.$display.'>'.$label.'<div class="controls"><input type="text" id="'.$input['name'].'-'.$langID.'" name="'.$input['name'].'_'.$langID.'" value="'.$value.'" size="'.$input['size'].'" '.str_replace('langID',$langID,$input['extra']).'/></div></div>';
								
								$after = str_replace('add_','',$input['name']).'_'.$langID;
							}
							$inputText .= $getInput;
						}
						else{
							$inputText .= $label.'<div class="controls"><input type="text" name="'.$input['name'].'" value="'.$value.'" size="'.$input['size'].'" '.$input['extra'].'/></div>';
						}
					}
					else{
						$inputText .= $label.'<div class="controls"><input type="text" name="'.$input['name'].'" value="'.$value.'" size="'.$input['size'].'" '.$input['extra'].'/></div>';
					}
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $inputText;
					$form .= '</div>';
					break;
					
				case 'password':
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '<div class="controls"><input type="password" name="md5_'.$input['name'].'" value="'.$value.'" size="'.$input['size'].'" '.$input['extra'].'/></div>';
					$form .= '</div>';
					break;
				
				case 'hidden':
					$value = !empty($input['value'])?$input['value']:$value;
					$form .= '<input type="hidden" name="'.$input['name'].'" value="'.$value.'" '.$input['extra'].'/>';
					break;
				
				case 'textarea':
					
					$cols		= $input['editor']==true?$input['cols']*10:$input['cols'];
					$rows		= $input['editor']==true?$input['rows']*10:$input['rows'];
					
					if($input['editor']){
						
						if($input['multilang'] && $this->site->isMultiLang()){
			
							$getLang	= $this->site->getLang();	
							$lang		= $this->site->lang();							
							$getInput	= '';
							$selectLang = '';
							$activeLang = '';
							$addJs 		= '';
							$after		= str_replace('add_','',$input['name']);
							
							foreach($this->site->lang() as $langID=>$langVal){								
								
								$this->isColumnExist($table['name'],str_replace('add_','',$input['name']),$langID,$after);								
								
								$value 		 = isset($row[@$field.'_'.$langID])?$row[$field.'_'.$langID]:@$input['value'];
								$value 		 = isset($_POST[$input['name'].'_'.$langID])?$_POST[$input['name'].'_'.$langID]:$value;
								$value		 = htmlspecialchars_decode($value);
								$comment 	 = !empty($input['comment'])?' <small class="text-warning">'.$input['comment'].'</small>':'';
								$display	 = $langID!=$this->activeLang?' style="display:none;"':'';
								$label 		 = '<label>'.$input['label'].' '.$langVal.$comment.'</label>';
								
								$getInput .= '
								
									<div class="tab-'.$langID.'"'.$display.'>
										<div class="'.$divClass.'">
											'.$label.'
											<div class="controls"><textarea class="ckeditor" id="'.$input['name'].'_'.$langID.'" name="'.$input['name'].'_'.$langID.'" cols="'.$cols.'" rows="'.$rows.'">'.$value.'</textarea></div>
										</div>
										
										<script type="text/javascript">
											var neditor = CKEDITOR.replace( "'.$input['name'].'_'.$langID.'" );
										</script>
									</div>
								';
							}
							$form .= $getInput;
						}						
						else{
							
							$form .= '
							
								<div class="'.$divClass.'">
									'.$label.'
									<div class="controls"><textarea class="ckeditor" id="'.$input['name'].'" name="'.$input['name'].'" cols="'.$cols.'" rows="'.$rows.'">'.$value.'</textarea></div>
								</div>
								
								<script type="text/javascript">
									var neditor = CKEDITOR.replace( "'.$input['name'].'" );
								</script>
							';
						}
					}
					else{
						
						if($input['multilang'] && $this->site->isMultiLang()){
			
							$getLang	= $this->site->getLang();	
							$lang		= $this->site->lang();							
							$getInput	= '';
							$selectLang = '';
							$activeLang = '';
							$addJs 		= '';
							$after		= str_replace('add_','',$input['name']);
							
							foreach($this->site->lang() as $langID=>$langVal){								
								
								$this->isColumnExist($table['name'],str_replace('add_','',$input['name']),$langID,$after);								
								
								$value 		 = isset($row[@$field.'_'.$langID])?$row[$field.'_'.$langID]:@$input['value'];
								$value 		 = isset($_POST[$input['name'].'_'.$langID])?$_POST[$input['name'].'_'.$langID]:$value;
								$comment 	 = !empty($input['comment'])?' <small class="text-warning">'.$input['comment'].'</small>':'';
								$display	 = $langID!=$this->activeLang?' style="display:none;"':'';
								$label 		 = '<label>'.$input['label'].' '.$langVal.$comment.'</label>';
								$getInput   .= '<div class="tab-'.$langID.'"'.$display.'>'.$label.'<div class="controls"><textarea name="'.$input['name'].'_'.$langID.'" cols="'.$cols.'" rows="'.$rows.'" '.str_replace('langID',$langID,$input['extra']).'>'.stripslashes($value).'</textarea></div></div>';
								
								$after = str_replace('add_','',$input['name']).'_'.$langID;
							}
							$form .= $getInput;
						}						
						else{
							$form .= '
							
								<div class="'.$divClass.'">
									'.$label.'
									<div class="controls"><textarea name="'.$input['name'].'" cols="'.$cols.'" rows="'.$rows.'" '.$input['extra'].'>'.stripslashes($value).'</textarea></div>
								</div>
							';
						
						}
					}				
					break;
				
				case 'select':
				
					$opt 		= '';
					$arrOption  = array();
					
					if($ck = @unserialize($value)){
						$arrVal = $ck;
					}
					else{
						$arrVal = array($value);
					}
					
					$optionsVal = is_array($arrVal[0])?$arrVal[0]:$arrVal;
					$optionsVal = $input['multiple'] == true ? $optionsVal : $arrVal;
					
					if(isset($input['arrOption']['addoption']) && is_array($input['arrOption']['addoption'])){
						
						foreach($input['arrOption']['addoption'] as $k => $v){
					
							$selected = in_array($k,$optionsVal)?'selected="true"':'';
							$opt .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
						}
					}
					if(isset($input['arrOption']['reftable'])){
						
						$tablename	= @$input['arrOption']['reftable']['name'];
						$tableid	= @$input['arrOption']['reftable']['id'];
						$tablefield	= @$input['arrOption']['reftable']['field'];
						$tablecond	= @$input['arrOption']['reftable']['cond'];						
						
						if($rsOption = $this->db->execute('select '.$tableid.','.$tablefield.' from '.$tablename.' '.$tablecond)){
							
							while($xrow = $rsOption->fetchRow()){
								$arrOption[$xrow[$tableid]] = $xrow[$tablefield];
							}
							
							foreach($arrOption as $k => $v){
								
								$selected = in_array($k,$optionsVal)?'selected="true"':'';
								$opt .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
							}
						}
					}
					$multiple   = $input['multiple'] == true ? ' multiple':'';
					$selectName = $input['multiple'] == true ? $input['name'].'[]':$input['name'];
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '<div class="controls"><select name="'.$selectName.'" '.$input['extra'].$multiple.'>'.$opt.'</select></div>';
					$form .= '</div>';
					break;
				
				case 'checkbox':

					if(is_array($value)){
						$value = serialize($value);
					}

					if($ck = @unserialize($value)){
						$arrVal = $ck;
					}
					else{
						$arrVal = array($value);
					}

					$checkbox = '';
					$arrCheck = array();
					
					if(isset($input['arrCheck']['addcheck']) && is_array($input['arrCheck']['addcheck'])){
						
						foreach($input['arrCheck']['addcheck'] as $k => $v){
							
							$checked 	= in_array($k,$arrVal)?'checked="checked"':'';
							$checkbox  .= '
							
								<label class="inline"><input type="checkbox" class="ace" name="checkbox[check]['.$input['name'].']['.$k.']" value="'.$k.'" '.$checked.'>
								<span class="lbl"> '.$v.'</span></label>'
							;
							$checkbox  .= '
							
								<input type="hidden" name="checkbox[value]['.$input['name'].']['.$k.']" value="0" '.$checked.'>'
							;
						}
					}
					if(isset($input['arrCheck']['reftable'])){
						
						$tablename	= @$input['arrCheck']['reftable']['name'];
						$tableid	= @$input['arrCheck']['reftable']['id'];
						$tablefield	= @$input['arrCheck']['reftable']['field'];
						$tablecond	= @$input['arrCheck']['reftable']['cond'];						

						if($rsCheck = $this->db->execute('select '.$tableid.','.$tablefield.' from '.$tablename.' '.$tablecond)){
						
							while($row = $rsCheck->fetchRow()){
								$arrCheck[$row[$tableid]] = $row[$tablefield];
							}

							foreach($arrCheck as $k => $v){
								
								$checked 	= in_array($k,$arrVal)?'checked="checked"':'';
								$checkbox  .= '<label class="inline"><input type="checkbox" class="ace" name="'.$input['name'].'['.$k.']" value="'.$k.'" '.$checked.'><span class="lbl"> '.$v.'</span></label>';
							}
						}
					}
					
					$form .= '<div class="'.$divClass.'" '.$input['extra'].'>';
					$form .= $label;
					$form .= '<div class="controls">'.$checkbox.'</div>';
					$form .= '</div>';
					break;
					
				case 'switchcheck':

					$switchCheckVal = isset($_POST['switchcheck'][$input['name']]['field'])&&isset($_POST['switchcheck'][$input['name']]['value'])?1:$value;
					$switchCheckVal = isset($_POST['switchcheck'][$input['name']]['field'])&&!isset($_POST['switchcheck'][$input['name']]['value'])?0:$switchCheckVal;
				
					$checked = $switchCheckVal==1?'checked="checked"':'';
					$checked = $act=='add' && $input['checked']?'checked="checked"':$checked;
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '
						<div class="controls '.$input['addClass'].'">
							<div class="switch-box">
								<input type="checkbox" value="1" class="ace ace-switch ace-switch-'.$input['skin'].'" name="switchcheck['.$input['name'].'][value]" '.$checked.'>							
								<span class="lbl"></span>
							</div>
							<input type="hidden" value="1" name="switchcheck['.$input['name'].'][field]">
						</div>
					';
					$form .= '</div>';
					break;
					
				case 'radio':

					$radio 	  = '';
					$arrRadio = array();
					
					if(isset($input['arrRadio']['addRadio']) && is_array($input['arrRadio']['addRadio'])){
						
						foreach($input['arrRadio']['addRadio'] as $k => $v){
							
							$checked 	= $k==$value?'checked="checked"':'';
							$radio  .= '
							
								<label class="inline">
									<input type="radio" class="ace" name="'.$input['name'].'" id="'.$input['name'].'_'.$k.'" value="'.$k.'" '.$checked.'>
									<span class="lbl"> '.$v.'</span>
								</label>
							';
						}
					}
					if(isset($input['arrRadio']['reftable'])){
						
						$tablename	= @$input['arrRadio']['reftable']['name'];
						$tableid	= @$input['arrRadio']['reftable']['id'];
						$tablefield	= @$input['arrRadio']['reftable']['field'];
						$tablecond	= @$input['arrRadio']['reftable']['cond'];						

						if($rsCheck = $this->db->execute('select '.$tableid.','.$tablefield.' from '.$tablename.' '.$tablecond)){
						
							while($row = $rsCheck->fetchRow()){
								$arrRadio[$row[$tableid]] = $row[$tablefield];
							}

							foreach($arrRadio as $k => $v){
								
								$checked 	= $k==$value?'checked="checked"':'';
								$radio  .= '
								
									<label class="inline">
										<input type="radio" class="ace" name="'.$input['name'].'" id="'.$input['name'].'_'.$k.'" value="'.$k.'" '.$checked.'>
										<span class="lbl"> '.$v.'</span>
									</label>
								';
							}
						}
					}
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '<div class="controls ">'.$radio.'</div>';
					$form .= '</div>';
					break;
				
				case 'image':

					$name 			= $input['name'];
					$path 			= $input['path'];
					$thumbPath		= $input['thumbPath'];
					$thumbSmall		= $thumbPath.'small/';
					$width			= $input['width'];
					$vImage			= !empty($_POST['postImages']['name'][$xi])?$_POST['postImages']['name'][$xi]:$value;
					$vImage			= str_replace(getSessUser().'_','',$vImage);
					$allowedTypes	= !empty($input['allowedTypes'])?'/'.$input['allowedTypes']:'';
					$maxsize		= $input['maxsize'];					
					$imgUrl			= baseURL.str_replace(basePath,'',$thumbSmall).$vImage;
					$imgUrl			= @getimagesize($thumbSmall.$vImage)?$imgUrl:baseURL.$this->adminTheme.'assets/img/default.jpg';
				
					$delaName = 'delete_'.$name;
					
					if(isset($_POST[$delaName])){
						
						foreach($_POST['postImages']['field'] as $xk => $xv){
						
							if(str_replace('add_','',$xv)==str_replace('delete_add_','',$delaName)){
								
								$xdel = $xk;
							}
						}
						
						$delFile = $_POST['postImages']['filename'][$xdel];
						
						if(isFileExist($path,$delFile)){
							unlink($path.$delFile);
						}
						if(isFileExist($thumbPath,$delFile)){
							unlink($thumbPath.$delFile);
						}
						$updateFile = "update ".$table['name']." set ".str_replace('add_','',$name)."='' where ".$table['id']."='".$_POST['id']."'";
						
						$this->db->execute($updateFile);
					}
					?>
					<script type="text/javascript">
					
						function changeClass<?=$name?>(set){						
							var uploadbtn = document.getElementById('button_<?=$name?>');
							uploadbtn.className = set;
						}
						
						function hidemsg_<?=$input['name']?>(){	
							$("#msg_<?=$name?>").fadeOut("slow");
						}
						function upload_<?=$name?>()
						{	

							var uploadbtn = document.getElementById('button_<?=$name?>');
							uploadbtn.className = 'off';
							
							$(".loading_<?=$name?>").fadeIn();
							
							$.ajaxFileUpload
							(
								{
								type: 'POST',
									url:'<?php echo baseURL?>system/upload<?php echo $allowedTypes.'/'.$maxsize?>',
									secureuri:false,
									fileElementId:'<?=$name?>',
									data: $.param({name:'<?=$name?>'}),
									dataType: 'json',
									success: function (data, status)
									{
										if(typeof(data.error) != 'undefined')
										{
											if(data.error != '')
											{
												$(".loading_<?=$name?>").hide();		
												$("#msg_<?=$name?>").html(data.error);
												$("#msg_<?=$name?>").fadeIn("slow");
											}else
											{
												$(".loading_<?=$name?>").hide();
												document.getElementById("file_<?=$name?>").value = data.fileName;
												$("#preview_<?=$name?>").html(data.msg);
												$("#preview_<?=$name?>").fadeIn("slow");
											}
										}
										$("input:file").val("");
									},
									error: function (data, status, e)
									{
										alert(e);
										$("input:file").val("");
									}
								}
							)
				
							return false;
						}
						function removeFile_<?=$name?>(){
							$("#preview_<?=$name?>").html('');
							$("#file_<?=$name?>").val('');
							$("#btn_remove_<?=$name?>").hide();
							$("#btn_restore_<?=$name?>").show();
							return false;
						}
						function restoreFile_<?=$name?>(){
							$("#preview_<?=$name?>").html('<img src="<?=$imgUrl?>">');
							$("#file_<?=$name?>").val("<?=$vImage?>");
							$("#btn_restore_<?=$name?>").hide();
							$("#btn_remove_<?=$name?>").show();
							return false;
						}
					</script>
					
					<?		
					$btnDelete = !empty($vImage) && isFileExist($path,$vImage)?'<a id="btn_remove_'.$name.'" href="javascript:void(0)" class="delFile" onclick="return removeFile_'.$name.'()"><i class="fa fa-trash"></i></a><a id="btn_restore_'.$name.'" href="javascript:void(0)" class="restoreFile" onclick="return restoreFile_'.$name.'()" style="display:none"><i class="fa fa-reply"></i></a>':'';

					$form .= '<div class="'.$divClass.'">';
					$form .= '
	
						'.$label.'
						
						<div class="upload-file">
						
							<div class="preview"><div id="preview_'.$name.'"><img src="'.$imgUrl.'"/></div></div>
							<span class="bg-transparent"></span>
							<div class="upload-file-input">
								
								'.$btnDelete.'
								<p class="button">
								<button id="button_'.$name.'" class="off"><i class="fa fa-upload"></i></button>
								<input type="file" 
									id="'.$name.'" 
									name="file" 
									style="
										font-size: 50px;
										position: absolute;
										opacity: 0; 
										filter:alpha(opacity: 0);
										right: 0;
										top: -1px;
										height:100px;
									"
									onMouseOver="changeClass'.$name.'(\'on\')"
									onMouseOut="changeClass'.$name.'(\'off\')"
									onChange="return upload_'.$name.'();"
									onClick="return hidemsg_'.$name.'();"
								/>
								</p>		
								
								<input type="hidden" name="postImages[field][]" value="'.$name.'">
								<input type="hidden" name="postImages[thumbPath][]" value="'.$thumbPath.'">
								<input type="hidden" name="postImages[path][]" value="'.$path.'">
								<input type="hidden" name="postImages[name][]" id="file_'.$name.'" value="'.$vImage.'">
								<input type="hidden" name="postImages[filename][]" value="'.$value.'">
								<input type="hidden" name="postImages[width][]" value="'.$width.'">
							</div>
							
						</div>
						
						<div class="loading_'.$name.' progress-upload progress progress-small progress-striped active" style="display:none;margin-top:10px;">
							<div style="width: 100%;" class="progress-bar progress-bar-warning"></div>
						</div>
						
						<div id="msg_'.$name.'" style="display:none;"></div>
					';
					$form .= '</div>';
					$i++;
					$xi++;
					break;
				
				case 'file':

					$name 			= $input['name'];
					$path 			= $input['path'];
					$allowedTypes	= !empty($input['allowedTypes'])?'/'.$input['allowedTypes']:'';
					$maxsize		= !empty($input['maxsize'])?'/'.$input['maxsize']:'';					
					$fFile			= !empty($_POST['postFiles']['name'][$xi])?$_POST['postFiles']['name'][$xi]:$value;
					$fFile			= str_replace(getSessUser().'_','',$fFile);
					$extension		= $ext = pathinfo($fFile, PATHINFO_EXTENSION);					
					$isSelected 	= !empty($fFile)?' selected':'';
					$dataTitle 		= !empty($fFile)?$fFile:'No File ...';
					$dataICon 		= !empty($fFile)?fileIcon($extension):'fa-upload';
					$dataBtn 		= !empty($fFile)?'Change':'Choose';
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '
						
						<div class="controls">
							<label class="ace-file-input">
								<input type="file" id="'.$name.'" name="file" onChange="return upload_'.$name.'();"/>
								<span id="btn-upload-'.$name.'" data-title="'.$dataBtn.'" class="ace-file-container'.$isSelected.'">
									<span data-title="'.$dataTitle.'" class="ace-file-name upload-info-'.$name.'">
										<i class="ace-icon fa '.$dataICon.'"></i>
									</span>
								</span>
								<a href="javascript:void(0)" class="remove btn_remove_'.$name.'" onclick="return removeFile_'.$name.'()"><i class=" ace-icon fa fa-times"></i></a>
							</label>
						</div>
						
						<input type="hidden" name="postFiles[field][]" value="'.$name.'">
						<input type="hidden" name="postFiles[path][]" value="'.$path.'">
						<input type="hidden" name="postFiles[name][]" id="file_'.$name.'" value="'.$fFile.'">
						<input type="hidden" name="postFiles[filename][]" value="'.$value.'">
						
					';
					$form .= '</div>';
					?>
					
					<script type="text/javascript">
					
						function upload_<?=$name?>(){
							
							$('.upload-info-<?=$name?>').attr('data-title','Uploading ...');
							
							$.ajaxFileUpload
							(
								{
								type: 'POST',
									url:'<?=baseURL?>system/uploadfile<?=$allowedTypes.$maxsize?>',
									secureuri:false,
									fileElementId:'<?=$name?>',
									data: $.param({name:'<?=$name?>'}),
									dataType: 'json',
									success: function (data, status)
									{
										if(typeof(data.error) != 'undefined')
										{
											if(data.error != '')
											{
												$('.upload-info-<?=$name?>').attr('data-title',data.error);
												$('.upload-info-<?=$name?>').html('<i class="ace-icon fa fa-upload"></i>');
												$('#btn-upload-<?=$name?>').removeClass('selected');
												$('#btn-upload-<?=$name?>').attr('data-title','Choose');
												$('#file_<?=$name?>').val('');
											}else
											{												
												$('.upload-info-<?=$name?>').attr('data-title',data.fileName);
												$('.upload-info-<?=$name?>').html('<i class="ace-icon fa '+data.fileIcon+'"></i>');
												$('#btn-upload-<?=$name?>').addClass('selected');
												$('#btn-upload-<?=$name?>').attr('data-title','Change');
												$('#file_<?=$name?>').val(data.fileUpload);
											}
										}
										$("input:file").val("");
									},
									error: function (data, status, e)
									{
										alert(e);
										$("input:file").val("");
									}
								}
							)
				
							return false;
						}
						function removeFile_<?=$name?>(){
							$("#file_<?=$name?>").val('');
							$('.upload-info-<?=$name?>').attr('data-title','No File ...');
							$('.upload-info-<?=$name?>').html('<i class="ace-icon fa fa-upload"></i>');
							$('#btn-upload-<?=$name?>').removeClass('selected');
							$('#btn-upload-<?=$name?>').attr('data-title','Choose');
							return false;
						}
					</script>
					
					<?					
					break;
				
				case 'html':
					$form .= $input['value'];
					break;
				
				case 'icon':
				
					$iconPack = array ( 'fa-adjust ', 'fa-anchor ', 'fa-archive ', 'fa-area-chart ', 'fa-asterisk ', 'fa-at ', 'fa-automobile ', 'fa-ban ', 'fa-bar-chart ', 'fa-barcode ', 'fa-bars ', 'fa-beer ', 'fa-bell ', 'fa-bell-o ', 'fa-bell-slash ', 'fa-bell-slash-o ', 'fa-bicycle ', 'fa-binoculars ', 'fa-birthday-cake ', 'fa-bolt ', 'fa-bomb ', 'fa-book ', 'fa-bookmark ', 'fa-bookmark-o ', 'fa-briefcase ', 'fa-bug ', 'fa-building ', 'fa-building-o ', 'fa-bullhorn ', 'fa-bullseye ', 'fa-bus ', 'fa-cab ', 'fa-calculator ', 'fa-calendar ', 'fa-calendar-o ', 'fa-camera ', 'fa-camera-retro ', 'fa-car ', 'fa-cc ', 'fa-certificate ', 'fa-check ', 'fa-check-circle ', 'fa-check-circle-o ', 'fa-check-square ', 'fa-check-square-o ', 'fa-child ', 'fa-circle ', 'fa-circle-o ', 'fa-clock-o ', 'fa-cloud ', 'fa-cloud-download ', 'fa-cloud-upload ', 'fa-code ', 'fa-code-fork ', 'fa-coffee ', 'fa-cog ', 'fa-cogs ', 'fa-comment ', 'fa-comment-o ', 'fa-comments ', 'fa-comments-o ', 'fa-compass ', 'fa-copyright ', 'fa-credit-card ', 'fa-crop ', 'fa-crosshairs ', 'fa-cube ', 'fa-cubes ', 'fa-cutlery ', 'fa-dashboard ', 'fa-database ', 'fa-desktop ', 'fa-dot-circle-o ', 'fa-download ', 'fa-edit ', 'fa-envelope ', 'fa-envelope-o ', 'fa-eraser ', 'fa-exchange ', 'fa-exclamation ', 'fa-exclamation-circle ', 'fa-exclamation-triangle ', 'fa-external-link ', 'fa-external-link-square ', 'fa-eye ', 'fa-eye-slash ', 'fa-eyedropper ', 'fa-fax ', 'fa-female ', 'fa-fighter-jet ', 'fa-file-archive-o ', 'fa-file-audio-o ', 'fa-file-code-o ', 'fa-file-excel-o ', 'fa-file-image-o ', 'fa-file-movie-o ', 'fa-file-pdf-o ', 'fa-file-photo-o ', 'fa-file-picture-o ', 'fa-file-powerpoint-o ', 'fa-file-sound-o ', 'fa-file-video-o ', 'fa-file-word-o ', 'fa-file-zip-o ', 'fa-film ', 'fa-filter ', 'fa-fire ', 'fa-fire-extinguisher ', 'fa-flag ', 'fa-flag-checkered ', 'fa-flag-o ', 'fa-flash ', 'fa-flask ', 'fa-folder ', 'fa-folder-o ', 'fa-folder-open ', 'fa-folder-open-o ', 'fa-frown-o ', 'fa-futbol-o ', 'fa-gamepad ', 'fa-gavel ', 'fa-gear ', 'fa-gears ', 'fa-gift ', 'fa-glass ', 'fa-globe ', 'fa-graduation-cap ', 'fa-group ', 'fa-hdd-o ', 'fa-headphones ', 'fa-heart ', 'fa-heart-o ', 'fa-history ', 'fa-home ', 'fa-image ', 'fa-inbox ', 'fa-info ', 'fa-info-circle ', 'fa-institution ', 'fa-key ', 'fa-keyboard-o ', 'fa-language ', 'fa-laptop ', 'fa-leaf ', 'fa-legal ', 'fa-lemon-o ', 'fa-life-saver ', 'fa-lightbulb-o ', 'fa-line-chart ', 'fa-location-arrow ', 'fa-lock ', 'fa-magic ', 'fa-magnet ', 'fa-mail-forward ', 'fa-mail-reply ', 'fa-mail-reply-all ', 'fa-male ', 'fa-map-marker ', 'fa-meh-o ', 'fa-microphone ', 'fa-microphone-slash ', 'fa-minus ', 'fa-minus-circle ', 'fa-minus-square ', 'fa-minus-square-o ', 'fa-mobile ', 'fa-mobile-phone ', 'fa-money ', 'fa-moon-o ', 'fa-mortar-board ', 'fa-music ', 'fa-navicon ', 'fa-newspaper-o ', 'fa-paint-brush ', 'fa-paper-plane ', 'fa-paper-plane-o ', 'fa-paw ', 'fa-pencil ', 'fa-pencil-square ', 'fa-pencil-square-o ', 'fa-phone ', 'fa-phone-square ', 'fa-photo ', 'fa-picture-o ', 'fa-pie-chart ', 'fa-plane ', 'fa-plug ', 'fa-plus ', 'fa-plus-circle ', 'fa-plus-square ', 'fa-plus-square-o ', 'fa-power-off ', 'fa-print ', 'fa-puzzle-piece ', 'fa-qrcode ', 'fa-question ', 'fa-question-circle ', 'fa-quote-left ', 'fa-quote-right ', 'fa-random ', 'fa-recycle ', 'fa-refresh ', 'fa-remove ', 'fa-reorder ', 'fa-reply ', 'fa-reply-all ', 'fa-retweet ', 'fa-road ', 'fa-rocket ', 'fa-rss ', 'fa-rss-square ', 'fa-search ', 'fa-send ', 'fa-send-o ', 'fa-share ', 'fa-share-alt ', 'fa-share-alt-square ', 'fa-share-square ', 'fa-share-square-o ', 'fa-shield ', 'fa-shopping-cart ', 'fa-sign-in ', 'fa-sign-out ', 'fa-signal ', 'fa-sitemap ', 'fa-sliders ', 'fa-smile-o ', 'fa-space-shuttle ', 'fa-spinner ', 'fa-spoon ', 'fa-square ', 'fa-square-o ', 'fa-star ', 'fa-suitcase ', 'fa-sun-o ', 'fa-support ', 'fa-tablet ', 'fa-tachometer ', 'fa-tag ', 'fa-tags ', 'fa-tasks ', 'fa-taxi ', 'fa-thumb-tack ', 'fa-thumbs-down ', 'fa-thumbs-o-down ', 'fa-thumbs-o-up ', 'fa-thumbs-up ', 'fa-ticket ', 'fa-times-circle ', 'fa-times-circle-o ', 'fa-tint ', 'fa-trash ', 'fa-trash-o ', 'fa-tree ', 'fa-trophy ', 'fa-truck ', 'fa-tty ', 'fa-umbrella ', 'fa-university ', 'fa-unlock ', 'fa-unlock-alt ', 'fa-upload ', 'fa-user ', 'fa-users ', 'fa-video-camera ', 'fa-volume-down ', 'fa-volume-off ', 'fa-volume-up ', 'fa-warning ', 'fa-wheelchair ', 'fa-wifi ', 'fa-wrench' );
					$xicon	  = '';
					
					foreach ( $iconPack as $v ) {
						
						$xicon .= '<span class="fa-icon" data-icon="'. $v .'" data-id="'.$input['id'].'" data-toggle="tooltip" data-placement="top" title="'. ucwords(str_replace('-',' ',str_replace('fa-','',$v))) .'"><i class="fa '. $v .'"></i></span>';
					}
					$iconValue = !empty($value)?$value:'fa fa-caret-right';
					$faIcons   = gzcompress($xicon,9);
					$form  	  .= '

						<div class="'.$divClass.'">
							<div class="select-icon">
							
								<span id="icon'.$input['id'].'" class="'.$iconValue.'"></span>
								<span class="btn-select btn-selectpage" data-toggle="modal" data-target="#modal-'.$input['id'].'">Select Icon</span>								
								<input type="hidden" id="input-icon'.$input['id'].'" name="'.$input['name'].'" value="'.$iconValue.'" />
								
								<div class="modal fade" id="modal-'.$input['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h4 class="modal-title" id="myModalLabel">Select icon</h4>
											</div>
											<div class="modal-body">
												<div class="fa-icon-container">'.gzuncompress($faIcons).'</div>
											</div>
											<div class="modal-footer"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					';
					
					$form .= '';
					break;
					
				case 'datepicker':
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '
						
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
									<input type="text" id="'.$input['name'].'" name="'.$input['name'].'" value="'.$value.'" class="form-control date-picker" />
									<span class="input-group-addon pointer">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						
					';
					$form .= !empty($input['comment'])?'<span class="comment">'.$input['comment'].'</span>':'';
					$form .= '</div>';
					break;
					
				case 'datetimepicker':
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '
						
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
									<input type="text" id="'.$input['name'].'" name="'.$input['name'].'" value="'.$value.'" class="form-control date-timepicker" />
									<span class="input-group-addon pointer">
										<i class="fa fa-clock-o bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						
					';
					$form .= !empty($input['comment'])?'<span class="comment">'.$input['comment'].'</span>':'';
					$form .= '</div>';
					break;
					
				case 'daterangepicker':
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '
						
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
									<input type="text" id="'.$input['name'].'" name="'.$input['name'].'" value="'.$value.'" class="form-control date-range-picker" />
									<span class="input-group-addon pointer">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						
					';
					$form .= !empty($input['comment'])?'<span class="comment">'.$input['comment'].'</span>':'';
					$form .= '</div>';
					break;
					
				case 'timepicker':
					
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '
						
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
									<input type="text" id="'.$input['name'].'" name="'.$input['name'].'" value="'.$value.'" class="form-control time-picker" />
									<span class="input-group-addon pointer">
										<i class="fa fa-clock-o bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						
					';
					$form .= !empty($input['comment'])?'<span class="comment">'.$input['comment'].'</span>':'';
					$form .= '</div>';
					break;
				
				case 'colorpicker':
				
					$defaultColor = '#fc6e51';
				
					$form .= '<div class="'.$divClass.'">';
					$form .= $label;
					$form .= '
					
						<div class="row">
							<div class="col-md-12">
								<div class="input-group input-append color">
									<input type="text" id="'.$input['name'].'" class="form-control color-picker" name="'.$input['name'].'" value="'.$value.'">
									<span class="add-on input-group-addon pointer"><i class="prev-color" style="background-color: '.$defaultColor.'"></i></span>
								</div>
							</div>
						</div>
					';
					$form .= '</div>';
					break;
			}
			
			$form .= $i<count($arrInput) && $input['type']!='hidden' && $input['type']!='html'?'<hr>':'';
			$i++;
		}
		
		$submitIcon	= $act=='edit'?'fa fa-save':'fa fa-plus';
		$submit 	= '<button type="submit" class="btn btn-flat btn-primary" name="save_'.$formName.'" id="save_'.$formName.'"><i class="'.$submitIcon.'"></i>'.$submitValue.'</button>';
		$fnish  	= $finishBotton==true?'<a href="'.$redirect.'" class="btn btn-flat btn-warning"><i class="fa fa-long-arrow-left"></i>Back</a>':'';
		$reset  	= $resetBotton==true?'<button type="reset" class="btn btn-flat btn-info" name="resset"><i class="fa fa-undo"></i>Reset</button>':'';
		
		$form .= '<div class="form-input-bottom form-actions">'.$submit.$reset.$fnish.'</div>';
		$form .= '</form>';
		echo $form;
	}
	
	function alert($alert,$message){
		
		switch($alert){
			
			case'warning':
			
				$getAlert = '
					
					<div class="alert alert-warning">						
						<button data-dismiss="alert" class="close" type="button">&times;</button>
						<strong>
							<i class="icon-exclamation-sign"></i>
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
							<i class="icon-ok-sign"></i>
							Success!
						</strong>
						'.$message.'
						<br>
					</div>
				';
				break;
				
			case'ok':
			
				$getAlert = '
					
					<div class="alert alert-success">
						<button data-dismiss="alert" class="close" type="button">&times;</button>
						<strong>
							<i class="icon-ok"></i>
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
							<i class="icon-remove-sign"></i>
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
							<i class="icon-info-sign"></i>
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