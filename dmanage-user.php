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
<form action="dmanage-user.php" method="POST">
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
                                    <div class="muted pull-left">Users</div>
                                    <div class="pull-right"><span class="badge badge-info"></span>
                                    </div>
                                </div>
                                <div class="block-content collapse in">
								Search by:
								<select name="optionsx">
									<option name="idn" value="ID Number">ID Number</option>
									<option name="fn" value="First Name">First Name</option>
									<option name="ln" value="Last Name">Last Name</option>
									<option name="add" value="Address">Address</option>
								</select>
								<input type="text" name="search">
								<input type="submit" class="btn btn-default" name="buttonSearch" value="Search">
								
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
		$result = mysql_query("SELECT userLRN, Fname, Mname, Lname, Address FROM profile");
		while($row = mysql_fetch_array($result)) {
												echo "<tr>
                                                <td>" . $row["userLRN"]. "</td>
                                                <td>" . $row["Fname"]. "</td>
                                                <td>" . $row["Mname"]. "</td>
												<td>" . $row["Lname"]. "</td>
                                                <td>" . $row["Address"]. "</td>
												<td><a href='dedit-user.php?userLRN=".$row["userLRN"]."'><i class='icon-pencil'></i> Edit User</a>  <a href='dview.php?userLRN=".$row["userLRN"]."'><i class='icon-eye-open'></i> View Details</a></td></tr>";
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
		

<?php

if(isset($_POST["buttonSearch"])){
	search();
}
if(isset($_POST["btnEdit"])){
	
}
?>


<?php
function search(){?>
<div class="modal-dialog">
 <div class="modal-content">
 <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal">&times;</button>
 <h4 class="modal-title">Result</h4>
 </div>
 <form action="dsearch.php" method="POST">
 <div class="modal-body">
 	<?php 
	echo "<div class='col-sm-12'><table class='table table-stripped table-bordered'>
	<thead>
	<td> ID Number </td>
	<td> First Name </td>
	<td> Middle Name </td>
	<td> Last Name </td>
	<td> Address </td>
	</thead><tbody>";
	require "conn.php";
		mysql_select_db("psuconnect", $con);
		$tex=$_POST['search'];
		if($_POST["optionsx"]=="ID Number"){
			$result1 = mysql_query("SELECT userLRN, Fname, Mname, Lname, Address FROM profile WHERE userLRN LIKE '$tex%'");
		while($row = mysql_fetch_array($result1)) {
												echo "<tr>
                                                <td>" . $row["userLRN"]. "</td>
                                                <td>" . $row["Fname"]. "</td>
                                                <td>" . $row["Mname"]. "</td>
												<td>" . $row["Lname"]. "</td>
                                                <td>" . $row["Address"]. "</td>
												<td><a href='dedit-user.php?userLRN=".$row["userLRN"]."'><i class='icon-pencil'></i> Edit User</a> | <a href='dview.php?userLRN=".$row["userLRN"]."'><i class='icon-eye-open'></i> View Details</a></td></tr>";
			}
		}
		if($_POST["optionsx"]=="First Name"){
			$result1 = mysql_query("SELECT userLRN, Fname, Mname, Lname, Address FROM profile WHERE Fname LIKE '$tex%'");
		while($row = mysql_fetch_array($result1)) {
												echo "<tr>
                                                <td>" . $row["userLRN"]. "</td>
                                                <td>" . $row["Fname"]. "</td>
                                                <td>" . $row["Mname"]. "</td>
												<td>" . $row["Lname"]. "</td>
                                                <td>" . $row["Address"]. "</td>
												<td><a href='dedit-user.php?userLRN=".$row["userLRN"]."'><i class='icon-pencil'></i> Edit User</a> | <a href='dview.php?userLRN=".$row["userLRN"]."'><i class='icon-eye-open'></i> View Details</a></td></tr>";
			}
		}
		if($_POST["optionsx"]=="Last Name"){
			$result1 = mysql_query("SELECT userLRN, Fname, Mname, Lname, Address FROM profile WHERE Lname LIKE '$tex%'");
		while($row = mysql_fetch_array($result1)) {
												echo "<tr>
                                                <td>" . $row["userLRN"]. "</td>
                                                <td>" . $row["Fname"]. "</td>
                                                <td>" . $row["Mname"]. "</td>
												<td>" . $row["Lname"]. "</td>
                                                <td>" . $row["Address"]. "</td>
												<td><a href='dedit-user.php?userLRN=".$row["userLRN"]."'><i class='icon-pencil'></i> Edit User</a> | <a href='dview.php?userLRN=".$row["userLRN"]."'><i class='icon-eye-open'></i> View Details</a></td></tr>";
			}
		}
		if($_POST["optionsx"]=="Address"){
			$result1 = mysql_query("SELECT userLRN, Fname, Mname, Lname, Address FROM profile WHERE Address LIKE '$tex%'");
		while($row = mysql_fetch_array($result1)) {
												echo "<tr>
                                                <td>" . $row["userLRN"]. "</td>
                                                <td>" . $row["Fname"]. "</td>
                                                <td>" . $row["Mname"]. "</td>
												<td>" . $row["Lname"]. "</td>
                                                <td>" . $row["Address"]. "</td>
												<td><a href='dedit-user.php?userLRN=".$row["userLRN"]."'><i class='icon-pencil'></i> Edit User</a> | <a href='dview.php?userLRN=".$row["userLRN"]."'><i class='icon-eye-open'></i> View Details</a></td></tr>";
			}
		}
echo "</table></div>
 <div class=\"modal-footer\">
 <a href=\"dmanage-user.php\" class=\"btn btn-danger\">Close</a></form>
 </div>
 </div>
 </div>
</div>";
} ?>
</form>
        <!--/.fluid-container-->
        <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
    </body>
</html>