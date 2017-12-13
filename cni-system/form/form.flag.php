<?php
$ativeIcon = empty($_POST['icon'])?'flag-afghanistan':$_POST['icon'];
?>
<style>

#lang-icons{
	height: 30px;
	position: relative;
}
.flags-container{
	border: 1px solid #DDDDDD;
	padding: 3px 6px 5px 3px;
	position: absolute;
	left: 0;
	
	background: none repeat scroll 0 0 #FFFFFF;
	z-index: 100;
}	
.flags-items{
	height: 153px;
	overflow: auto;
	width: 408px;
}	

.flags-container [class^="flag-"],
.flags-container [class*=" flag-"]{
	display: block;
	float: left;
	margin: 2px;
	cursor: pointer;
	position: relative;
}
.flags-container [class^="flag-"]:after,
.flags-container [class*=" flag-"]:after{
	content: "";
	position: absolute;
	height: 18px;
	width: 24px;
	background: rgba(0,0,0,0.1);
}
.flags-container [class^="flag-"]:hover:after,
.flags-container [class*=" flag-"]:hover:after{
	background: none;
}
.clear{clear:both;height:0;opacity:0;}	
</style>

<div id="lang-icons">
	<span id="flagicon" class="<?=$ativeIcon;?>"></span>
	<span class="btn-select">Select Icon</span>
	<div id="flags-container" class="flags-container">
		<div id="flags-items" class="flags-items">
			<?php include_once(systemPath.'form/icons/flag.html'); ?>
			<br class="clear">
		</div>
	</div>
</div>
<input type="hidden" id="input-icon" name="icon" value="<?=$ativeIcon;?>"/>

<script>

	jQuery(document).ready(function($) {
		
		var offset_top     = $("#lang-icons").offset().top;
		var containerHeight	= $("#flags-container").height();
		
		if(offset_top>containerHeight){
			$("#flags-container").css("bottom",35);
		}
		else{
			$("#flags-container").css("top",23);
		}
		
		//$('#flags-items').jScrollPane();
		$('#flags-items').slimScroll({height: '153px'});
		$('#flags-container').css("display","none");
		
		$('#flagicon').click(function(){
			
			$("#flags-container").slideToggle('fast');
		});
		
		$('.btn-select').click(function(){
			
			$("#flags-container").slideToggle('fast');
		});
	});
	
	function selectlang(flagId){
		
		var thisIcon = $('#flagicon').attr('class');
		var newIcon  = flagId;
		
		$("#input-icon").val(newIcon);
		$('#flagicon').removeClass(thisIcon);
		$('#flagicon').addClass(newIcon);
		$("#flags-container").slideToggle('fast');
	}
	
</script>