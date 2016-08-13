<?php
	// Start the session
	session_start();
	require "conn.php";
?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <title>Admin Home Page</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Admin Panel</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> Administrator <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
								<li>
                                        <a tabindex="-1" href="admin-panel.php">Go back to Admin Panel</a>
                                    </li>
									<li>
                                        <a tabindex="-1" href="index.php">Login</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="logout.php">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                       
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
		
		<br clear=both><br clear=both><br clear=both>
		
		
		
		
		
		
		
		
		
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li>
                            <a href="admin-panel.php"><i class="icon-chevron-right"></i> Dashboard</a>
                        </li>
                        <li>
                            <a class="not-active" href="#"><span class="badge badge-info pull-right"></span> Users</a>
                        </li>
						<li>
                            <a class="left-gap" href="dmanage-user.php"><i class="icon-chevron-right"></i> Manage User</a>
                        </li>
						<li  class="active">
                            <a class="left-gap" href="dmanage-theme.php"><i class="icon-chevron-right"></i> Manage Theme</a>
                        </li>
                    </ul>
                </div>
                
                <!--/span-->
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <div class="span12">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Themes</div>
                                    <div class="pull-right"><span class="badge badge-info"></span>
                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!--/.fluid-container-->
        <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
    </body>
</html>