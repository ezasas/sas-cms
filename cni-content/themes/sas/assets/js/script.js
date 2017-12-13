jQuery.noConflict();
jQuery(document).ready(function($){
	
	/*---------------------------------------------------
	Tooltip
	----------------------------------------------------*/	
	$('[rel="tooltip"]').tooltip();

	/*---------------------------------------------------
	Remove li scpace(display: inline)
	----------------------------------------------------*/	
	$('ul').contents().filter(function() { return this.nodeType === 3; }).remove();
	
	/*---------------------------------------------------
	Slider
	----------------------------------------------------*/
	
	/* Animate caption */
	
	/* title */
	$('#slider').find('.title').addClass('animated');
	$('#slider').find('.title').addClass('bounceInDown');
	
	$('#slider').find('.title').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$(this).removeClass('animated');
		$(this).removeClass('bounceInDown');
	});
	
	/* info */
	$('#slider').find('.info').addClass('animated');
	$('#slider').find('.info').addClass('bounceInRight');
	
	$('#slider').find('.info').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$(this).removeClass('animated');
		$(this).removeClass('bounceInRight');
	});
	
	/* button */
	$('#slider').find('.button').addClass('animated');
	$('#slider').find('.button').addClass('bounceInUp');
	
	$('#slider').find('.button').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$(this).removeClass('animated');
		$(this).removeClass('bounceInUp');
	});			
	
	$('#slider').on('slid.bs.carousel', function () {
	
		/* title */
		$('#slider').find('.title').addClass('animated');
		$('#slider').find('.title').addClass('bounceInDown');
		
		$('#slider').find('.title').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass('animated');
			$(this).removeClass('bounceInDown');
		});
		
		/* info */
		$('#slider').find('.info').addClass('animated');
		$('#slider').find('.info').addClass('bounceInRight');
		
		$('#slider').find('.info').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass('animated');
			$(this).removeClass('bounceInRight');
		});
		
		/* button */
		$('#slider').find('.button').addClass('animated');
		$('#slider').find('.button').addClass('bounceInUp');
		
		$('#slider').find('.button').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass('animated');
			$(this).removeClass('bounceInUp');
		});
	});
	
	/* Carousel progressbar */
	var percent = 0, bar = $('.carousel-bar'), crsl = $('.carousel');
	function progressBarCarousel() {
		bar.css({width:percent+'%'});
		percent = percent +1;
		if (percent>100) {
			percent=0;
			crsl.carousel('next');
		}
	}
	var barInterval = setInterval(progressBarCarousel, 100);
	crsl.carousel({
		interval: false,
		pause: false
	}).on('slid.bs.carousel', function () {percent=0;});
	crsl.hover(
		function(){
			clearInterval(barInterval);
		},
		function(){
			barInterval = setInterval(progressBarCarousel, 100);
		}
	)
	
	/*---------------------------------------------------
	Latest post 
	----------------------------------------------------*/
	$(".latest-posts-classic").owlCarousel({
		items : 2,
		lazyLoad : true,
		navigation : true,
		navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
		pagination : false,
		itemsDesktop: false,
		itemsDesktopSmall: [979,2],
		itemsTablet: [768,2],
		itemsMobile: [479,1]
	});
	
	/*---------------------------------------------------
	Video 
	----------------------------------------------------*/
	$(".video-classic").owlCarousel({
		items : 1,
		lazyLoad : true,
		navigation : true,
		navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
		pagination : false,
		itemsDesktop: false,
		itemsDesktopSmall: [979,2],
		itemsTablet: [768,2],
		itemsMobile: [479,1]
	});
	
	/*---------------------------------------------------
	Testimonial 
	----------------------------------------------------*/
	$(".testimonial-carousel").owlCarousel({
		items : 1,
		autoPlay: 5000,
		lazyLoad : true,
		navigation : false,
		pagination : true,
		itemsDesktop: false,
		itemsDesktopSmall: [979,1],
		itemsTablet: [768,1]
	});
	
	/*---------------------------------------------------
	Contact Us
	----------------------------------------------------*/
	$("#contactForm").submit(function(){
		
		var xajaxFile = ajaxURL+"cni-content/modules/contactus/act.contactus.php";
		
		$('.msg-alert').html('');
		$('.contact-progress').show();
		
		$.ajax({
			
			type: 'POST',
			url: xajaxFile,
			data: $("#contactForm").serialize(),
			dataType: 'json',
			success: function(data){
				
				if(!data.error){
					
					$(":input","#contactForm")
					.not(":button, :submit, :reset, :hidden")
					.val("")
					.removeAttr("checked")
					.removeAttr("selected");
					Recaptcha.reload();
					$(".msg-alert").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="glyphicon glyphicon-ok-circle iconleft" aria-hidden="true"></span> '+data.alert+"</div>");
				}
				else{
					$(".msg-alert").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="glyphicon glyphicon-exclamation-sign iconleft" aria-hidden="true"></span> '+data.alert+"</div>");
				}
				$('.contact-progress').hide();
			}
		});
		return false;
	});
	
	/*---------------------------------------------------
	To top 
	----------------------------------------------------*/
	if ($(window).scrollTop() > $(window).height()) {
		$('.back-to-top').fadeIn();
	}
	else{
		$('.back-to-top').fadeOut();
	}
	
	$(window).scroll(function(){
	
		if ($(this).scrollTop() > $(this).height()) {
			$('.back-to-top').fadeIn();
		}
		else{
			$('.back-to-top').fadeOut();
		}
	})
	
	$( window ).resize(function(){
		
		if ($(this).scrollTop() > $(this).height()) {
			$('.back-to-top').fadeIn();
		}
		else{
			$('.back-to-top').fadeOut();
		}
	})
	
	$('.back-to-top').click(function() {
		$('body,html').animate({scrollTop:0},300);
		return false;
	});
	
	/*---------------------------------------------------
	Switcher
	----------------------------------------------------*/
	$('.open-switcher').click(function(){
		
		if($(this).parent().hasClass('show')){
			$(this).parent().removeClass('show');
			$(this).children().addClass('faa-spin animated');
		}
		else{
			$(this).parent().addClass('show');
			$(this).children().removeClass('faa-spin animated');
		}
		return false;
	});
	$('.btn-color-switcher').click(function(){
	
		skinStyle = $(this).data('skin');					
		$.cookie('skin', skinStyle, { expires: 7 });
		$('.skin-style').attr('href',themeURL+'assets/css/'+$.cookie('skin')+'.css');					
	});
	if($.cookie('skin')){
		skinStyle = $.cookie('skin');
	}
	else{
		skinStyle = 'skin1';
	}
	$('.skin-style').attr('href',themeURL+'assets/css/'+skinStyle+'.css');
	
	/*---------------------------------------------------
	Load statistic
	----------------------------------------------------*/
	$(window).load(function(){
		$(this).load(ajaxURL+"cni-content/modules/statistik/callstats.php");
	});
});