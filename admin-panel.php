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
                        <li class="active">
                            <a href="admin-panel.php"><i class="icon-chevron-right"></i> Dashboard</a>
                        </li>
                        <li>
                            <a class="not-active" href="#"><span class="badge badge-info pull-right"></span> Users</a>
                        </li>
						<li>
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
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<h4>Welcome Administrator,</h4>
							You have successfully login into the System.
						</div>
					</div>
					
<?php
require "conn.php";
		mysql_select_db("psuconnect", $con);
		$result = mysql_query("SELECT COUNT(LRN) from userlrn");
		$row = mysql_fetch_array($result);
		
		$result1 = mysql_query("SELECT COUNT(userLRN) from profile");
		$row1 = mysql_fetch_array($result1);
		
		$result2 = mysql_query("SELECT COUNT(ID) from post");
		$row2 = mysql_fetch_array($result2);
		
$u=$row[0];
$u1=$row1[0];
$per=0;
$per=($u1/$u)*100;


$tposte=0;
$poste=$row2[0];
$tposte=($u1/$poste)*100;


?>
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Statistics</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span4">
                                    <div class="chart" data-percent="<?php $per ?>"><?php echo intval($per) ?>%</div>
                                    <div class="chart-bottom-heading"><span class="label label-info">Users</span>

                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="chart" data-percent="<?php $tposte ?>"><?php echo intval($tposte) ?>%</div>
                                    <div class="chart-bottom-heading"><span class="label label-info">Posts</span>

                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="chart" data-percent="83">83%</div>
                                    <div class="chart-bottom-heading"><span class="label label-info">Blocked Users</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>	
				
					<div class="row-fluid">
                        <div class="span12">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Users</div>
                                    <div class="pull-right"><span class="badge badge-info"></span>
                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID Number</th>
                                                <th>First Name</th>
												<th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
	<?php
	require "conn.php";
		mysql_select_db("psuconnect", $con);
		$result = mysql_query("SELECT userLRN, FName, MName, LName, Address FROM Profile ORDER BY FName");
		while($row = mysql_fetch_array($result)) {
												echo "<tr>
                                                <td>" . $row["userLRN"]. "</td>
                                                <td>" . $row["FName"]. "</td>
                                                <td>" . $row["MName"]. "</td>
												<td>" . $row["LName"]. "</td>
                                                <td>" . $row["Address"]. "</td>";
												}
												// some code
												mysql_close($con);
?>
                                        </tbody>
                                    </table>
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
		 <script>
        $(function() {
            // Easy pie charts
            $('.chart').easyPieChart({animate: 1000});
        });
        </script>
    </body>
</html>	