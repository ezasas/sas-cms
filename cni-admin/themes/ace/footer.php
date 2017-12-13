<?php if(!defined('basePath')) exit('No direct script access allowed'); ?>

		<!-- bootstrap scripts -->		
		<?=$this->load_js($this->themeURL().'assets/js/bootstrap.js');?>
		
		<!-- ace scripts -->
		<script src="<?=$this->themeURL()?>assets/js/ace/elements.scroller.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/ace.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/ace.settings.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/ace.sidebar.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/ace.submenu-hover.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/ace.widget-box.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/ace.widget-on-reload.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/ace/elements.fileinput.js"></script>
		
		<!-- plugin scripts -->		
		<script src="<?=$this->themeURL()?>assets/js/date-time/bootstrap-datepicker.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/date-time/bootstrap-timepicker.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/date-time/moment.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/date-time/daterangepicker.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/date-time/bootstrap-datetimepicker.js"></script>	
		<script src="<?=$this->themeURL()?>assets/js/bootstrap-colorpicker.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/jquery.dataTables.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/jquery.dataTables.bootstrap.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/chosen.jquery.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/jquery.nestable.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/jquery.slimscroll.min.js"></script>
		<?=$this->load_js(systemURL.'plugins/js/jquery.cookie.min.js');?>		

		<!--
		Required for statitik function
		-->
		<script src="<?=$this->themeURL()?>assets/js/flot/jquery.flot.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/flot/jquery.flot.pie.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/flot/jquery.flot.resize.js"></script>
		<!--
		End of Required for statitik function
		-->		
		
		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?=$this->themeURL()?>assets/js/excanvas.js"></script>
		<![endif]-->

		<!-- ace scripts -->

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});
				
				/* Active menu */
				var thisMenuId 	 = '<?=$this->thisMenuID()?>';
				var parentId 	 = '<?=$this->getParentID($this->thisMenuID())?>';
				var mainParentId = '<?=$this->mainParentID()?>';
				
				if($("#m"+mainParentId).data('child')=='haschild'){
					$("#m"+mainParentId).addClass("open active");
				}
				if($("#m"+parentId).data('child')=='haschild'){
					$("#m"+parentId).addClass("open active");
				}
				$("#m"+thisMenuId).addClass("active");
				
				/* tooltip */
				$('[data-toggle="tooltip"]').tooltip();
				
				/* th check all */
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
				
				/* remove .row before datatable */
				$(".dataTable").prev().remove();
				$(".dataTable").next().remove();
				
				/* datepicker */
				$(".date-picker").datepicker({
					format: "yyyy-mm-dd",
					autoclose: true,
					todayHighlight: true
				})
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				/* date time picker */
				$('.date-timepicker').datetimepicker({
					use24hours: true,
					format: 'YYYY-MM-DD HH:mm:ss'
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				/* timepicker */
				$('.time-picker').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				//date range picker
				$('.date-range-picker').daterangepicker({
					'applyClass' : 'btn-sm btn-success',
					'cancelClass' : 'btn-sm btn-default',
					locale: {
						applyLabel: 'Apply',
						cancelLabel: 'Cancel',
					}
				})
				.prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
				
				/* color picker */
				$('.color-picker').colorpicker().on('changeColor', function(ev){
					$(this).next().children().css('background',ev.color.toHex())
				})
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				/* file-input */
				$('.id-input-file').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false, //| true | large
					allowExt: ["zip", "pdf"]
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				}).on('change', function(){
					//cek tipe file
				});
				
				$('.id-input-image').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false, //| true | large
					allowExt: ["gif", "png","jpg", "jpeg"]
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				}).on('change', function(){
					//cek tipe file
				});
				
				/* Styling select */
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
				
				/* Input icon */
				$('.fa-icon').click(function(){
				
					var icon   = $(this).data('icon');
					var iconId = $(this).data('id');
					
					$('#icon'+iconId).removeAttr('class');
					$('#icon'+iconId).addClass('fa '+icon);
					$('#input-icon'+iconId).val('fa '+icon);
					$('#modal-'+iconId).modal('hide');
				});
				
				/* change admin skin */
				$('.btn-skin').click(function(){
					
					var skin = $(this).data('id');
					
					// Set time
					var expiryDate = new Date();
					var hours = 168;
					expiryDate.setTime(expiryDate.getTime() + (hours * 3600 * 1000));

					var oldSkin = $.cookie('adminSkin');
					$("body").removeClass(oldSkin);
					
					// Create cookie to expire in 168 hours (1 week)
					$.cookie("adminSkin", skin, { path: '/', expires: expiryDate });
					$("body").addClass(skin);
					
					return false;
				});
				
				/* sidebar */
				var windowHeight	 = $(window).height();
				var sidebarHeight	 = $('#sidebar').height();
				var sidebar2Height	 = $('#sidebar2').innerHeight();
				var topHeight		 = sidebarHeight+45+17;
				var contentHeight	 = windowHeight-topHeight;
				var mainContent 	 = $('.main-content').height();
				var setSidebarHeight = contentHeight;
				
				if(mainContent > setSidebarHeight){
					setSidebarHeight = mainContent;
				}					
				if(sidebar2Height > setSidebarHeight){
					setSidebarHeight = sidebar2Height;
				}
				
				$('#sidebar2').css('height',setSidebarHeight);				
				
				$(window).resize(function(){
				
					var windowHeight	 = $(window).height();
					var sidebarHeight	 = $('#sidebar').height();
					var sidebar2Height	 = $('#sidebar2').innerHeight();
					var topHeight		 = sidebarHeight+45+17;
					var contentHeight	 = windowHeight-topHeight;
					var mainContent 	 = $('.main-content').height();
					var setSidebarHeight = contentHeight;
					
					if(mainContent > setSidebarHeight){
						setSidebarHeight = mainContent;
					}					
					if(sidebar2Height > setSidebarHeight){
						setSidebarHeight = sidebar2Height;
					}
					
					$('#sidebar2').css('height',setSidebarHeight);				
				});
				
				/* sidebar min */
				$(".angle-icon").click(function(){
				
					// Set time
					var expiryDate = new Date();
					var hours = 168;
					expiryDate.setTime(expiryDate.getTime() + (hours * 3600 * 1000));

					var oldSidebar = $.cookie('sidebarMin');
					
					//alert(oldSidebar);
					if(oldSidebar==''){
						var setCookie = 'menu-min';
					}
					else{
						var setCookie = '';
					}

					// Create cookie to expire in 168 hours (1 week)
					$.cookie("sidebarMin", setCookie, { path: '/', expires: expiryDate });
				});
			})
		</script>
		
	</body>
</html>
