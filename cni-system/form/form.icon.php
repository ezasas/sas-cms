<style>
.select-icon{
	height: 30px;
	position: relative;
}
.icons{
	border: 1px solid #ddd;
	padding: 3px;
	position: absolute;
	width: 364px;
	bottom: 35px;
	background: #fff;
	z-index: 100;
}
.icons a{
	background: #fafafa;
	border: 1px solid #eee;
	display: block;
	float: left;
	margin: 2px;
	padding: 1px 3px;
	text-align: center;
	width: 16px;
	text-decoration: none;
}
.icons a:hover{background:none;}
.icons i{
	margin: 0;
}
</style>



<?
#$icons = file(systemURL.'form/icons/icons.html');
$xicon = '

	<a href="javascript:void(0)" title="adjust"><i id="icon-adjust " class="icon-adjust " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="anchor"><i id="icon-anchor " class="icon-anchor " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="archive"><i id="icon-archive " class="icon-archive " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="asterisk"><i id="icon-asterisk " class="icon-asterisk " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bar chart"><i id="icon-bar-chart " class="icon-bar-chart " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="barcode"><i id="icon-barcode " class="icon-barcode " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="beaker"><i id="icon-beaker " class="icon-beaker " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="beer"><i id="icon-beer " class="icon-beer " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bell"><i id="icon-bell " class="icon-bell " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bell alt"><i id="icon-bell-alt " class="icon-bell-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bolt"><i id="icon-bolt " class="icon-bolt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="book"><i id="icon-book " class="icon-book " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bookmark"><i id="icon-bookmark " class="icon-bookmark " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bookmark empty"><i id="icon-bookmark-empty " class="icon-bookmark-empty " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="briefcase"><i id="icon-briefcase " class="icon-briefcase " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bug"><i id="icon-bug " class="icon-bug " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="building"><i id="icon-building " class="icon-building " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bullhorn"><i id="icon-bullhorn " class="icon-bullhorn " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="bullseye"><i id="icon-bullseye " class="icon-bullseye " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="calendar"><i id="icon-calendar " class="icon-calendar " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="calendar empty"><i id="icon-calendar-empty " class="icon-calendar-empty " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="camera"><i id="icon-camera " class="icon-camera " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="camera retro"><i id="icon-camera-retro " class="icon-camera-retro " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="certificate"><i id="icon-certificate " class="icon-certificate " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="circle"><i id="icon-circle " class="icon-circle " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="circle blank"><i id="icon-circle-blank " class="icon-circle-blank " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="cloud"><i id="icon-cloud " class="icon-cloud " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="cloud download"><i id="icon-cloud-download " class="icon-cloud-download " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="cloud upload"><i id="icon-cloud-upload " class="icon-cloud-upload " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="code"><i id="icon-code " class="icon-code " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="code fork"><i id="icon-code-fork " class="icon-code-fork " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="coffee"><i id="icon-coffee " class="icon-coffee " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="cog"><i id="icon-cog " class="icon-cog " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="cogs"><i id="icon-cogs " class="icon-cogs " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="comment"><i id="icon-comment " class="icon-comment " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="comment alt"><i id="icon-comment-alt " class="icon-comment-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="comments"><i id="icon-comments " class="icon-comments " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="comments alt"><i id="icon-comments-alt " class="icon-comments-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="compass"><i id="icon-compass " class="icon-compass " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="credit card"><i id="icon-credit-card " class="icon-credit-card " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="crop"><i id="icon-crop " class="icon-crop " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="dashboard"><i id="icon-dashboard " class="icon-dashboard " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="desktop"><i id="icon-desktop " class="icon-desktop " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="download alt"><i id="icon-download-alt " class="icon-download-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="edit"><i id="icon-edit " class="icon-edit " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="edit sign"><i id="icon-edit-sign " class="icon-edit-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="envelope"><i id="icon-envelope " class="icon-envelope " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="envelope alt"><i id="icon-envelope-alt " class="icon-envelope-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="eraser"><i id="icon-eraser " class="icon-eraser " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="exchange"><i id="icon-exchange " class="icon-exchange " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="exclamation"><i id="icon-exclamation " class="icon-exclamation " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="exclamation sign"><i id="icon-exclamation-sign " class="icon-exclamation-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="external link"><i id="icon-external-link " class="icon-external-link " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="external link sign"><i id="icon-external-link-sign " class="icon-external-link-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="eye close"><i id="icon-eye-close " class="icon-eye-close " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="eye open"><i id="icon-eye-open " class="icon-eye-open " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="facetime video"><i id="icon-facetime-video " class="icon-facetime-video " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="female"><i id="icon-female " class="icon-female " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="fighter jet"><i id="icon-fighter-jet " class="icon-fighter-jet " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="file"><i id="icon-file " class="icon-file " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="file text"><i id="icon-file-text " class="icon-file-text " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="film"><i id="icon-film " class="icon-film " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="filter"><i id="icon-filter " class="icon-filter " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="fire"><i id="icon-fire " class="icon-fire " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="fire extinguisher"><i id="icon-fire-extinguisher " class="icon-fire-extinguisher " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="flag"><i id="icon-flag " class="icon-flag " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="flag alt"><i id="icon-flag-alt " class="icon-flag-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="flag checkered"><i id="icon-flag-checkered " class="icon-flag-checkered " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="folder close"><i id="icon-folder-close " class="icon-folder-close " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="folder open"><i id="icon-folder-open " class="icon-folder-open " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="folder open alt"><i id="icon-folder-open-alt " class="icon-folder-open-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="food"><i id="icon-food " class="icon-food " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="gamepad"><i id="icon-gamepad " class="icon-gamepad " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="gear (alias)"><i id="icon-gear (alias) " class="icon-gear (alias) " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="gears (alias)"><i id="icon-gears (alias) " class="icon-gears (alias) " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="gift"><i id="icon-gift " class="icon-gift " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="glass"><i id="icon-glass " class="icon-glass " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="globe"><i id="icon-globe " class="icon-globe " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="group"><i id="icon-group " class="icon-group " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="hdd"><i id="icon-hdd " class="icon-hdd " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="headphones"><i id="icon-headphones " class="icon-headphones " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="heart"><i id="icon-heart " class="icon-heart " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="home"><i id="icon-home " class="icon-home " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="inbox"><i id="icon-inbox " class="icon-inbox " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="info"><i id="icon-info " class="icon-info " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="info sign"><i id="icon-info-sign " class="icon-info-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="key"><i id="icon-key " class="icon-key " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="keyboard"><i id="icon-keyboard " class="icon-keyboard " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="laptop"><i id="icon-laptop " class="icon-laptop " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="leaf"><i id="icon-leaf " class="icon-leaf " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="legal"><i id="icon-legal " class="icon-legal " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="lightbulb"><i id="icon-lightbulb " class="icon-lightbulb " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="lock"><i id="icon-lock " class="icon-lock " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="magic"><i id="icon-magic " class="icon-magic " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="magnet"><i id="icon-magnet " class="icon-magnet " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="male"><i id="icon-male " class="icon-male " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="map marker"><i id="icon-map-marker " class="icon-map-marker " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="microphone"><i id="icon-microphone " class="icon-microphone " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="microphone off"><i id="icon-microphone-off " class="icon-microphone-off " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="minus"><i id="icon-minus " class="icon-minus " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="minus sign"><i id="icon-minus-sign " class="icon-minus-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="minus sign alt"><i id="icon-minus-sign-alt " class="icon-minus-sign-alt " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="mobile phone"><i id="icon-mobile-phone " class="icon-mobile-phone " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="money"><i id="icon-money " class="icon-money " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="move"><i id="icon-move " class="icon-move " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="music"><i id="icon-music " class="icon-music " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="pencil"><i id="icon-pencil " class="icon-pencil " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="phone"><i id="icon-phone " class="icon-phone " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="phone sign"><i id="icon-phone-sign " class="icon-phone-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="picture"><i id="icon-picture " class="icon-picture " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="plane"><i id="icon-plane " class="icon-plane " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="power off (alias)"><i id="icon-power-off (alias) " class="icon-power-off (alias) " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="print"><i id="icon-print " class="icon-print " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="pushpin"><i id="icon-pushpin " class="icon-pushpin " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="puzzle piece"><i id="icon-puzzle-piece " class="icon-puzzle-piece " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="qrcode"><i id="icon-qrcode " class="icon-qrcode " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="question"><i id="icon-question " class="icon-question " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="question sign"><i id="icon-question-sign " class="icon-question-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="quote left"><i id="icon-quote-left " class="icon-quote-left " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="quote right"><i id="icon-quote-right " class="icon-quote-right " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="random"><i id="icon-random " class="icon-random " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="reorder"><i id="icon-reorder " class="icon-reorder " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="retweet"><i id="icon-retweet " class="icon-retweet " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="road"><i id="icon-road " class="icon-road " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="rocket"><i id="icon-rocket " class="icon-rocket " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="rss"><i id="icon-rss " class="icon-rss " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="rss sign"><i id="icon-rss-sign " class="icon-rss-sign " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="shield"><i id="icon-shield " class="icon-shield " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="shopping cart"><i id="icon-shopping-cart " class="icon-shopping-cart " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="signal"><i id="icon-signal " class="icon-signal " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="sitemap"><i id="icon-sitemap " class="icon-sitemap " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="suitcase"><i id="icon-suitcase " class="icon-suitcase " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="sun"><i id="icon-sun " class="icon-sun " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="tablet"><i id="icon-tablet " class="icon-tablet " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="tag"><i id="icon-tag " class="icon-tag " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="tags"><i id="icon-tags " class="icon-tags " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="ticket"><i id="icon-ticket " class="icon-ticket " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="time"><i id="icon-time " class="icon-time " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="tint"><i id="icon-tint " class="icon-tint " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="trophy"><i id="icon-trophy " class="icon-trophy " onclick="selecticon(this.id)"></i></a>	
