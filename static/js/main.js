$(document).ready(function(){
	setInterval(function () {
	    	getMessages();   
	    }, 600);

	$('#input-message').on('keypress', function(e) {
	    if(e.which == 13) {
	        $("#btn-submit").click()
	    }
	});

	$("#btn-submit").click(function(){ 
		$.ajax({
			method: "POST",
			url: "ajax_chat.php",
			data: { message: document.getElementById('input-message').value }
		});

		$('#input-message').val('')
	});
});

function getMessages(){
	$.ajax({
		method: "GET",
		url: "ajax_chat.php",
	})
	.done(function(data){ 
		if(data == "")
			return

		data = JSON.parse(data)

		for (i = 0; i < data.length; i++) { 
			var template = $('#message-template').clone().removeAttr('id').removeAttr('style')
			var message = data[i]

			template.find('#message-image').attr('src', message.imgUrl).removeAttr('id')
			template.find('#message-username').text(message.username).removeAttr('id')
			template.find('#message-time').text(message.when).removeAttr('id')
			template.find('#message-text').text(message.message).removeAttr('id')
			
			template.prependTo('#ul-chat')
		}
	});
}
