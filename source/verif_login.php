<?php

include_once('config.php');

// Recherche de session éventuellement démarrée
session_start();

$verify_login = false;

// On regarde d'abord si un utilisateur tente d'établir une nouvelle connexion (s'il a rempli le formulaire de connexion)
if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['encpwd']) && !empty($_POST['encpwd']))
{
	// On a tenté un nouveau login, on réinitialise donc la session
	include('clear_login.php');
	
	$login = $_POST['login'];
	$encpwd = $_POST['encpwd'];
	$verify_login = true;
	
	if (isset($_POST['remember']) && is_numeric($_POST['remember']) && $_POST['remember'] == 1)
		setcookie('rmb', 1);
	else
		setcookie('rmb', 0);
}
else if (!isset($_SESSION['login']) || !isset($_SESSION['encpwd']))
{
	// En l'absence d'informations de connexion au niveau de la session, on vérifie les cookies,
	// au cas où l'utilisateur aurait déjà été connecté et où il aurait indiqué vouloir rester connecté 
	if (isset($_COOKIE['lg']) && !empty($_COOKIE['lg']) && isset($_COOKIE['ep']) && !empty($_COOKIE['ep']))
	{
		$login = $_COOKIE['lg'];
		$encpwd = $_COOKIE['ep'];
		$verify_login = true;
	}
}
// Si une session est déjà ouverte, on vérifie s'il faut procéder à une déconnexion pour inactivité
else
{
	// On vérifie que l'utilisateur n'a pas demandé à rester connecté
	if (!isset($_COOKIE['rmb']) || !is_numeric($_COOKIE['rmb']) || $_COOKIE['rmb'] != 1)
	{
		// Si c'est bien le cas, on s'intéresse au timestamp de keepalive qui est rafraîchi automatiquement toutes les 30 secondes
		if (isset($_COOKIE['ka']) && is_numeric($_COOKIE['ka']))
		{
			// On travaille sur des timestamps Unix, donc en secondes
			// Une fois toutes les pages du site fermées sur le client, on déconnecte l'utilisateur au bout de 300 secondes
			if (time() - $_COOKIE['ka'] > $cfg['timeout_session'])
			{
				include('clear_login.php');
			}
		}
	}
}

// Si des données de connexion ont été trouvées, on les vérifie, en appelant l'API
if ($verify_login)
{
	include_once('restclient.php');

	// Appel du webservice ReST
	$rest = $api->post(
		'http://localhost/rest/login/',
		array('login' => $login, 'encpwd' => $encpwd)
	);
	
	// Traitement de la réponse
	if ($rest->info->http_code === 200)
	{
		$json = $rest->decode_response();
		
		// On enregistre les infos dans la session
		if (!isset($_SESSION)) session_start();
		$_SESSION['login'] = $login;
		$_SESSION['encpwd'] = $encpwd;
		$_SESSION['idfamille'] = $json->idfamille;
		
		// Si cela est demandé, on enregistre les infos dans les cookies
		// (l'identifiant famille, lui, sera chargé à nouveau à la prochaine connexion)
		setcookie('lg', $login);
		setcookie('ep', $encpwd);
	}
}

?>