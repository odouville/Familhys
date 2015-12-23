<?php

if (isset($_GET['q']))
{
	include('config.php');
	echo $cfg['timeout_session'];
}

setcookie('ka', time());

?>
