<?php if(!defined('basePath')) exit('No direct script access allowed'); ?>

<li id="message-list" class="blue">
	<a data-toggle="dropdown" class="dropdown-toggle" href="#">
		<i class="fa fa-envelope icon-animated-vertical"></i>
		<span class="badge badge-danger badge-total-contact"></span>
	</a>
	<ul id="messages" class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
	
	</ul>
</li>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-contact-detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Message Detail</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Date</label>
					<div id="contact-date">&nbsp;</div>
				</div>
				<div class="form-group">
					<label>From</label>
					<div id="contact-name">&nbsp;</div>
				</div>
				<div class="form-group">
					<label>Email</label>
					<div id="contact-email">&nbsp;</div>
				</div>
				<div class="form-group">
					<label>Message</label>
					<div id="contact-message">&nbsp;</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
.dropdown-menu.dropdown-caret::before,
.dropdown-menu.dropdown-caret::after {
  left: auto;
  right: 15px;
}
.dropdown-menu.dropdown-closer {
  left: auto;
  right: 0;
}
.slimScrollDiv{margin: 0 -8px;}
.contact-list{
	padding: 0;	
	list-style: none;
	margin: 0;
	max-height: 360px;
	overflow: auto;
}
.contact-list .message-item{
	padding: 10px;
	border-width: 1px 0 0;
}
.contact-list .message-item a {
	background-color: transparent !important;
	color: #555 !important;
	font-size: 12px;
	margin: 0;
	padding: 0;
	white-space: normal;
	display: block;
}
.contact-list .message-item .msg-title {
	display: inline-block;
	line-height: 14px;
}
.contact-list .message-item .msg-time {
	color: #777;
	display: block;
	font-size: 11px;
}
.modal-body label{
	font-size: 13px;
	font-weight: 600
}
</style>

<script>
jQuery(function($) {
	
	getMessage();
	function getMessage(){
	
		var xajaxFile = ajaxURL+"cni-content/modules/home/widget/bar.contactus.getmessage.php";
		
		$.ajax({
			
			type: 'POST',
			url: xajaxFile,
			dataType: 'json',
			success: function(data){
				
				$('.badge-total-contact').html(data.totalMessage);
				$('#messages').html('<li class="nav-header contact-total-message"><i class="icon-envelope-alt"></i><span class="badge-total-contact">'+data.totalMessage+'</span> Messages</li><li>'+data.getMessageList+'</li><li class="message-item"><a href="'+data.contatUrl+'">See all messages<i class="icon-arrow-right"></i></a></li>');
					$('.contact-list').slimScroll({
					height: '360px'
				});
			}
		});
	};
	
	$(document).on('click','.btn-contact-detail',function(){
		
		var messageID = ($(this).data('id'));
		var name = ($(this).data('name'));
		var email = ($(this).data('email'));
		var message = ($(this).data('message'));
		var xDate = ($(this).data('date'));
		
		var xajaxFile = ajaxURL+"cni-content/modules/home/widget/bar.contactus.update.php";
	
		$.ajax({
			
			type: 'POST',
			url: xajaxFile,
			data: {id:messageID},
			dataType: 'json',
			success: function(data){
				
			}
		});
		
		getMessage();
		$('#contact-date').html(xDate);
		$('#contact-name').html(name);
		$('#contact-email').html('<a href="mailto:'+email+'">'+email+'</a>');
		$('#contact-message').html(message);		
		$('#modal-contact-detail').modal();	
		
		return false;
	});
	
	$('#modal-contact-detail').on('hidden.bs.modal', function () {
		$('#message-list').addClass('open');
	});	
});
</script>