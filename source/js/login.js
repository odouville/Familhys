// jqXHR.status       => HTTP status : 400, 401, aso...
// jqXHR.statusCode   => donnée bizarre... pas vraiment exploitable
// jqXHR.statusText   => 'Unauthorized'
// jqXHR.responseText => objet json associé à la réponse {'error':'Echec identification','message':'Identifiant ou mot de passe invalide'}
var err = false;
function afficher_erreur(msg){
	if (!err)
	{
		$('#message').html(msg);
		$('#message').slideDown('fast');
		err = true;
	}
};
function cacher_erreur(){
	if (err)
	{
		err = false;
		$('#message').slideUp('fast', function(){
			$('#message').empty();
		});
	}
};
$(document).ready(function() {
	$('#log').on('keydown', function(){
		cacher_erreur();
	});
	$('#pwd').on('keydown', function(){
		cacher_erreur();
	});
	$('#login_form').on('submit', function(){
		// Nouvelle vérification de mot de passe : on remonte le div d'erreur
		cacher_erreur();
		
		// Get some values from elements on the page:
		var login = $('#log').val(),
			pwd = $('#pwd').val();
		
	    const salt = "48@!alsd";
	    var encryptedPassword = CryptoJS.SHA1(CryptoJS.SHA1(pwd)+salt).toString();
		
//			url: 'http://srvchedoo/rest/login/',
		jQuery.ajax({
			url: '/rest/login/',
			type: 'POST',
			data: { login: login, encpwd: encryptedPassword },
			dataType: 'json',
			success: function(data) {
				$('#login').val(login);
				$('#encpwd').val(encryptedPassword);
				$('#remember').val($('#remember-me').is(':checked') ? 1 : 0);
				$('#real_form').submit();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				var data = $.parseJSON(jqXHR.responseText);
				afficher_erreur(data.error + '<br />' + data.message);
				
				// Stop form from submitting normally
				event.preventDefault();
			},
		});
	});
})
;
