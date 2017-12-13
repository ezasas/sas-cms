<?php if (!defined('basePath')) exit('No direct script access allowed');

$arrPosition  	  = $this->widgetPosition();
$registeredWidget = $this->registeredWidget();

function widgetDisplay($fName,$fDisplay='home'){
	
	$arrOption = array('home' => 'Home Page', 'hidehome' => 'Hide Home Page', 'all' => 'All Page');
	
	foreach($arrOption as $k=>$v){
	
		$selected  = $k==$fDisplay?' selected':'';
		@$display .= '<option value="'.$k.'"'.$selected.'>'.$v.'</option>';
	}
	$display = '<select name="'.$fName.'" class="chzn-select span12">'.$display.'</select>';
	
	return $display;
}
if($this->site->isMultiLang()){
	foreach($this->site->lang() as $langID=>$langVal){
		$this->form->isColumnExist($this->table_prefix.'blocks','block_title',$langID,'block_title');	
	}
}

if(count($arrPosition)>0){
	
	$arrWidget = $this->db->getAll("select block_name,block_position from ".$this->table_prefix."blocks where block_theme='".$this->site->theme()."' order by block_order");
	$uWidget   = array();
	
	foreach($arrWidget as $w){
	
		$p = $w['block_position'];
		$uWidget[] 	 	= $w['block_name'];
		$pWidget[$p][] 	= $w['block_name'];
	}
	
	// Available Widget
	$allWidget = array();
	
	/* default widget */
	if($handle = opendir(basePath.'cni-content/blocks/')){
		
		while (false !== ($file = readdir($handle))){

			if($file !=='.' and $file !=='..' and $file !=='..' and $file !=='index.php'){
				
				if(!in_array($file,$uWidget)){
					$allWidget[$file] = str_replace('_',' ',$file);
				}
			}
		}		
		closedir($handle);
	}
	/* registered widget */
	foreach($registeredWidget as $rk=>$rv){
		if(!in_array($rk,$uWidget)){
			$allWidget[$rk] = str_replace('_',' ',$rv);
		}
	}
	ksort($allWidget);
	
	/* generate available widget */
	foreach($allWidget as $widgetID=>$widgetName){
		
		$inputTitle = '
		
			<div class="control-group">
				<label for="title-'.$widgetID.'">Title</label>
				<input type="text" id="title-'.$widgetID.'" name="title" value="'.$widgetName.'" placeholder="Widget title" class="span-12">									
			</div>
			<hr>
		';
		
		if($this->site->isMultiLang()){
		
			$inputTitle = '';
			
			foreach($this->site->lang() as $langID=>$langVal){
			
				$inputTitle .= '
				
					<div class="control-group">
						<label for="title-'.$langID.'-'.$widgetID.'">Title '.$langVal.'</label>
							<input type="text" id="title-'.$langID.'-'.$widgetID.'" name="title_'.$langID.'" value="'.$widgetName.'" placeholder="Widget title '.$langVal.'" class="span-12">									
							<input type="hidden" id="title-'.$widgetID.'" name="title" value="'.$widgetName.'">
						</div>
					<hr>
				';
			}
		}
		
		$sasText = '';
		if(preg_match('/text_/i',$widgetID)){
		
			$sasText = '
			
				<div class="control-group">
					<label for="block-params-'.$widgetID.'">Enter script here</label>
					<textarea id="block-params-'.$widgetID.'" name="block_params" class="span-12" rows="6"></textarea>
				</div>
				<hr>
			';
		}
		
		@$avblWidget .= '
			
			<li class="dd-item" data-id="'.$widgetID.'">
				<div class="dd-handle" data-id="'.$widgetID.'">
					'.$widgetName.'
					<span class="btn-handle pull-right" style="display:none">
						<a class="btn-handle-edit dd-option" data-id="'.$widgetID.'"><i class="fa fa-wrench"></i></a>
					</span>
				</div>
				<div class="dd-tmeline" id="tmeline-'.$widgetID.'" style="display: none;">
					<div id="dd-info19" class="dd-info hide-chzn-search">
						<form id="form-'.$widgetID.'" name="form-'.$widgetID.'" method="post" action="">
							<div class="control-group">
								<label for="display-'.$widgetID.'">Display</label>
								'.widgetDisplay('display').'									
							</div>
							<hr>
							'.$inputTitle.'
							<div class="control-group">
								<span for="show-'.$widgetID.'">Show title</span>
								<input id="show-'.$widgetID.'" type="checkbox" value="1" class="ace-switch ace-switch-5" name="active" checked>							
								<span class="lbl"></span>										
							</div>
							<hr>
							'.$sasText.'
							<div class="control-group sidget-form-footer">
								<a class="close-option pull-right" data-id="'.$widgetID.'">Close</a>
								<button type="submit" class="btn btn-xs btn-primary update-widget" data-id="'.$widgetID.'"><i class="fa fa-check"></i>Save</button>
								<span id="progress-'.$widgetID.'" class="update-progress" style="display:none"><img src="'.$this->themeURL('admin').'assets/img/progress.gif"></span>
								<input type="hidden" name="blockName" value="'.$widgetID.'">
								<input type="hidden" name="position" value="'.@$positionID.'" id="position-'.$widgetID.'">
								<input type="hidden" name="updateWidget" value="1">
							</div>
						</form>
					</div>
				</div>
			</li>
		';
	}
	
	$avblWidget = '<ol class="dd-list small">'.$avblWidget.'</ol>';
	
	//Position
	$nWidget = 1;
	foreach($arrPosition as $positionID=>$positionVal){
	
		$chrvIcon 			 = $nWidget==1?'fa-chevron-up':'fa-chevron-down';
		$showWidgetBox 		 = $nWidget==1?'':' collapsed';
		$showWidgetBody		 = $nWidget==1?' collapse in':' collapse';
		$isHidden			 = $nWidget==1?'true':'false';
		@$widgetPosition 	.= '<div class="box">';
		$widgetPosition 	.= '<div class="box-header with-border">';
		$widgetPosition 	.= '<div class="widget-header"><h4 class="widget-title">'.$positionID.'</h4><div class="widget-toolbar"><a data-toggle="collapse" data-parent="#'.$positionID.'" href="#'.$positionID.'" aria-expanded="'.$isHidden.'" aria-controls="collapseOne" class="toggle-select'.$showWidgetBox.'"><i class="ace-icon fa fa-chevron-down"></i></a></div></div></div>';
		$widgetPosition 	.= '<div id="'.$positionID.'" class="box-body'.$showWidgetBody.'">';
		$widgetPosition 	.= '<div class="widget-main">';		
		
		if(count(@$pWidget[$positionID])>0){
		
			$widgetPosition .= '<div class="dd" id="widget-'.$positionID.'">';
			$widgetPosition .= '<ol class="dd-list">';
			$fieldTitle		 = '';
			
			if($this->site->isMultiLang()){
				
				foreach($this->site->lang() as $langID=>$langVal){
					
					$fieldTitle .= 'block_title_'.$langID.',';
				}
			}
		
			foreach($pWidget[$positionID] as $widgetID){
				
				$qwdb = "
	
					select 
						block_title,
						".$fieldTitle."
						block_page,
						block_title_show,
						block_params
					from 
						".$this->table_prefix."blocks 
					where 
						block_name		= '".$widgetID."' and 
						block_position	= '".$positionID."' and 
						block_theme		= '".$this->site->theme()."'
				";
				$wdb = $this->db->getRow($qwdb);
				
				$wTitle		= !empty($wdb['block_title'])?$wdb['block_title']:ucwords(str_replace('_',' ',$widgetID));
				$wActive	= $wdb['block_title_show']==1?' checked':'';
				
				$inputTitle = '
					
					<div class="control-group">
						<label for="title-'.$widgetID.'">Title</label>
						<input type="text" id="title-'.$widgetID.'" name="title" value="'.$wTitle.'" placeholder="Widget title" class="span-12">									
					</div>
					<hr>
				';
				
				if($this->site->isMultiLang()){
				
					$inputTitle = '';
					
					foreach($this->site->lang() as $langID=>$langVal){
						
						$wmTitle 	 = !empty($wdb['block_title_'.$langID])?$wdb['block_title_'.$langID]:ucwords(str_replace('_',' ',$widgetID));
						$inputTitle .= '
						
							<div class="control-group">
								<label for="title-'.$langID.'-'.$widgetID.'">Title '.$langVal.'</label>
								<input type="text" id="title-'.$langID.'-'.$widgetID.'" name="title_'.$langID.'" value="'.$wmTitle.'" placeholder="Widget title '.$langVal.'" class="span-12">								
							</div>
							<hr>
						';
					}
					$inputTitle .= '<input type="hidden" id="title-'.$widgetID.'" name="title" value="'.$wTitle.'">';
				}
				
				$sasText = '';
				if(preg_match('/text_/i',$widgetID)){
					
					$wParam  = base64_decode(html_entity_decode($wdb['block_params']));
					$sasText = '
					
						<div class="control-group">
							<label for="block-params-'.$widgetID.'">Enter script here</label>
							<textarea id="block-params-'.$widgetID.'" name="block_params" class="span-12" rows="6">'.$wParam.'</textarea>
						</div>
						<hr>
					';
				}
				
				$widgetPosition .= '
					
					<li class="dd-item" data-id="'.$widgetID.'">
						<div class="dd-handle" data-id="'.$widgetID.'">
							'.str_replace('_',' ',$widgetID).'
							<span class="btn-handle pull-right" style="display:block">
								<a class="btn-handle-edit dd-option" data-id="'.$widgetID.'"><i class="fa fa-wrench"></i></a>
							</span>
						</div>
						<div class="dd-tmeline" id="tmeline-'.$widgetID.'" style="display: none;">
							<div id="dd-info19" class="dd-info hide-chzn-search">
								<form id="form-'.$widgetID.'" name="form-'.$widgetID.'" method="post" action="">
									<div class="control-group">
										<label for="display-'.$widgetID.'">Display</label>
										'.widgetDisplay('display',@$wdb['block_page']).'									
									</div>
									<hr>
									'.$inputTitle.'
									<div class="control-group">
										<span>Show title</span>
										<input id="show-'.$widgetID.'" type="checkbox" value="1" class="ace-switch ace-switch-5" name="active"'.$wActive.'>							
										<span class="lbl"></span>										
									</div>
									<hr>
									'.@$sasText.'
									<div class="control-group sidget-form-footer">
										<a class="close-option pull-right" data-id="'.$widgetID.'">Close</a>
										<button type="submit" class="btn btn-xs btn-primary update-widget" data-id="'.$widgetID.'"><i class="fa fa-check"></i>Save</button>
										<span id="progress-'.$widgetID.'" class="update-progress" style="display:none"><img src="'.$this->themeURL('admin').'assets/img/progress.gif"></span>
										<input type="hidden" name="blockName" value="'.$widgetID.'">
										<input type="hidden" name="position" value="'.$positionID.'" id="position-'.$widgetID.'">
										<input type="hidden" name="updateWidget" value="1">
									</div>
								</form>
							</div>
						</div>
					</li>
				';
			}
			
			$widgetPosition 	.= '</ol></div>';
		}
		else{
			$widgetPosition .= '<div id="widget-'.$positionID.'" class="dd"><div class="dd-empty"></div></div>'; 
		}
		
		$widgetPosition 	.= '</div></div></div>';
		$widgetPosition 	.= '<div class="space"></div>';
		
		$nWidget++;
	}
	?>

	<div class="content-container">
		<div id="msg-alert"></div>
		<div class="row">
			<div class="col-md-8 col-lg-9">
			
				<div class="box">
				<div class="box-body">
				<div id="available-widget" class="dd">
					<?=$avblWidget?>
				</div>
				</div>
				</div>
				
			</div>
			<div class="col-md-4 col-lg-3">
				<?=$widgetPosition?>
			</div>
		</div>
		
	</div>
	
	<script>
	$(document).ready(function(){
		
		// Update page		
		var updateWidgetAvailable = function(e){
		
			$('.dd-tmeline').css('display','none');
		};
		var updateWidget = function(e){
		
			var list   	  	= $(e.target);
			var getPosition = list.data('position');
			var jasonData 	= window.JSON.stringify(list.nestable('serialize'));
			var xajaxFile 	= ajaxURL+"<?=modulePath?>config/admin/widget/widget.update.php";
			
			$.ajax({
				
				type: 'POST',
				url: xajaxFile,
				data: {widget:jasonData,position:getPosition},
				dataType: 'json',
				success: function(data){
					
					if(data.act=='updateAll'){
						$('#position-'+data.newWidget).val(data.position);
					}
				}
			});
		};
		
		// Available Widget
		$('#available-widget').nestable({
			group: 1,
			maxDepth: 1
		})
		.on('change', updateWidgetAvailable);
		
		// Widget Top
		$('#widget-top').nestable({
			group: 1,
			maxDepth: 1
		})
		.on('change', updateWidget).data('position', 'top');
		
		// Widget Left
		$('#widget-left').nestable({
			group: 1,
			maxDepth: 1
		})
		.on('change', updateWidget).data('position', 'left');
		
		// Widget Bottom
		$('#widget-bottom').nestable({
			group: 1,
			maxDepth: 1
		})
		.on('change', updateWidget).data('position', 'bottom');		
		
		// Widget Right
		$('#widget-right').nestable({
			group: 1,
			maxDepth: 1
		})
		.on('change', updateWidget).data('position', 'right');
		
		// Widget Middle
		$('#widget-content').nestable({
			group: 1,
			maxDepth: 1
		})
		.on('change', updateWidget).data('position', 'content');
		
		// Disable Item
		$(".dd span").on("mousedown", function(event) { // mousedown prevent nestable click
			event.preventDefault();
			return false;
		});
		$(".dd span, .dd > .dd-handle, .dd button").on("click", function(event) { // click prevent nestable click
			event.preventDefault();
			return false;
		});
		$(".dd-handle a").on("click", function(event) { // click event
			//window.location = $(this).attr("href");
			event.preventDefault();
			return false;
		});
		$(".dd input[type=text], .dd select").on("change", function(event) { // change event
			event.preventDefault();
			return false;
		});
		
		// Slide Option
		$(".dd-option").click(function(){
			
			var timelineID = $(this).data('id');
			
			$("#tmeline-"+timelineID).slideToggle("fast");
			return false;
		})
		$(".close-option").click(function(){
			
			var timelineID = $(this).data('id');
			
			$("#tmeline-"+timelineID).slideToggle("fast");
			return false;
		})
		
		// Update Widget
		$(".update-widget").click(function(){
		
			var xajaxFile 	= ajaxURL+"<?=modulePath?>config/admin/widget/widget.update.php";
			var formID		= $(this).data('id');
			
			$('#progress-'+formID).fadeIn();
			
			$.ajax({
				
				type: 'POST',
				url: xajaxFile,
				data: $('#form-'+formID).serialize(),
				dataType: 'json',
				success: function(data){
					
					$('#progress-'+formID).fadeOut();
				}
			});
		})
	});
	</script>
	
	<?
}
else{
	echo '
		<div class="alert alert-warning">						
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>
				<i class="icon-exclamation-sign"></i>
			</strong>
			No widget registered
			<br>
		</div>
	';
}
?>