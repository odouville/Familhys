<?php

include_once('config.php');

include('verif_login.php');

// Si l'identification a échoué, on redirige vers la page de login
// (pour le cas où cette page a été appelée en direct)
if (!isset($_SESSION['login']))
{
	header('Location: login.php');
	exit();
}

// Les choses sérieuses commencent...
include_once('restclient.php');

// On récupère les informations sur la famille
$rest = $api->get('http://localhost/rest/familles/' . $_SESSION['idfamille'], array(
    'login' => $_SESSION['login'], 'signature' => '...'));
if ($rest->info->http_code === 200) {
    $famille = $rest->decode_response();
}

// On récupère les informations sur les titulaires
$rest = $api->get('http://localhost/rest/familles/' . $_SESSION['idfamille'] . '/titulaires', array(
	'login' => $_SESSION['login'], 'signature' => '...'));
if ($rest->info->http_code === 200) {
	$titulaires = $rest->decode_response();
}

// On récupère les informations sur les enfants
$rest = $api->get('http://localhost/rest/familles/' . $_SESSION['idfamille'] . '/annees/' . date('Y') . '/mois/' . date('n') . '/inscrits', array(
	'login' => $_SESSION['login'], 'signature' => '...'));
if ($rest->info->http_code === 200) {
	$inscrits = $rest->decode_response();
}

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="images/logo.png">

    <title>Fréville - Services périscolaires</title>

    <!-- Bootstrap core CSS -->
	<!--link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css">
	<!-- link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.print.css" -->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/palette.css">

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!--script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script-->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<script type="text/javascript" src="//crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/sha1.js"></script>
	<script type="text/javascript" src="//crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/hmac-sha1.js"></script>
	
	<!--script type="text/javascript" src="lib/moment.min.js"></script-->
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/lang/fr.js"></script>
	
	<script type="text/javascript" src="js/keepalive.js"></script>
	<script type="text/javascript" src="js/calendar.js"></script>
	<script type="text/javascript" src="js/chkbtn.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#calendar').fullCalendar({
			lang: 'fr',
