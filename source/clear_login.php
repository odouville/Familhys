<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// On efface simplement les informations de connexion au niveau de la session
unset($_SESSION['login']);
unset($_SESSION['encpwd']);
session_destroy();

// Ainsi qu'au niveau des cookies
// On supprime le login des cookies seulement si l'utilisateur ne veut pas rester connecté
if (!isset($_COOKIE['rmb']) || !is_numeric($_COOKIE['rmb']) || $_COOKIE['rmb'] == 0)
	setcookie ('lg', '', time() - 3600);
// Dans tous les cas, on supprime le cookie du mot de passe
setcookie ('ep', '', time() - 3600);

?>