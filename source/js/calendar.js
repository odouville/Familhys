function addEvent(date){
    if (date == null)
	    alert('on ajoute une réservation périodique');
    else {
        if (date.isBefore(moment(), 'day'))
            alert('réservation impossible : la date ' + date.format() + ' est dans le passé');
        else
            alert('on ajoute une réservation pour la date du ' + date.format());
    }
}

function removeEvent(){
	alert('on enlève une réservation');
}

var _lastDateClicked;
var _lastTimeClicked;
function onDayClick(date, jsEvent, view) {
    // Changement de jour pour la sélection
    $(".fc-state-highlight").removeClass("fc-state-highlight");
    $(this).addClass("fc-state-highlight");
    // S'il s'agit d'un double-clic, auquel cas on déclenche une procédure de réservation
    var _d = date.format();
    if ((_lastDateClicked == _d) && ($.now() < (_lastTimeClicked + 500))) addEvent(date);
    // Sauvegarde du jour cliqué et du timestamp pour déterminer un double-clic le cas échéant
    _lastDateClicked = _d;
    _lastTimeClicked = $.now();
}
