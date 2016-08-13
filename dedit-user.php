<?php
	// Start the session
	session_start();
	$lrn = $_SESSION["lrn"];
	$id = $_GET["userLRN"];
	require "conn.php";
?>
<!DOCTYPE html>
<html>
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
	<?php
	require "conn.php";
	$fnameErr = $lnameErr = $mnameErr = $contactErr = $genderErr = $bdateErr = $addErr = $civilErr = "";
	$degErr =  $yearErr = "";
	$fname = $lname = $mname = $contact = $gender = $bdate = $addr = $civil = "";
	$deg =  $year = "";
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		 if(empty($_POST["fname"])){
			 $fnameErr="First name is required.";
		 }
		 else{
			 $fname=test_input($_POST["fname"]);
		 }
		 if(empty($_POST["mname"])){
			 $mnameErr="Middle name is required.";
		 }
		 else{
			 $mname=test_input($_POST["mname"]);
		 }
		 if(empty($_POST["lname"])){
			 $lnameErr="Last name is required.";
		 }
		 else{
			 $lname=test_input($_POST["lname"]);
		 }
		 if(empty($_POST["gender"])){
			 $genderErr="Gender is required.";
		 }
		 else{
			 $gender=test_input($_POST["gender"]);
		 }
		 if(empty($_POST["contactnum"])){
			 $contactErr="Contact is required.";
		 }
		 else{
			 $contact=test_input($_POST["contactnum"]);
		 }
		  if(empty($_POST["currentAdd"])){
			 $addErr="Address is required.";
		 }
		 else{
			 $addr=test_input($_POST["currentAdd"]);
		 }
		  if(empty($_POST["bdate"])){
			 $bdateErr="Birthdate is required.";
		 }
		 else{
			 $bdate=test_input($_POST["bdate"]);
		 }
		 if(empty($_POST["civil"])){
			 $civilErr="Civil Status is required.";
		 }
		 else{
			 $civil=test_input($_POST["civil"]);
		 }
		 if(empty($_POST["degree"])){
			 $degErr="Degree is required.";
		 }
		 else{
			 $deg=test_input($_POST["degree"]);
		 }
		 if(empty($_POST["yearno"])){
			 $yearErr="Year is required.";
		 }
		 else{
			 $year=test_input($_POST["yearno"]);
		 }
	 }
	 function test_input($data){
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 return $data; 
	 }
	$bdate=date_create("$bdate");
	$bdate=date_format($bdate,"Y-m-d");
	
	?>
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
		
		<br clear=both>
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
                
