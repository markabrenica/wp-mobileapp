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
<form action="dview.php" method="POST">
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
						<li class="active">
                            <a class="left-gap" href="dmanage-user.php"><i class="icon-chevron-right"></i> Manage User</a>
                        </li>
						<li>
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
                                    <div class="muted pull-left">User Details</div>
                                    <div class="pull-right"><span class="badge badge-info"></span>
                                    </div>
                                </div>
                                <div class="block-content collapse in">
								<span class="span7">
								<a href="dmanage-user.php" class="btn" style="margin-bottom:5px;"><i class="icon-arrow-left"></i> Back</a>
								<table class="table">
                                        <tbody>
	<?php
	require "conn.php";
	$id = $_GET["userLRN"];
		mysql_select_db("psuconnect", $con);
		$result = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `profile`.`Mname`, `degree`.`userDegree`, `profile`.`Sex`, `profile`.`Address`, `profile`.`Birthdate`, `profile`.`Contactno`,`profile`.`CivilStatus`, `degree`.`Yearno` FROM `profile` INNER JOIN `degree` ON `profile`.`userLRN` = `degree`.`userLRN` WHERE `profile`.`userLRN`='$id'") or die("ERROR QUERY");
		while($row = mysql_fetch_array($result)) {
												echo "
												<tr><td><b>Personal Information</b></td><td></td></tr>
												<tr><td>ID</td><td>" . $row["userLRN"]. "</td></tr>
                                                <tr><td>Name</td><td>" . $row["Fname"] . " " . $row["Mname"] . " " . $row["Lname"]. "</td></tr>
                                                <tr><td>Sex</td><td>" . $row["Sex"]. "</td></tr>
												<tr><td>Address</td><td>" . $row["Address"]. "</td></tr>
                                                <tr><td>Contact Number</td><td>" . $row["Contactno"]. "</td>
												<tr><td>Civil Status</td><td>" . $row["CivilStatus"]. "</td>
												<tr><td><b>School Information</b></td><td></td></tr>
												<tr><td>Year</td><td>" . $row["Yearno"]. "</td>
												<tr><td>Degree</td><td>" . $row["userDegree"]. "</td>
												</tr>";
												}
												
												mysql_close($con);
?>
                                        </tbody>
                                    </table>
									</span>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
		</form>

        <!--/.fluid-container-->
        <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
    </body>
</html>