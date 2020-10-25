<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><? echo $pageName; ?> - Arkei</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="css/app.min.css" rel="stylesheet" type="text/css" />
	
	<link href="css/vendor/toastr.min.css" rel="stylesheet" type="text/css">
</head>
<body>
	<header id="topnav">
		<nav class="navbar-custom">
			<div class="container-fluid">
				<ul class="list-unstyled topbar-right-menu float-right mb-0">

                        <li class="dropdown notification-list">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>


                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                
                                <small class="pro-user-name ml-1">
                                    <? echo $_SESSION["user"]; ?>
                                </small>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome, <? echo $_SESSION["user"]; ?></h6>
                                </div>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="logout.php" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
							<a href="dashboard.php" class="logo" style="margin-right: 30px;" >
								<span class="logo-lg">
									<img src="assets/images/logo.png" alt="" height="30">
								</span>
								<span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="28">
                                </span>
							</a>
                        </li>
						
						<script>
							function submit_handler(form)
							{
								document.getElementById('search').submit(); return false;
								return false;
							}
						</script>
						
                        <li class="app-search">
                            <form id="search" method="GET" action="search.php" onsubmit="return submit_handler(this)">
                                <input type="text" name="q" placeholder="Search..." class="form-control">
                                <button type="submit" class="sr-only"></button>
                            </form>
                        </li>
                    </ul>
                </div>

            </nav>
			
            <div class="topbar-menu">
                <div class="container-fluid">
                    <div id="navigation">
						<ul class="navigation-menu">
                            <li class="has-submenu">
                                <a href="dashboard.php">
                                    <i class="fe-activity"></i>Dashboard</a>
                            </li>
							
							<?
							
							if($userProfile == "0")
							{
								?>
								<li class="has-submenu">
									<a href="profiles.php">
										<i class="mdi mdi-library-books"></i>Profiles</a>
								</li>
								<?
							}
							
							?>
							
							<li class="has-submenu">
                                <a href="loader.php">
                                    <i class="mdi mdi-upload-multiple"></i>Loader</a>
                            </li>
							
							<?
							
							if($userProfile == "0")
							{
								?>
								<li class="has-submenu">
									<a href="users.php">
										<i class="fe-users"></i>Users</a>
								</li>
								<?
							}
							
							?>
							
							<li class="has-submenu">
                                <a href="presets.php">
                                    <i class="fe-hard-drive"></i>Presets</a>
                            </li>

							<li class="has-submenu">
                                <a href="converter.php">
                                    <i class="fe-edit"></i>Cookies Conveter</a>
                            </li>
							
							<?
							
							if($userProfile == "0")
							{
								?>
								<li class="has-submenu">
									<a href="exporter.php">
										<i class="fe-download"></i>Export</a>
								</li>
								
								<li class="has-submenu">
									<a href="settings.php">
										<i class="fe-settings"></i>Settings</a>
								</li>
								<?
							}
							
							?>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </header>