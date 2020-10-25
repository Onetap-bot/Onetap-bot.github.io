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
* [logout.php]
*    Logout
*/

session_start();
error_reporting(0);
require('../app/config.php');

$_SESSION["auth"] = null;

header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/auth.php', true, 301 );
exit();


?>