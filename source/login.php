<?php

session_start();

if (isset($_SESSION['login']) && isset($_SESSION['pwd']))
{
	header('Location: index.php');
	exit();
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
	<!--link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"-->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/login.css">
    
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!--script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script-->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<script type="text/javascript" src="http://crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/sha1.js"></script>
	<script type="text/javascript" src="http://crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/hmac-sha1.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
  </head>

  <body>

    <div class="container">
        <form class="form-signin" id="login_form" name="login_form" method="post" action="#" onsubmit="return false;">
        <div class="panel panel-primary panel-login">
        <div class="panel-heading"><h2>Connectez-vous</h2></div>
        <div class="panel-body">
        <label for="log" class="sr-only">Identifiant</label>
        <input type="text" name="log" id="log" class="form-control" placeholder="Identifiant famille" required autofocus value="<?php if (isset($_COOKIE['lg'])) echo $_COOKIE['lg']; ?>" />
        <label for="pwd" class="sr-only">Mot de passe</label>
        <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Mot de passe" required />
        <div class="error" name="message" id="message" style="display:none;"></div>
        <div class="checkbox">
            <label>
            <input type="checkbox" name="remember-me" id="remember-me" <?php if (!isset($_COOKIE['rmb']) || $_COOKIE['rmb'] == 1) echo 'checked'; ?> /> Garder ma session ouverte
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
        </div>
        </div>
        </form>
</div> <!-- /container -->
	
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <form id="real_form" name="real_form" method="post" action="index.php">
    	<input type="hidden" id="login" name="login" required>
    	<input type="hidden" id="encpwd" name="encpwd" required>
    	<input type="hidden" id="remember" name="remember" required>
    </form>
  </body>
</html>