//			theme: true,
			weekNumbers: true,
			weekNumberTitle: 'S.',
			monthNames: [
				'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			customButtons: {
				add: {
					text: 'Ajouter',
					click: function() { addEvent(); }
				},
				delete: {
					text: 'Supprimer',
					click: function() { removeEvent(); }
				}
			},
			header: {
				left: 'prev,next today',
				center: 'prev title next',
				right: 'add,delete'
			},
            dayClick: onDayClick,
			eventSources: [
<?php
$total = count($inscrits);
$genre = array(1 => 'm', 'f', 'f', 'm', 'f');
$cnt = array('m' => 0, 'f' => 0);
$mdate = date('n');
foreach ($inscrits as $inscr)
{
$x = $genre[$inscr->idcivilite];
$cnt[$x]++;
for ($mois = $mdate - 1; $mois <= $mdate + 1; $mois++)
{
//	$url = 'http://srvchedoo/rest/familles/' . $_SESSION['idfamille'] . '/annees/' . date('Y') . '/mois/' . $mois . '/inscrits/' . $inscr->idindividu . '/evtconsos';
	$url = '/rest/familles/' . $_SESSION['idfamille'] . '/annees/' . date('Y') . '/mois/' . $mois . '/inscrits/' . $inscr->idindividu . '/evtconsos';
	echo "{ url: '" . $url . "', className: 'evt_" . $x . $cnt[$x] . ($mois != $mdate ? ' evt_oth_month' : '') . "' }" . ($mois < $mdate + 1 ? ',' : '');
}
if ($cnt['m'] + $cnt['f'] < $total) echo ',';
}
?>
				]
		});
	});
	</script>
  </head>

  <body>

    <div class="container">
        <div class="container panel panel-default">
            <div class="panel panel-default panel-entete">
                <h5 class="text-right">Famille de</h4>
            	<h4 class="text-right"><?php foreach ($titulaires as $tit) echo ($tit->idcivilite == 1 ? 'M. ' : ($tit->idcivilite == 2 || $tit->idcivilite == 3 ? 'Mme. ' : '')) . $tit->prenom . ' ' . $tit->nom . '<br />'; ?></h3>
        		<div class="text-right">
                    <a class="small" href="#" onClick="addEvent();">Effectuer une réservation périodique</a>&nbsp;|&nbsp;
                    <a class="small" href="#" onClick="removeEvent();">Annuler une réservation périodique</a>&nbsp;|&nbsp;
                    <a class="small" href="family.php">Consulter la fiche famille</a>&nbsp;|&nbsp;
                    <a class="small" href="logout.php">Déconnexion</a></div>
            	<!-- p>Inscrits :
    <?php
    	$f=0; $m=0;
    	$inscrits_num = array();
    	foreach ($inscrits as $k => $inscr)
    	{
    		switch ($inscr->idcivilite)
    		{
    			case 1:
    			case 4:
    				echo '<span class="label label-default evt_m' . ++$m . '">' . $inscr->prenom . '</span>&nbsp;';
    				$inscrits_num[$inscr->idindividu] = $m;
    				break;
    			case 2:
    			case 3:
    			case 5:
    				echo '<span class="label label-default evt_f' . ++$f . '">' . $inscr->prenom . '</span>&nbsp;';
    				$inscrits_num[$inscr->idindividu] = $f;
    				break;
    		}
    	}
    ?>
        		</p -->
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-2">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <!-- En XS on utilise un nav -->
                            <nav class="navbar navbar-form navbar-default visible-xs-block">
                                <div class="container-fluid">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <span class="h4">Activités<span>
                                        <a class="navbar-toggle navbar-toggle-epure collapsed" data-toggle="collapse" data-target="#dropdown-activites" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="caret"></span>
                                        </a>
                                    </div>

                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse act-chkbtn-container" id="dropdown-activites">
                                    </div><!-- /.navbar-collapse -->
                                </div><!-- /.container-fluid -->
                            </nav>
                            <!-- En SM, on utilise un panel supérieur -->
                            <div class="panel panel-primary panel-horizontal visible-sm-block">
                                <div class="panel-heading">
                                    <div class="panel-title">Activités</div>
                                </div>
                                <div class="panel-body inline act-chkbtn-container">
                                </div>
                            </div>
                            <!-- En MD ou sup, on utilise un panel sur le côté gauche -->
                            <div class="panel panel-primary visible-md-block visible-lg-block">
                                <div class="panel-heading">
                                    <div class="panel-title">Activités</div>
                                </div>
                                <div class="panel-body act-chkbtn-container">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <!-- En XS on utilise un nav -->
                            <nav class="navbar navbar-form navbar-default visible-xs-block">
                                <div class="container-fluid">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <span class="h4">Inscrits<span>
                                        <a class="navbar-toggle navbar-toggle-epure collapsed" data-toggle="collapse" data-target="#dropdown-inscrits" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="caret"></span>
                                        </a>
                                    </div>

                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse ins-chkbtn-container" id="dropdown-inscrits">
                                    </div><!-- /.navbar-collapse -->
                                </div><!-- /.container-fluid -->
                            </nav>
                            <!-- En SM, on utilise un panel supérieur -->
                            <div class="panel panel-primary panel-horizontal visible-sm-block">
                                <div class="panel-heading">
                                    <div class="panel-title">Inscrits</div>
                                </div>
                                <div class="panel-body inline ins-chkbtn-container">
                                </div>
                            </div>
                            <!-- En MD ou sup, on utilise un panel sur le côté gauche -->
                            <div class="panel panel-primary visible-md-block visible-lg-block">
                                <div class="panel-heading">
                                    <div class="panel-title">Inscrits</div>
                                </div>
                                <div class="panel-body ins-chkbtn-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-10">
                    <div id="calendar"></div>
                </div>
            </div>
            <!--div>
    			<div id="calendar"></div>
    		</div-->
        </div>
    </div> <!-- /container -->
	
    <form>
        <input type="checkbox" id="act-cantine" class="hidden" data-color-class="color1" checked />
        <input type="checkbox" id="act-garderie" class="hidden" data-color-class="color2" checked />
        <input type="checkbox" id="act-coucou0" class="hidden" data-color-class="color3" checked />
        <input type="checkbox" id="act-coucou1" class="hidden" data-color-class="color4" />
        <input type="checkbox" id="act-coucou2" class="hidden" data-color-class="color5" />
        <input type="checkbox" id="act-coucou3" class="hidden" data-color-class="color6" />
        <input type="checkbox" id="act-coucou4" class="hidden" data-color-class="color7" />
        <input type="checkbox" id="ins-antoine" class="hidden" data-color-class="btn-default" checked />
        <input type="checkbox" id="ins-jules" class="hidden" data-color-class="btn-default" checked />
        <input type="checkbox" id="ins-louis" class="hidden" data-color-class="btn-default" checked />
    </form>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>