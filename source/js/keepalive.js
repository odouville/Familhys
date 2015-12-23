$(document).ready(function() {
	$.get('keepalive.php?q', function(data){
		var interv = data * 100;
		setInterval(function(){
			$.get('keepalive.php', function(data){
			});
		}, interv);
	});
})
;