<?php
require "conn.php";
$query = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `profile`.`Mname`, `degree`.`userDegree`, `profile`.`Sex`, `profile`.`Address`, `profile`.`Birthdate`, `profile`.`Contactno`,`profile`.`CivilStatus`, `degree`.`Yearno` FROM `profile` INNER JOIN `degree` ON `profile`.`userLRN` = `degree`.`userLRN` WHERE `profile`.`userLRN`='$id'") or die("ERROR QUERY");
echo $lrn;
if($rowinfo = mysql_fetch_array($query)){
?>
<div class="container">
<form method="post" action="dedit-user.php?userLRN=<?php  echo $id; ?>">
		 <div class="span9" id="content">
						<?php if(isset($_POST["btnSave"])){
	if(!empty($_POST["fname"]) && !empty($_POST["mname"]) && !empty($_POST["lname"])){
		if(!empty($_POST["gender"]) && !empty($_POST["currentAdd"]) && !empty($_POST["bdate"])){
			if(!empty($_POST["civil"])){
				if(!empty($_POST["degree"]) && !empty($_POST["contactnum"])){
					$query = mysql_query("UPDATE profile SET Fname='$fname', Lname='$lname', Mname='$mname', Sex='$gender', Address='$addr', Birthdate='$bdate', Contactno='$contact', CivilStatus='$civil' WHERE userLRN='$id'") or die("ERROR QUERY");
					$query1 = mysql_query("UPDATE degree SET userDegree='$deg' WHERE userLRN='$id'") or die("ERROR QUERY");
					echo "<div class='alert alert-success'>";
					echo "<button type='button' class='close' data-dismiss='alert'>&times</button>";
					echo "User information Successfully Updated.";
					echo "</div>";
}}}}}?>
					<div class="row-fluid">
					 <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Details</div>
                            </div>
							
                            <div class="block-content collapse in">
                                <div class="span12">
								<div>
									<a href="dmanage-user.php" class="btn"><i class="icon-arrow-left"></i> Back</a>
									<button class="btn btn-primary" name="btnSave"><i class="icon-check"></i> SAVE</button>
								</div>
										<div class="span12">
										<h4>Personal Information</h4>
										<table>
										<tr>
										<td>First Name:</td> 
										<td><input type="text" name="fname" class="form-control" value="<?php echo $rowinfo["Fname"];?>"></span></td>
										</tr>
										<tr>
										<td>Last Name:</td>
										<td><input type="text" name="lname" class="form-control" value="<?php echo $rowinfo["Lname"];?>"></span></td>
										</tr>
										<tr>
										<td>Middle Name: </td>
										<td><input type="text" name="mname" class="form-control" value="<?php echo $rowinfo["Mname"];?>"></span></td>
										</tr>
										<tr>
										<td>Birthdate: </td>
										<td><input type="date" name="bdate" class="form-control" value="<?php echo $rowinfo["Birthdate"];?>"></span></td>
										</tr>
										<tr>
										<td>Sex: </td>
										<td>
											<div class="controls">
												<select name="gender">
													<option value="Male" <?php if($rowinfo["Sex"] == "Male"){ echo "selected"; } ?>>Male</option>
													<option value="Female" <?php if($rowinfo["Sex"] == "Female"){ echo "selected"; } ?>>Female</option>
												</select>
											</div>
										</td>
										</tr>
										<tr>
										<td>Address:</td>
										<td><input type="text" name="currentAdd" class="form-control" value="<?php echo $rowinfo["Address"];?>"></span></td>
										</tr>
										<tr>
										<td>Contact Number:</td>
										<td><input type="text" name="contactnum" class="form-control" value="<?php echo $rowinfo["Contactno"];?>"></span></td>
										</tr>
										<tr>
										<td>Civil Status:</td>
										<td>
										<select name="civil">
						<option value="Single" <?php if($civil == "Single"){ echo "selected";} ?>>Single</option>
						<option value="Married" <?php if($civil == "Married"){ echo "selected";} ?>>Married</option>
						<option value="Widow" <?php if($civil == "Widow"){ echo "selected";} ?>>Widowed</option>
						<option value="Divorce" <?php if($civil == "Divorce"){ echo "selected";} ?>>Divorced</option>
					</select></td>
										</table>
										</div>
										<div class="span12">
										<h4>School Information</h4>
										<table>
										<tr>
										<td>Department: </td>
										<td>
										<div class="controls">
								<select name="degree">
									<option value="AB English Language" <?php if($rowinfo["userDegree"] == "AB English Language"){ echo "selected";} ?>>AB English Language</option>
									<option value="BS Elementary Education" <?php if($rowinfo["userDegree"] == "BS Elementary Education"){ echo "selected";} ?>>BS Elementary Education</option>
									<option value="BS Architecture" <?php if($rowinfo["userDegree"] == "BS Architecture"){ echo "selected";} ?>>BS Architecture</option>
									<option value="BS Civil Engineering" <?php if($rowinfo["userDegree"] == "BS Civil Engineering"){ echo "selected";} ?> >BS Civil Engineering</option>
									<option value="BS Computer Enginering" <?php if($rowinfo["userDegree"] == "BS Computer Enginering"){ echo "selected";} ?>>BS Computer Engineering</option>
									<option value="BS Secondary Education" <?php if($rowinfo["userDegree"] == "BS Secondary Education"){ echo "selected";} ?>>BS Secondary Education</option>
									<option value="BS Electrical Engineering"<?php if($rowinfo["userDegree"] == "BS Electrical Engineering"){ echo "selected";} ?>>BS Electrical Engineering</option>
									<option value="BS Information Technology" <?php if($rowinfo["userDegree"] == "BS Information Technology"){ echo "selected";} ?>>BS Information Technology</option>
									<option value="BS Mechanical Engineering" <?php if($rowinfo["userDegree"] == "BS Mechanical Engineering"){ echo "selected";} }?>>BS Mechanical Engineering</option>
								</select>
							</div>
									</tr>
										</table>
										</div>
										</div>
                                </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
	</div>
	</form>					
                                </div>
                           	
        <!--/.fluid-container-->
        <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
    </body>
</html>