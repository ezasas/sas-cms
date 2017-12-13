<?php if (!defined('basePath')) exit('No direct script access allowed');

$photo             = new stdClass();
$photo->items      = $this->db->getAll("select title,description,image from ".$this->table_prefix."gallery_image where publish='1' order by gallery_id desc limit 9");
$imageUrl  = uploadURL.'modules/gallery/';
$thumbUrl  = uploadURL.'modules/gallery/thumbs/mini/';
$thumbImg  ="";
?>
		
		<!-- /.Footer
		================================================== -->
        <footer>			
            <!-- Start Copyright -->
			<div class="copyright-section">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<p><?php echo strDecode($this->site->footer()); ?></p>
						</div>
						<div class="col-md-6 text-right">
							<?php echo $this->copyright()?>
						</div>
					</div>
				</div>
			</div>
			<!-- End Copyright -->
        </footer>
		<!-- /.Footer -->
		
		<!-- Go To Top Link -->
		<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
		
		<!-- Style Switcher -->
		<div class="switcher-box">
			<a href="#" class="open-switcher"><i class="fa fa-cog faa-spin animated"></i></a>
			<h4>Color Switcher</h4>
			<span>Available Colors</span>
			<ul class="colors-list">
				<li><a title="Blue" class="btn-color-switcher blue" data-skin="skin1"></a></li>
				<li><a title="Light Blue" class="btn-color-switcher light-blue" data-skin="skin2"></a></li>
				<li><a title="Indigo" class="btn-color-switcher indigo" data-skin="skin3"></a></li>
				<li><a title="Teal" class="btn-color-switcher teal" data-skin="skin4"></a></li>
				<li><a title="Green" class="btn-color-switcher green" data-skin="skin5"></a></li>
				<li><a title="Light Green" class="btn-color-switcher light-green" data-skin="skin6"></a></li>
				<li><a title="Amber" class="btn-color-switcher amber" data-skin="skin7"></a></li>
				<li><a title="orange" class="btn-color-switcher orange" data-skin="skin8"></a></li>
				<li><a title="Deep Orange" class="btn-color-switcher deep-orange" data-skin="skin9"></a></li>
				<li><a title="Red" class="btn-color-switcher red" data-skin="skin10"></a></li>
				<li><a title="Pink" class="btn-color-switcher pink" data-skin="skin11"></a></li>
				<li><a title="Purple" class="btn-color-switcher purple" data-skin="skin12"></a></li>
			</ul>
		</div>
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<?php echo $this->load_js($this->themeURL().'assets/js/jquery-1.10.1.min.js');?>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<?php echo $this->load_js($this->themeURL().'assets/js/bootstrap.min.js');?>
		<?php echo $this->load_js($this->themeURL().'assets/js/owl.carousel.min.js');?>
		<?php echo $this->load_js($this->themeURL().'assets/js/jquery.cookie.js');?>
		<?php echo $this->load_js($this->themeURL().'assets/js/script.js');?><!-- GMap script -->

        <?=$this->load_js($this->themeURL().'assets/js/jquery.blueimp-gallery.min.js');?> <!-- Image Gallery -->

        <script>
              document.getElementsByClassName('links').onclick = function (event) {
                  event = event || window.event;
                  var target = event.target || event.srcElement,
                      link = target.src ? target.parentNode : target,
                      options = {index: link, event: event},
                      links = this.getElementsByTagName('a');
                  blueimp.Gallery(links, options);
              };
          </script>
		
		<?php
		if($this->thisModule()=='contactus'){
			
			$contactSettings = $this->getParams('contact');
			$markerInfo		 = base64_decode($contactSettings['content']);
			$markerInfo		 = '<h4>'.$this->site->company_name().'</h4>'.$this->site->company_address();
			?>
			
			<!-- Map -->
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=<?php echo $this->config['googleKey'] ?>"></script>	
			<script type="text/javascript">
			jQuery.noConflict();
			jQuery(document).ready(function($){

				/* Listing map */
				var image = themeURL+'img/pin.png';
				var latLng = new google.maps.LatLng(<?php echo $contactSettings['geolocation'] ?>);
				var map = new google.maps.Map(document.getElementById("map-canvass"), {
					zoom: 15,
					scaleControl: false,
					scrollwheel: false,
					center: latLng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				
				/* Add Marker */
				var marker = new google.maps.Marker({
					position: latLng,
					map: map,
					icon: image
				});
				
				/* Add Info window */
				var contentString = '<?=$markerInfo?>';
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});
		
				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});
			});
			</script>
			<?
		}
		?>
	</body>
</html>