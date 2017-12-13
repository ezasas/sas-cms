<span title="Pictures" class="fa fa-caret-right" id="iconpage"></span>
<span class="btn-select btn-selectpage" data-toggle="modal" data-target="#myModal">Select Icon</span>

<input type="hidden" value="fa fa-caret-right" name="add_icon" id="input-iconpage">

<script type="text/javascript">

	jQuery(function($) {
		
		$('.fa-icon').click(function(){
			
			var icon = $(this).data('icon');
			$('#iconpage').removeAttr('class');
			$('#iconpage').addClass('fa '+icon);
			$('#input-iconpage').val('fa '+icon);
			$('#myModal').modal('hide');
		});
		
	});
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Select icon</h4>
			</div>
			<div class="modal-body">
				<div class="fa-icon-container">
					<span class="fa-icon" data-icon="fa-adjust" data-toggle="tooltip" data-placement="top" title="fa adjust"><i class="fa fa-adjust"></i></span>
					<span class="fa-icon" data-icon="fa-anchor" data-toggle="tooltip" data-placement="top" title="fa anchor"><i class="fa fa-anchor"></i></span>
					<span class="fa-icon" data-icon="fa-archive" data-toggle="tooltip" data-placement="top" title="fa archive"><i class="fa fa-archive"></i></span>
					<span class="fa-icon" data-icon="fa-area-chart" data-toggle="tooltip" data-placement="top" title="fa area chart"><i class="fa fa-area-chart"></i></span>
					<span class="fa-icon" data-icon="fa-arrows" data-toggle="tooltip" data-placement="top" title="fa arrows"><i class="fa fa-arrows"></i></span>
					<span class="fa-icon" data-icon="fa-arrows-h" data-toggle="tooltip" data-placement="top" title="fa arrows h"><i class="fa fa-arrows-h"></i></span>
					<span class="fa-icon" data-icon="fa-arrows-v" data-toggle="tooltip" data-placement="top" title="fa arrows v"><i class="fa fa-arrows-v"></i></span>
					<span class="fa-icon" data-icon="fa-asterisk" data-toggle="tooltip" data-placement="top" title="fa asterisk"><i class="fa fa-asterisk"></i></span>
					<span class="fa-icon" data-icon="fa-at" data-toggle="tooltip" data-placement="top" title="fa at"><i class="fa fa-at"></i></span>
					<span class="fa-icon" data-icon="fa-automobile" data-toggle="tooltip" data-placement="top" title="fa automobile"><i class="fa fa-automobile"></i></span>
					<span class="fa-icon" data-icon="fa-ban" data-toggle="tooltip" data-placement="top" title="fa ban"><i class="fa fa-ban"></i></span>
					<span class="fa-icon" data-icon="fa-bank" data-toggle="tooltip" data-placement="top" title="fa bank"><i class="fa fa-bank"></i></span>
					<span class="fa-icon" data-icon="fa-bar-chart" data-toggle="tooltip" data-placement="top" title="fa bar chart"><i class="fa fa-bar-chart"></i></span>
					<span class="fa-icon" data-icon="fa-bar-chart-o" data-toggle="tooltip" data-placement="top" title="fa bar chart o"><i class="fa fa-bar-chart-o"></i></span>
					<span class="fa-icon" data-icon="fa-barcode" data-toggle="tooltip" data-placement="top" title="fa barcode"><i class="fa fa-barcode"></i></span>
					<span class="fa-icon" data-icon="fa-bars" data-toggle="tooltip" data-placement="top" title="fa bars"><i class="fa fa-bars"></i></span>
					<span class="fa-icon" data-icon="fa-beer" data-toggle="tooltip" data-placement="top" title="fa beer"><i class="fa fa-beer"></i></span>
					<span class="fa-icon" data-icon="fa-bell" data-toggle="tooltip" data-placement="top" title="fa bell"><i class="fa fa-bell"></i></span>
					<span class="fa-icon" data-icon="fa-bell-o" data-toggle="tooltip" data-placement="top" title="fa bell o"><i class="fa fa-bell-o"></i></span>
					<span class="fa-icon" data-icon="fa-bell-slash" data-toggle="tooltip" data-placement="top" title="fa bell slash"><i class="fa fa-bell-slash"></i></span>
					<span class="fa-icon" data-icon="fa-bell-slash-o" data-toggle="tooltip" data-placement="top" title="fa bell slash o"><i class="fa fa-bell-slash-o"></i></span>
					<span class="fa-icon" data-icon="fa-bicycle" data-toggle="tooltip" data-placement="top" title="fa bicycle"><i class="fa fa-bicycle"></i></span>
					<span class="fa-icon" data-icon="fa-binoculars" data-toggle="tooltip" data-placement="top" title="fa binoculars"><i class="fa fa-binoculars"></i></span>
					<span class="fa-icon" data-icon="fa-birthday-cake" data-toggle="tooltip" data-placement="top" title="fa birthday cake"><i class="fa fa-birthday-cake"></i></span>
					<span class="fa-icon" data-icon="fa-bolt" data-toggle="tooltip" data-placement="top" title="fa bolt"><i class="fa fa-bolt"></i></span>
					<span class="fa-icon" data-icon="fa-bomb" data-toggle="tooltip" data-placement="top" title="fa bomb"><i class="fa fa-bomb"></i></span>
					<span class="fa-icon" data-icon="fa-book" data-toggle="tooltip" data-placement="top" title="fa book"><i class="fa fa-book"></i></span>
					<span class="fa-icon" data-icon="fa-bookmark" data-toggle="tooltip" data-placement="top" title="fa bookmark"><i class="fa fa-bookmark"></i></span>
					<span class="fa-icon" data-icon="fa-bookmark-o" data-toggle="tooltip" data-placement="top" title="fa bookmark o"><i class="fa fa-bookmark-o"></i></span>
					<span class="fa-icon" data-icon="fa-briefcase" data-toggle="tooltip" data-placement="top" title="fa briefcase"><i class="fa fa-briefcase"></i></span>
					<span class="fa-icon" data-icon="fa-bug" data-toggle="tooltip" data-placement="top" title="fa bug"><i class="fa fa-bug"></i></span>
					<span class="fa-icon" data-icon="fa-building" data-toggle="tooltip" data-placement="top" title="fa building"><i class="fa fa-building"></i></span>
					<span class="fa-icon" data-icon="fa-building-o" data-toggle="tooltip" data-placement="top" title="fa building o"><i class="fa fa-building-o"></i></span>
					<span class="fa-icon" data-icon="fa-bullhorn" data-toggle="tooltip" data-placement="top" title="fa bullhorn"><i class="fa fa-bullhorn"></i></span>
					<span class="fa-icon" data-icon="fa-bullseye" data-toggle="tooltip" data-placement="top" title="fa bullseye"><i class="fa fa-bullseye"></i></span>
					<span class="fa-icon" data-icon="fa-bus" data-toggle="tooltip" data-placement="top" title="fa bus"><i class="fa fa-bus"></i></span>
					<span class="fa-icon" data-icon="fa-cab" data-toggle="tooltip" data-placement="top" title="fa cab"><i class="fa fa-cab"></i></span>
					<span class="fa-icon" data-icon="fa-calculator" data-toggle="tooltip" data-placement="top" title="fa calculator"><i class="fa fa-calculator"></i></span>
					<span class="fa-icon" data-icon="fa-calendar" data-toggle="tooltip" data-placement="top" title="fa calendar"><i class="fa fa-calendar"></i></span>
					<span class="fa-icon" data-icon="fa-calendar-o" data-toggle="tooltip" data-placement="top" title="fa calendar o"><i class="fa fa-calendar-o"></i></span>
					<span class="fa-icon" data-icon="fa-camera" data-toggle="tooltip" data-placement="top" title="fa camera"><i class="fa fa-camera"></i></span>
					<span class="fa-icon" data-icon="fa-camera-retro" data-toggle="tooltip" data-placement="top" title="fa camera retro"><i class="fa fa-camera-retro"></i></span>
					<span class="fa-icon" data-icon="fa-car" data-toggle="tooltip" data-placement="top" title="fa car"><i class="fa fa-car"></i></span>
					<span class="fa-icon" data-icon="fa-caret-square-o-down" data-toggle="tooltip" data-placement="top" title="fa caret square o down"><i class="fa fa-caret-square-o-down"></i></span>
					<span class="fa-icon" data-icon="fa-caret-square-o-left" data-toggle="tooltip" data-placement="top" title="fa caret square o left"><i class="fa fa-caret-square-o-left"></i></span>
					<span class="fa-icon" data-icon="fa-caret-square-o-right" data-toggle="tooltip" data-placement="top" title="fa caret square o right"><i class="fa fa-caret-square-o-right"></i></span>
					<span class="fa-icon" data-icon="fa-caret-square-o-up" data-toggle="tooltip" data-placement="top" title="fa caret square o up"><i class="fa fa-caret-square-o-up"></i></span>
					<span class="fa-icon" data-icon="fa-cc" data-toggle="tooltip" data-placement="top" title="fa cc"><i class="fa fa-cc"></i></span>
					<span class="fa-icon" data-icon="fa-certificate" data-toggle="tooltip" data-placement="top" title="fa certificate"><i class="fa fa-certificate"></i></span>
					<span class="fa-icon" data-icon="fa-check" data-toggle="tooltip" data-placement="top" title="fa check"><i class="fa fa-check"></i></span>
					<span class="fa-icon" data-icon="fa-check-circle" data-toggle="tooltip" data-placement="top" title="fa check circle"><i class="fa fa-check-circle"></i></span>
					<span class="fa-icon" data-icon="fa-check-circle-o" data-toggle="tooltip" data-placement="top" title="fa check circle o"><i class="fa fa-check-circle-o"></i></span>
					<span class="fa-icon" data-icon="fa-check-square" data-toggle="tooltip" data-placement="top" title="fa check square"><i class="fa fa-check-square"></i></span>
					<span class="fa-icon" data-icon="fa-check-square-o" data-toggle="tooltip" data-placement="top" title="fa check square o"><i class="fa fa-check-square-o"></i></span>
					<span class="fa-icon" data-icon="fa-child" data-toggle="tooltip" data-placement="top" title="fa child"><i class="fa fa-child"></i></span>
					<span class="fa-icon" data-icon="fa-circle" data-toggle="tooltip" data-placement="top" title="fa circle"><i class="fa fa-circle"></i></span>
					<span class="fa-icon" data-icon="fa-circle-o" data-toggle="tooltip" data-placement="top" title="fa circle o"><i class="fa fa-circle-o"></i></span>
					<span class="fa-icon" data-icon="fa-circle-o-notch" data-toggle="tooltip" data-placement="top" title="fa circle o notch"><i class="fa fa-circle-o-notch"></i></span>
					<span class="fa-icon" data-icon="fa-circle-thin" data-toggle="tooltip" data-placement="top" title="fa circle thin"><i class="fa fa-circle-thin"></i></span>
					<span class="fa-icon" data-icon="fa-clock-o" data-toggle="tooltip" data-placement="top" title="fa clock o"><i class="fa fa-clock-o"></i></span>
					<span class="fa-icon" data-icon="fa-close" data-toggle="tooltip" data-placement="top" title="fa close"><i class="fa fa-close"></i></span>
					<span class="fa-icon" data-icon="fa-cloud" data-toggle="tooltip" data-placement="top" title="fa cloud"><i class="fa fa-cloud"></i></span>
					<span class="fa-icon" data-icon="fa-cloud-download" data-toggle="tooltip" data-placement="top" title="fa cloud download"><i class="fa fa-cloud-download"></i></span>
					<span class="fa-icon" data-icon="fa-cloud-upload" data-toggle="tooltip" data-placement="top" title="fa cloud upload"><i class="fa fa-cloud-upload"></i></span>
					<span class="fa-icon" data-icon="fa-code" data-toggle="tooltip" data-placement="top" title="fa code"><i class="fa fa-code"></i></span>
					<span class="fa-icon" data-icon="fa-code-fork" data-toggle="tooltip" data-placement="top" title="fa code fork"><i class="fa fa-code-fork"></i></span>
					<span class="fa-icon" data-icon="fa-coffee" data-toggle="tooltip" data-placement="top" title="fa coffee"><i class="fa fa-coffee"></i></span>
					<span class="fa-icon" data-icon="fa-cog" data-toggle="tooltip" data-placement="top" title="fa cog"><i class="fa fa-cog"></i></span>
					<span class="fa-icon" data-icon="fa-cogs" data-toggle="tooltip" data-placement="top" title="fa cogs"><i class="fa fa-cogs"></i></span>
					<span class="fa-icon" data-icon="fa-comment" data-toggle="tooltip" data-placement="top" title="fa comment"><i class="fa fa-comment"></i></span>
					<span class="fa-icon" data-icon="fa-comment-o" data-toggle="tooltip" data-placement="top" title="fa comment o"><i class="fa fa-comment-o"></i></span>
					<span class="fa-icon" data-icon="fa-comments" data-toggle="tooltip" data-placement="top" title="fa comments"><i class="fa fa-comments"></i></span>
					<span class="fa-icon" data-icon="fa-comments-o" data-toggle="tooltip" data-placement="top" title="fa comments o"><i class="fa fa-comments-o"></i></span>
					<span class="fa-icon" data-icon="fa-compass" data-toggle="tooltip" data-placement="top" title="fa compass"><i class="fa fa-compass"></i></span>
					<span class="fa-icon" data-icon="fa-copyright" data-toggle="tooltip" data-placement="top" title="fa copyright"><i class="fa fa-copyright"></i></span>
					<span class="fa-icon" data-icon="fa-credit-card" data-toggle="tooltip" data-placement="top" title="fa credit card"><i class="fa fa-credit-card"></i></span>
					<span class="fa-icon" data-icon="fa-crop" data-toggle="tooltip" data-placement="top" title="fa crop"><i class="fa fa-crop"></i></span>
					<span class="fa-icon" data-icon="fa-crosshairs" data-toggle="tooltip" data-placement="top" title="fa crosshairs"><i class="fa fa-crosshairs"></i></span>
					<span class="fa-icon" data-icon="fa-cube" data-toggle="tooltip" data-placement="top" title="fa cube"><i class="fa fa-cube"></i></span>
					<span class="fa-icon" data-icon="fa-cubes" data-toggle="tooltip" data-placement="top" title="fa cubes"><i class="fa fa-cubes"></i></span>
					<span class="fa-icon" data-icon="fa-cutlery" data-toggle="tooltip" data-placement="top" title="fa cutlery"><i class="fa fa-cutlery"></i></span>
					<span class="fa-icon" data-icon="fa-dashboard" data-toggle="tooltip" data-placement="top" title="fa dashboard"><i class="fa fa-dashboard"></i></span>
					<span class="fa-icon" data-icon="fa-database" data-toggle="tooltip" data-placement="top" title="fa database"><i class="fa fa-database"></i></span>
					<span class="fa-icon" data-icon="fa-desktop" data-toggle="tooltip" data-placement="top" title="fa desktop"><i class="fa fa-desktop"></i></span>
					<span class="fa-icon" data-icon="fa-dot-circle-o" data-toggle="tooltip" data-placement="top" title="fa dot circle o"><i class="fa fa-dot-circle-o"></i></span>
					<span class="fa-icon" data-icon="fa-download" data-toggle="tooltip" data-placement="top" title="fa download"><i class="fa fa-download"></i></span>
					<span class="fa-icon" data-icon="fa-edit" data-toggle="tooltip" data-placement="top" title="fa edit"><i class="fa fa-edit"></i></span>
					<span class="fa-icon" data-icon="fa-ellipsis-h" data-toggle="tooltip" data-placement="top" title="fa ellipsis h"><i class="fa fa-ellipsis-h"></i></span>
					<span class="fa-icon" data-icon="fa-ellipsis-v" data-toggle="tooltip" data-placement="top" title="fa ellipsis v"><i class="fa fa-ellipsis-v"></i></span>
					<span class="fa-icon" data-icon="fa-envelope" data-toggle="tooltip" data-placement="top" title="fa envelope"><i class="fa fa-envelope"></i></span>
					<span class="fa-icon" data-icon="fa-envelope-o" data-toggle="tooltip" data-placement="top" title="fa envelope o"><i class="fa fa-envelope-o"></i></span>
					<span class="fa-icon" data-icon="fa-envelope-square" data-toggle="tooltip" data-placement="top" title="fa envelope square"><i class="fa fa-envelope-square"></i></span>
					<span class="fa-icon" data-icon="fa-eraser" data-toggle="tooltip" data-placement="top" title="fa eraser"><i class="fa fa-eraser"></i></span>
					<span class="fa-icon" data-icon="fa-exchange" data-toggle="tooltip" data-placement="top" title="fa exchange"><i class="fa fa-exchange"></i></span>
					<span class="fa-icon" data-icon="fa-exclamation" data-toggle="tooltip" data-placement="top" title="fa exclamation"><i class="fa fa-exclamation"></i></span>
					<span class="fa-icon" data-icon="fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="fa exclamation circle"><i class="fa fa-exclamation-circle"></i></span>
					<span class="fa-icon" data-icon="fa-exclamation-triangle" data-toggle="tooltip" data-placement="top" title="fa exclamation triangle"><i class="fa fa-exclamation-triangle"></i></span>
					<span class="fa-icon" data-icon="fa-external-link" data-toggle="tooltip" data-placement="top" title="fa external link"><i class="fa fa-external-link"></i></span>
					<span class="fa-icon" data-icon="fa-external-link-square" data-toggle="tooltip" data-placement="top" title="fa external link square"><i class="fa fa-external-link-square"></i></span>
					<span class="fa-icon" data-icon="fa-eye" data-toggle="tooltip" data-placement="top" title="fa eye"><i class="fa fa-eye"></i></span>
					<span class="fa-icon" data-icon="fa-eye-slash" data-toggle="tooltip" data-placement="top" title="fa eye slash"><i class="fa fa-eye-slash"></i></span>
					<span class="fa-icon" data-icon="fa-eyedropper" data-toggle="tooltip" data-placement="top" title="fa eyedropper"><i class="fa fa-eyedropper"></i></span>
					<span class="fa-icon" data-icon="fa-fax" data-toggle="tooltip" data-placement="top" title="fa fax"><i class="fa fa-fax"></i></span>
					<span class="fa-icon" data-icon="fa-female" data-toggle="tooltip" data-placement="top" title="fa female"><i class="fa fa-female"></i></span>
					<span class="fa-icon" data-icon="fa-fighter-jet" data-toggle="tooltip" data-placement="top" title="fa fighter jet"><i class="fa fa-fighter-jet"></i></span>
					<span class="fa-icon" data-icon="fa-file-archive-o" data-toggle="tooltip" data-placement="top" title="fa file archive o"><i class="fa fa-file-archive-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-audio-o" data-toggle="tooltip" data-placement="top" title="fa file audio o"><i class="fa fa-file-audio-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-code-o" data-toggle="tooltip" data-placement="top" title="fa file code o"><i class="fa fa-file-code-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-excel-o" data-toggle="tooltip" data-placement="top" title="fa file excel o"><i class="fa fa-file-excel-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-image-o" data-toggle="tooltip" data-placement="top" title="fa file image o"><i class="fa fa-file-image-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-movie-o" data-toggle="tooltip" data-placement="top" title="fa file movie o"><i class="fa fa-file-movie-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="fa file pdf o"><i class="fa fa-file-pdf-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-photo-o" data-toggle="tooltip" data-placement="top" title="fa file photo o"><i class="fa fa-file-photo-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-picture-o" data-toggle="tooltip" data-placement="top" title="fa file picture o"><i class="fa fa-file-picture-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-powerpoint-o" data-toggle="tooltip" data-placement="top" title="fa file powerpoint o"><i class="fa fa-file-powerpoint-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-sound-o" data-toggle="tooltip" data-placement="top" title="fa file sound o"><i class="fa fa-file-sound-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-video-o" data-toggle="tooltip" data-placement="top" title="fa file video o"><i class="fa fa-file-video-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-word-o" data-toggle="tooltip" data-placement="top" title="fa file word o"><i class="fa fa-file-word-o"></i></span>
					<span class="fa-icon" data-icon="fa-file-zip-o" data-toggle="tooltip" data-placement="top" title="fa file zip o"><i class="fa fa-file-zip-o"></i></span>
					<span class="fa-icon" data-icon="fa-film" data-toggle="tooltip" data-placement="top" title="fa film"><i class="fa fa-film"></i></span>
					<span class="fa-icon" data-icon="fa-filter" data-toggle="tooltip" data-placement="top" title="fa filter"><i class="fa fa-filter"></i></span>
					<span class="fa-icon" data-icon="fa-fire" data-toggle="tooltip" data-placement="top" title="fa fire"><i class="fa fa-fire"></i></span>
					<span class="fa-icon" data-icon="fa-fire-extinguisher" data-toggle="tooltip" data-placement="top" title="fa fire extinguisher"><i class="fa fa-fire-extinguisher"></i></span>
					<span class="fa-icon" data-icon="fa-flag" data-toggle="tooltip" data-placement="top" title="fa flag"><i class="fa fa-flag"></i></span>
					<span class="fa-icon" data-icon="fa-flag-checkered" data-toggle="tooltip" data-placement="top" title="fa flag checkered"><i class="fa fa-flag-checkered"></i></span>
					<span class="fa-icon" data-icon="fa-flag-o" data-toggle="tooltip" data-placement="top" title="fa flag o"><i class="fa fa-flag-o"></i></span>
					<span class="fa-icon" data-icon="fa-flash" data-toggle="tooltip" data-placement="top" title="fa flash"><i class="fa fa-flash"></i></span>
					<span class="fa-icon" data-icon="fa-flask" data-toggle="tooltip" data-placement="top" title="fa flask"><i class="fa fa-flask"></i></span>
					<span class="fa-icon" data-icon="fa-folder" data-toggle="tooltip" data-placement="top" title="fa folder"><i class="fa fa-folder"></i></span>
					<span class="fa-icon" data-icon="fa-folder-o" data-toggle="tooltip" data-placement="top" title="fa folder o"><i class="fa fa-folder-o"></i></span>
					<span class="fa-icon" data-icon="fa-folder-open" data-toggle="tooltip" data-placement="top" title="fa folder open"><i class="fa fa-folder-open"></i></span>
					<span class="fa-icon" data-icon="fa-folder-open-o" data-toggle="tooltip" data-placement="top" title="fa folder open o"><i class="fa fa-folder-open-o"></i></span>
					<span class="fa-icon" data-icon="fa-frown-o" data-toggle="tooltip" data-placement="top" title="fa frown o"><i class="fa fa-frown-o"></i></span>
					<span class="fa-icon" data-icon="fa-futbol-o" data-toggle="tooltip" data-placement="top" title="fa futbol o"><i class="fa fa-futbol-o"></i></span>
					<span class="fa-icon" data-icon="fa-gamepad" data-toggle="tooltip" data-placement="top" title="fa gamepad"><i class="fa fa-gamepad"></i></span>
					<span class="fa-icon" data-icon="fa-gavel" data-toggle="tooltip" data-placement="top" title="fa gavel"><i class="fa fa-gavel"></i></span>
					<span class="fa-icon" data-icon="fa-gear" data-toggle="tooltip" data-placement="top" title="fa gear"><i class="fa fa-gear"></i></span>
					<span class="fa-icon" data-icon="fa-gears" data-toggle="tooltip" data-placement="top" title="fa gears"><i class="fa fa-gears"></i></span>
					<span class="fa-icon" data-icon="fa-gift" data-toggle="tooltip" data-placement="top" title="fa gift"><i class="fa fa-gift"></i></span>
					<span class="fa-icon" data-icon="fa-glass" data-toggle="tooltip" data-placement="top" title="fa glass"><i class="fa fa-glass"></i></span>
					<span class="fa-icon" data-icon="fa-globe" data-toggle="tooltip" data-placement="top" title="fa globe"><i class="fa fa-globe"></i></span>
					<span class="fa-icon" data-icon="fa-graduation-cap" data-toggle="tooltip" data-placement="top" title="fa graduation cap"><i class="fa fa-graduation-cap"></i></span>
					<span class="fa-icon" data-icon="fa-group" data-toggle="tooltip" data-placement="top" title="fa group"><i class="fa fa-group"></i></span>
					<span class="fa-icon" data-icon="fa-hdd-o" data-toggle="tooltip" data-placement="top" title="fa hdd o"><i class="fa fa-hdd-o"></i></span>
					<span class="fa-icon" data-icon="fa-headphones" data-toggle="tooltip" data-placement="top" title="fa headphones"><i class="fa fa-headphones"></i></span>
					<span class="fa-icon" data-icon="fa-heart" data-toggle="tooltip" data-placement="top" title="fa heart"><i class="fa fa-heart"></i></span>
					<span class="fa-icon" data-icon="fa-heart-o" data-toggle="tooltip" data-placement="top" title="fa heart o"><i class="fa fa-heart-o"></i></span>
					<span class="fa-icon" data-icon="fa-history" data-toggle="tooltip" data-placement="top" title="fa history"><i class="fa fa-history"></i></span>
					<span class="fa-icon" data-icon="fa-home" data-toggle="tooltip" data-placement="top" title="fa home"><i class="fa fa-home"></i></span>
					<span class="fa-icon" data-icon="fa-image" data-toggle="tooltip" data-placement="top" title="fa image"><i class="fa fa-image"></i></span>
					<span class="fa-icon" data-icon="fa-inbox" data-toggle="tooltip" data-placement="top" title="fa inbox"><i class="fa fa-inbox"></i></span>
					<span class="fa-icon" data-icon="fa-info" data-toggle="tooltip" data-placement="top" title="fa info"><i class="fa fa-info"></i></span>
					<span class="fa-icon" data-icon="fa-info-circle" data-toggle="tooltip" data-placement="top" title="fa info circle"><i class="fa fa-info-circle"></i></span>
					<span class="fa-icon" data-icon="fa-institution" data-toggle="tooltip" data-placement="top" title="fa institution"><i class="fa fa-institution"></i></span>
					<span class="fa-icon" data-icon="fa-key" data-toggle="tooltip" data-placement="top" title="fa key"><i class="fa fa-key"></i></span>
					<span class="fa-icon" data-icon="fa-keyboard-o" data-toggle="tooltip" data-placement="top" title="fa keyboard o"><i class="fa fa-keyboard-o"></i></span>
					<span class="fa-icon" data-icon="fa-language" data-toggle="tooltip" data-placement="top" title="fa language"><i class="fa fa-language"></i></span>
					<span class="fa-icon" data-icon="fa-laptop" data-toggle="tooltip" data-placement="top" title="fa laptop"><i class="fa fa-laptop"></i></span>
					<span class="fa-icon" data-icon="fa-leaf" data-toggle="tooltip" data-placement="top" title="fa leaf"><i class="fa fa-leaf"></i></span>
					<span class="fa-icon" data-icon="fa-legal" data-toggle="tooltip" data-placement="top" title="fa legal"><i class="fa fa-legal"></i></span>
					<span class="fa-icon" data-icon="fa-lemon-o" data-toggle="tooltip" data-placement="top" title="fa lemon o"><i class="fa fa-lemon-o"></i></span>
					<span class="fa-icon" data-icon="fa-level-down" data-toggle="tooltip" data-placement="top" title="fa level down"><i class="fa fa-level-down"></i></span>
					<span class="fa-icon" data-icon="fa-level-up" data-toggle="tooltip" data-placement="top" title="fa level up"><i class="fa fa-level-up"></i></span>
					<span class="fa-icon" data-icon="fa-life-bouy" data-toggle="tooltip" data-placement="top" title="fa life bouy"><i class="fa fa-life-bouy"></i></span>
					<span class="fa-icon" data-icon="fa-life-buoy" data-toggle="tooltip" data-placement="top" title="fa life buoy"><i class="fa fa-life-buoy"></i></span>
					<span class="fa-icon" data-icon="fa-life-ring" data-toggle="tooltip" data-placement="top" title="fa life ring"><i class="fa fa-life-ring"></i></span>
					<span class="fa-icon" data-icon="fa-life-saver" data-toggle="tooltip" data-placement="top" title="fa life saver"><i class="fa fa-life-saver"></i></span>
					<span class="fa-icon" data-icon="fa-lightbulb-o" data-toggle="tooltip" data-placement="top" title="fa lightbulb o"><i class="fa fa-lightbulb-o"></i></span>
					<span class="fa-icon" data-icon="fa-line-chart" data-toggle="tooltip" data-placement="top" title="fa line chart"><i class="fa fa-line-chart"></i></span>
					<span class="fa-icon" data-icon="fa-location-arrow" data-toggle="tooltip" data-placement="top" title="fa location arrow"><i class="fa fa-location-arrow"></i></span>
					<span class="fa-icon" data-icon="fa-lock" data-toggle="tooltip" data-placement="top" title="fa lock"><i class="fa fa-lock"></i></span>
					<span class="fa-icon" data-icon="fa-magic" data-toggle="tooltip" data-placement="top" title="fa magic"><i class="fa fa-magic"></i></span>
					<span class="fa-icon" data-icon="fa-magnet" data-toggle="tooltip" data-placement="top" title="fa magnet"><i class="fa fa-magnet"></i></span>
					<span class="fa-icon" data-icon="fa-mail-forward" data-toggle="tooltip" data-placement="top" title="fa mail forward"><i class="fa fa-mail-forward"></i></span>
					<span class="fa-icon" data-icon="fa-mail-reply" data-toggle="tooltip" data-placement="top" title="fa mail reply"><i class="fa fa-mail-reply"></i></span>
					<span class="fa-icon" data-icon="fa-mail-reply-all" data-toggle="tooltip" data-placement="top" title="fa mail reply all"><i class="fa fa-mail-reply-all"></i></span>
					<span class="fa-icon" data-icon="fa-male" data-toggle="tooltip" data-placement="top" title="fa male"><i class="fa fa-male"></i></span>
					<span class="fa-icon" data-icon="fa-map-marker" data-toggle="tooltip" data-placement="top" title="fa map marker"><i class="fa fa-map-marker"></i></span>
					<span class="fa-icon" data-icon="fa-meh-o" data-toggle="tooltip" data-placement="top" title="fa meh o"><i class="fa fa-meh-o"></i></span>
					<span class="fa-icon" data-icon="fa-microphone" data-toggle="tooltip" data-placement="top" title="fa microphone"><i class="fa fa-microphone"></i></span>
					<span class="fa-icon" data-icon="fa-microphone-slash" data-toggle="tooltip" data-placement="top" title="fa microphone slash"><i class="fa fa-microphone-slash"></i></span>
					<span class="fa-icon" data-icon="fa-minus" data-toggle="tooltip" data-placement="top" title="fa minus"><i class="fa fa-minus"></i></span>
					<span class="fa-icon" data-icon="fa-minus-circle" data-toggle="tooltip" data-placement="top" title="fa minus circle"><i class="fa fa-minus-circle"></i></span>
					<span class="fa-icon" data-icon="fa-minus-square" data-toggle="tooltip" data-placement="top" title="fa minus square"><i class="fa fa-minus-square"></i></span>
					<span class="fa-icon" data-icon="fa-minus-square-o" data-toggle="tooltip" data-placement="top" title="fa minus square o"><i class="fa fa-minus-square-o"></i></span>
					<span class="fa-icon" data-icon="fa-mobile" data-toggle="tooltip" data-placement="top" title="fa mobile"><i class="fa fa-mobile"></i></span>
					<span class="fa-icon" data-icon="fa-mobile-phone" data-toggle="tooltip" data-placement="top" title="fa mobile phone"><i class="fa fa-mobile-phone"></i></span>
					<span class="fa-icon" data-icon="fa-money" data-toggle="tooltip" data-placement="top" title="fa money"><i class="fa fa-money"></i></span>
					<span class="fa-icon" data-icon="fa-moon-o" data-toggle="tooltip" data-placement="top" title="fa moon o"><i class="fa fa-moon-o"></i></span>
					<span class="fa-icon" data-icon="fa-mortar-board" data-toggle="tooltip" data-placement="top" title="fa mortar board"><i class="fa fa-mortar-board"></i></span>
					<span class="fa-icon" data-icon="fa-music" data-toggle="tooltip" data-placement="top" title="fa music"><i class="fa fa-music"></i></span>
					<span class="fa-icon" data-icon="fa-navicon" data-toggle="tooltip" data-placement="top" title="fa navicon"><i class="fa fa-navicon"></i></span>
					<span class="fa-icon" data-icon="fa-newspaper-o" data-toggle="tooltip" data-placement="top" title="fa newspaper o"><i class="fa fa-newspaper-o"></i></span>
					<span class="fa-icon" data-icon="fa-paint-brush" data-toggle="tooltip" data-placement="top" title="fa paint brush"><i class="fa fa-paint-brush"></i></span>
					<span class="fa-icon" data-icon="fa-paper-plane" data-toggle="tooltip" data-placement="top" title="fa paper plane"><i class="fa fa-paper-plane"></i></span>
					<span class="fa-icon" data-icon="fa-paper-plane-o" data-toggle="tooltip" data-placement="top" title="fa paper plane o"><i class="fa fa-paper-plane-o"></i></span>
					<span class="fa-icon" data-icon="fa-paw" data-toggle="tooltip" data-placement="top" title="fa paw"><i class="fa fa-paw"></i></span>
					<span class="fa-icon" data-icon="fa-pencil" data-toggle="tooltip" data-placement="top" title="fa pencil"><i class="fa fa-pencil"></i></span>
					<span class="fa-icon" data-icon="fa-pencil-square" data-toggle="tooltip" data-placement="top" title="fa pencil square"><i class="fa fa-pencil-square"></i></span>
					<span class="fa-icon" data-icon="fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="fa pencil square o"><i class="fa fa-pencil-square-o"></i></span>
					<span class="fa-icon" data-icon="fa-phone" data-toggle="tooltip" data-placement="top" title="fa phone"><i class="fa fa-phone"></i></span>
					<span class="fa-icon" data-icon="fa-phone-square" data-toggle="tooltip" data-placement="top" title="fa phone square"><i class="fa fa-phone-square"></i></span>
					<span class="fa-icon" data-icon="fa-photo" data-toggle="tooltip" data-placement="top" title="fa photo"><i class="fa fa-photo"></i></span>
					<span class="fa-icon" data-icon="fa-picture-o" data-toggle="tooltip" data-placement="top" title="fa picture o"><i class="fa fa-picture-o"></i></span>
					<span class="fa-icon" data-icon="fa-pie-chart" data-toggle="tooltip" data-placement="top" title="fa pie chart"><i class="fa fa-pie-chart"></i></span>
					<span class="fa-icon" data-icon="fa-plane" data-toggle="tooltip" data-placement="top" title="fa plane"><i class="fa fa-plane"></i></span>
					<span class="fa-icon" data-icon="fa-plug" data-toggle="tooltip" data-placement="top" title="fa plug"><i class="fa fa-plug"></i></span>
					<span class="fa-icon" data-icon="fa-plus" data-toggle="tooltip" data-placement="top" title="fa plus"><i class="fa fa-plus"></i></span>
					<span class="fa-icon" data-icon="fa-plus-circle" data-toggle="tooltip" data-placement="top" title="fa plus circle"><i class="fa fa-plus-circle"></i></span>
					<span class="fa-icon" data-icon="fa-plus-square" data-toggle="tooltip" data-placement="top" title="fa plus square"><i class="fa fa-plus-square"></i></span>
					<span class="fa-icon" data-icon="fa-plus-square-o" data-toggle="tooltip" data-placement="top" title="fa plus square o"><i class="fa fa-plus-square-o"></i></span>
					<span class="fa-icon" data-icon="fa-power-off" data-toggle="tooltip" data-placement="top" title="fa power off"><i class="fa fa-power-off"></i></span>
					<span class="fa-icon" data-icon="fa-print" data-toggle="tooltip" data-placement="top" title="fa print"><i class="fa fa-print"></i></span>
					<span class="fa-icon" data-icon="fa-puzzle-piece" data-toggle="tooltip" data-placement="top" title="fa puzzle piece"><i class="fa fa-puzzle-piece"></i></span>
					<span class="fa-icon" data-icon="fa-qrcode" data-toggle="tooltip" data-placement="top" title="fa qrcode"><i class="fa fa-qrcode"></i></span>
					<span class="fa-icon" data-icon="fa-question" data-toggle="tooltip" data-placement="top" title="fa question"><i class="fa fa-question"></i></span>
					<span class="fa-icon" data-icon="fa-question-circle" data-toggle="tooltip" data-placement="top" title="fa question circle"><i class="fa fa-question-circle"></i></span>
					<span class="fa-icon" data-icon="fa-quote-left" data-toggle="tooltip" data-placement="top" title="fa quote left"><i class="fa fa-quote-left"></i></span>
					<span class="fa-icon" data-icon="fa-quote-right" data-toggle="tooltip" data-placement="top" title="fa quote right"><i class="fa fa-quote-right"></i></span>
					<span class="fa-icon" data-icon="fa-random" data-toggle="tooltip" data-placement="top" title="fa random"><i class="fa fa-random"></i></span>
					<span class="fa-icon" data-icon="fa-recycle" data-toggle="tooltip" data-placement="top" title="fa recycle"><i class="fa fa-recycle"></i></span>
					<span class="fa-icon" data-icon="fa-refresh" data-toggle="tooltip" data-placement="top" title="fa refresh"><i class="fa fa-refresh"></i></span>
					<span class="fa-icon" data-icon="fa-remove" data-toggle="tooltip" data-placement="top" title="fa remove"><i class="fa fa-remove"></i></span>
					<span class="fa-icon" data-icon="fa-reorder" data-toggle="tooltip" data-placement="top" title="fa reorder"><i class="fa fa-reorder"></i></span>
					<span class="fa-icon" data-icon="fa-reply" data-toggle="tooltip" data-placement="top" title="fa reply"><i class="fa fa-reply"></i></span>
					<span class="fa-icon" data-icon="fa-reply-all" data-toggle="tooltip" data-placement="top" title="fa reply all"><i class="fa fa-reply-all"></i></span>
					<span class="fa-icon" data-icon="fa-retweet" data-toggle="tooltip" data-placement="top" title="fa retweet"><i class="fa fa-retweet"></i></span>
					<span class="fa-icon" data-icon="fa-road" data-toggle="tooltip" data-placement="top" title="fa road"><i class="fa fa-road"></i></span>
					<span class="fa-icon" data-icon="fa-rocket" data-toggle="tooltip" data-placement="top" title="fa rocket"><i class="fa fa-rocket"></i></span>
					<span class="fa-icon" data-icon="fa-rss" data-toggle="tooltip" data-placement="top" title="fa rss"><i class="fa fa-rss"></i></span>
					<span class="fa-icon" data-icon="fa-rss-square" data-toggle="tooltip" data-placement="top" title="fa rss square"><i class="fa fa-rss-square"></i></span>
					<span class="fa-icon" data-icon="fa-search" data-toggle="tooltip" data-placement="top" title="fa search"><i class="fa fa-search"></i></span>
					<span class="fa-icon" data-icon="fa-search-minus" data-toggle="tooltip" data-placement="top" title="fa search minus"><i class="fa fa-search-minus"></i></span>
					<span class="fa-icon" data-icon="fa-search-plus" data-toggle="tooltip" data-placement="top" title="fa search plus"><i class="fa fa-search-plus"></i></span>
					<span class="fa-icon" data-icon="fa-send" data-toggle="tooltip" data-placement="top" title="fa send"><i class="fa fa-send"></i></span>
					<span class="fa-icon" data-icon="fa-send-o" data-toggle="tooltip" data-placement="top" title="fa send o"><i class="fa fa-send-o"></i></span>
					<span class="fa-icon" data-icon="fa-share" data-toggle="tooltip" data-placement="top" title="fa share"><i class="fa fa-share"></i></span>
					<span class="fa-icon" data-icon="fa-share-alt" data-toggle="tooltip" data-placement="top" title="fa share alt"><i class="fa fa-share-alt"></i></span>
					<span class="fa-icon" data-icon="fa-share-alt-square" data-toggle="tooltip" data-placement="top" title="fa share alt square"><i class="fa fa-share-alt-square"></i></span>
					<span class="fa-icon" data-icon="fa-share-square" data-toggle="tooltip" data-placement="top" title="fa share square"><i class="fa fa-share-square"></i></span>
					<span class="fa-icon" data-icon="fa-share-square-o" data-toggle="tooltip" data-placement="top" title="fa share square o"><i class="fa fa-share-square-o"></i></span>
					<span class="fa-icon" data-icon="fa-shield" data-toggle="tooltip" data-placement="top" title="fa shield"><i class="fa fa-shield"></i></span>
					<span class="fa-icon" data-icon="fa-shopping-cart" data-toggle="tooltip" data-placement="top" title="fa shopping cart"><i class="fa fa-shopping-cart"></i></span>
					<span class="fa-icon" data-icon="fa-sign-in" data-toggle="tooltip" data-placement="top" title="fa sign in"><i class="fa fa-sign-in"></i></span>
					<span class="fa-icon" data-icon="fa-sign-out" data-toggle="tooltip" data-placement="top" title="fa sign out"><i class="fa fa-sign-out"></i></span>
					<span class="fa-icon" data-icon="fa-signal" data-toggle="tooltip" data-placement="top" title="fa signal"><i class="fa fa-signal"></i></span>
					<span class="fa-icon" data-icon="fa-sitemap" data-toggle="tooltip" data-placement="top" title="fa sitemap"><i class="fa fa-sitemap"></i></span>
					<span class="fa-icon" data-icon="fa-sliders" data-toggle="tooltip" data-placement="top" title="fa sliders"><i class="fa fa-sliders"></i></span>
					<span class="fa-icon" data-icon="fa-smile-o" data-toggle="tooltip" data-placement="top" title="fa smile o"><i class="fa fa-smile-o"></i></span>
					<span class="fa-icon" data-icon="fa-soccer-ball-o" data-toggle="tooltip" data-placement="top" title="fa soccer ball o"><i class="fa fa-soccer-ball-o"></i></span>
					<span class="fa-icon" data-icon="fa-sort" data-toggle="tooltip" data-placement="top" title="fa sort"><i class="fa fa-sort"></i></span>
					<span class="fa-icon" data-icon="fa-sort-alpha-asc" data-toggle="tooltip" data-placement="top" title="fa sort alpha asc"><i class="fa fa-sort-alpha-asc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-alpha-desc" data-toggle="tooltip" data-placement="top" title="fa sort alpha desc"><i class="fa fa-sort-alpha-desc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-amount-asc" data-toggle="tooltip" data-placement="top" title="fa sort amount asc"><i class="fa fa-sort-amount-asc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-amount-desc" data-toggle="tooltip" data-placement="top" title="fa sort amount desc"><i class="fa fa-sort-amount-desc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-asc" data-toggle="tooltip" data-placement="top" title="fa sort asc"><i class="fa fa-sort-asc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-desc" data-toggle="tooltip" data-placement="top" title="fa sort desc"><i class="fa fa-sort-desc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-down" data-toggle="tooltip" data-placement="top" title="fa sort down"><i class="fa fa-sort-down"></i></span>
					<span class="fa-icon" data-icon="fa-sort-numeric-asc" data-toggle="tooltip" data-placement="top" title="fa sort numeric asc"><i class="fa fa-sort-numeric-asc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-numeric-desc" data-toggle="tooltip" data-placement="top" title="fa sort numeric desc"><i class="fa fa-sort-numeric-desc"></i></span>
					<span class="fa-icon" data-icon="fa-sort-up" data-toggle="tooltip" data-placement="top" title="fa sort up"><i class="fa fa-sort-up"></i></span>
					<span class="fa-icon" data-icon="fa-space-shuttle" data-toggle="tooltip" data-placement="top" title="fa space shuttle"><i class="fa fa-space-shuttle"></i></span>
					<span class="fa-icon" data-icon="fa-spinner" data-toggle="tooltip" data-placement="top" title="fa spinner"><i class="fa fa-spinner"></i></span>
					<span class="fa-icon" data-icon="fa-spoon" data-toggle="tooltip" data-placement="top" title="fa spoon"><i class="fa fa-spoon"></i></span>
					<span class="fa-icon" data-icon="fa-square" data-toggle="tooltip" data-placement="top" title="fa square"><i class="fa fa-square"></i></span>
					<span class="fa-icon" data-icon="fa-square-o" data-toggle="tooltip" data-placement="top" title="fa square o"><i class="fa fa-square-o"></i></span>
					<span class="fa-icon" data-icon="fa-star" data-toggle="tooltip" data-placement="top" title="fa star"><i class="fa fa-star"></i></span>
					<span class="fa-icon" data-icon="fa-star-half" data-toggle="tooltip" data-placement="top" title="fa star half"><i class="fa fa-star-half"></i></span>
					<span class="fa-icon" data-icon="fa-star-half-empty" data-toggle="tooltip" data-placement="top" title="fa star half empty"><i class="fa fa-star-half-empty"></i></span>
					<span class="fa-icon" data-icon="fa-star-half-full" data-toggle="tooltip" data-placement="top" title="fa star half full"><i class="fa fa-star-half-full"></i></span>
					<span class="fa-icon" data-icon="fa-star-half-o" data-toggle="tooltip" data-placement="top" title="fa star half o"><i class="fa fa-star-half-o"></i></span>
					<span class="fa-icon" data-icon="fa-star-o" data-toggle="tooltip" data-placement="top" title="fa star o"><i class="fa fa-star-o"></i></span>
					<span class="fa-icon" data-icon="fa-suitcase" data-toggle="tooltip" data-placement="top" title="fa suitcase"><i class="fa fa-suitcase"></i></span>
					<span class="fa-icon" data-icon="fa-sun-o" data-toggle="tooltip" data-placement="top" title="fa sun o"><i class="fa fa-sun-o"></i></span>
					<span class="fa-icon" data-icon="fa-support" data-toggle="tooltip" data-placement="top" title="fa support"><i class="fa fa-support"></i></span>
					<span class="fa-icon" data-icon="fa-tablet" data-toggle="tooltip" data-placement="top" title="fa tablet"><i class="fa fa-tablet"></i></span>
					<span class="fa-icon" data-icon="fa-tachometer" data-toggle="tooltip" data-placement="top" title="fa tachometer"><i class="fa fa-tachometer"></i></span>
					<span class="fa-icon" data-icon="fa-tag" data-toggle="tooltip" data-placement="top" title="fa tag"><i class="fa fa-tag"></i></span>
					<span class="fa-icon" data-icon="fa-tags" data-toggle="tooltip" data-placement="top" title="fa tags"><i class="fa fa-tags"></i></span>
					<span class="fa-icon" data-icon="fa-tasks" data-toggle="tooltip" data-placement="top" title="fa tasks"><i class="fa fa-tasks"></i></span>
					<span class="fa-icon" data-icon="fa-taxi" data-toggle="tooltip" data-placement="top" title="fa taxi"><i class="fa fa-taxi"></i></span>
					<span class="fa-icon" data-icon="fa-terminal" data-toggle="tooltip" data-placement="top" title="fa terminal"><i class="fa fa-terminal"></i></span>
					<span class="fa-icon" data-icon="fa-thumb-tack" data-toggle="tooltip" data-placement="top" title="fa thumb tack"><i class="fa fa-thumb-tack"></i></span>
					<span class="fa-icon" data-icon="fa-thumbs-down" data-toggle="tooltip" data-placement="top" title="fa thumbs down"><i class="fa fa-thumbs-down"></i></span>
					<span class="fa-icon" data-icon="fa-thumbs-o-down" data-toggle="tooltip" data-placement="top" title="fa thumbs o down"><i class="fa fa-thumbs-o-down"></i></span>
					<span class="fa-icon" data-icon="fa-thumbs-o-up" data-toggle="tooltip" data-placement="top" title="fa thumbs o up"><i class="fa fa-thumbs-o-up"></i></span>
					<span class="fa-icon" data-icon="fa-thumbs-up" data-toggle="tooltip" data-placement="top" title="fa thumbs up"><i class="fa fa-thumbs-up"></i></span>
					<span class="fa-icon" data-icon="fa-ticket" data-toggle="tooltip" data-placement="top" title="fa ticket"><i class="fa fa-ticket"></i></span>
					<span class="fa-icon" data-icon="fa-times" data-toggle="tooltip" data-placement="top" title="fa times"><i class="fa fa-times"></i></span>
					<span class="fa-icon" data-icon="fa-times-circle" data-toggle="tooltip" data-placement="top" title="fa times circle"><i class="fa fa-times-circle"></i></span>
					<span class="fa-icon" data-icon="fa-times-circle-o" data-toggle="tooltip" data-placement="top" title="fa times circle o"><i class="fa fa-times-circle-o"></i></span>
					<span class="fa-icon" data-icon="fa-tint" data-toggle="tooltip" data-placement="top" title="fa tint"><i class="fa fa-tint"></i></span>
					<span class="fa-icon" data-icon="fa-toggle-down" data-toggle="tooltip" data-placement="top" title="fa toggle down"><i class="fa fa-toggle-down"></i></span>
					<span class="fa-icon" data-icon="fa-toggle-left" data-toggle="tooltip" data-placement="top" title="fa toggle left"><i class="fa fa-toggle-left"></i></span>
					<span class="fa-icon" data-icon="fa-toggle-off" data-toggle="tooltip" data-placement="top" title="fa toggle off"><i class="fa fa-toggle-off"></i></span>
					<span class="fa-icon" data-icon="fa-toggle-on" data-toggle="tooltip" data-placement="top" title="fa toggle on"><i class="fa fa-toggle-on"></i></span>
					<span class="fa-icon" data-icon="fa-toggle-right" data-toggle="tooltip" data-placement="top" title="fa toggle right"><i class="fa fa-toggle-right"></i></span>
					<span class="fa-icon" data-icon="fa-toggle-up" data-toggle="tooltip" data-placement="top" title="fa toggle up"><i class="fa fa-toggle-up"></i></span>
					<span class="fa-icon" data-icon="fa-trash" data-toggle="tooltip" data-placement="top" title="fa trash"><i class="fa fa-trash"></i></span>
					<span class="fa-icon" data-icon="fa-trash-o" data-toggle="tooltip" data-placement="top" title="fa trash o"><i class="fa fa-trash-o"></i></span>
					<span class="fa-icon" data-icon="fa-tree" data-toggle="tooltip" data-placement="top" title="fa tree"><i class="fa fa-tree"></i></span>
					<span class="fa-icon" data-icon="fa-trophy" data-toggle="tooltip" data-placement="top" title="fa trophy"><i class="fa fa-trophy"></i></span>
					<span class="fa-icon" data-icon="fa-truck" data-toggle="tooltip" data-placement="top" title="fa truck"><i class="fa fa-truck"></i></span>
					<span class="fa-icon" data-icon="fa-tty" data-toggle="tooltip" data-placement="top" title="fa tty"><i class="fa fa-tty"></i></span>
					<span class="fa-icon" data-icon="fa-umbrella" data-toggle="tooltip" data-placement="top" title="fa umbrella"><i class="fa fa-umbrella"></i></span>
					<span class="fa-icon" data-icon="fa-university" data-toggle="tooltip" data-placement="top" title="fa university"><i class="fa fa-university"></i></span>
					<span class="fa-icon" data-icon="fa-unlock" data-toggle="tooltip" data-placement="top" title="fa unlock"><i class="fa fa-unlock"></i></span>
					<span class="fa-icon" data-icon="fa-unlock-alt" data-toggle="tooltip" data-placement="top" title="fa unlock alt"><i class="fa fa-unlock-alt"></i></span>
					<span class="fa-icon" data-icon="fa-unsorted" data-toggle="tooltip" data-placement="top" title="fa unsorted"><i class="fa fa-unsorted"></i></span>
					<span class="fa-icon" data-icon="fa-upload" data-toggle="tooltip" data-placement="top" title="fa upload"><i class="fa fa-upload"></i></span>
					<span class="fa-icon" data-icon="fa-user" data-toggle="tooltip" data-placement="top" title="fa user"><i class="fa fa-user"></i></span>
					<span class="fa-icon" data-icon="fa-users" data-toggle="tooltip" data-placement="top" title="fa users"><i class="fa fa-users"></i></span>
					<span class="fa-icon" data-icon="fa-video-camera" data-toggle="tooltip" data-placement="top" title="fa video camera"><i class="fa fa-video-camera"></i></span>
					<span class="fa-icon" data-icon="fa-volume-down" data-toggle="tooltip" data-placement="top" title="fa volume down"><i class="fa fa-volume-down"></i></span>
					<span class="fa-icon" data-icon="fa-volume-off" data-toggle="tooltip" data-placement="top" title="fa volume off"><i class="fa fa-volume-off"></i></span>
					<span class="fa-icon" data-icon="fa-volume-up" data-toggle="tooltip" data-placement="top" title="fa volume up"><i class="fa fa-volume-up"></i></span>
					<span class="fa-icon" data-icon="fa-warning" data-toggle="tooltip" data-placement="top" title="fa warning"><i class="fa fa-warning"></i></span>
					<span class="fa-icon" data-icon="fa-wheelchair" data-toggle="tooltip" data-placement="top" title="fa wheelchair"><i class="fa fa-wheelchair"></i></span>
					<span class="fa-icon" data-icon="fa-wifi" data-toggle="tooltip" data-placement="top" title="fa wifi"><i class="fa fa-wifi"></i></span>
					<span class="fa-icon" data-icon="fa-wrench" data-toggle="tooltip" data-placement="top" title="fa wrench"><i class="fa fa-wrench"></i></span>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>