<a href="javascript:void(0)" title="cloud upload"><i id="icon-cloud-upload " class="icon-cloud-upload " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="user"><i id="icon-user " class="icon-user " onclick="selecticon(this.id)"></i></a>
	<a href="javascript:void(0)" title="wrench"><i id="icon-wrench " class="icon-wrench " onclick="selecticon(this.id)"></i></a>
';

$iconValue = !empty($value)?$value:'icon-folder-close';

$xicon .= '<br class="clearfix">';
$form  .= '

<div class="control-group">
	<div class="select-icon">
		<span id="icon" class="'.$iconValue.'" title="Pictures"></span>
		<span class="btn-select">Select Icon</span>
		<input type="hidden" id="input-icon" name="'.$input['name'].'" value="'.$iconValue.'" />
		<div class="icons" style="display:none;">'.$xicon.'</div>
	</div>
</div>
';
?>	





<script>

	jQuery(document).ready(function($) {
		
		$('#icon').click(function(){
			
			$(".icons").slideToggle('fast');
		});
		
		$('.btn-select').click(function(){
			
			$(".icons").slideToggle('fast');
		});
		
		$('#.icons').slimScroll({height: '167px'});
	});
	
	function selecticon(icon){
		
		var thisIcon = $('#icon').attr('class');
		var newIcon  = icon;
		
		$("#input-icon").val(newIcon);
		$('#icon').removeClass(thisIcon);
		$('#icon').addClass(newIcon);
		$(".icons").slideToggle('fast');
	}
	
</script>