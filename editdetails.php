<?php
session_start();
$lrn = $_SESSION["lrn"];
require "conn.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="assets/styles.css" rel="stylesheet">
		<link href="css/StyleSheet.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

	 	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="sweetalert-master/dist/sweetalert-dev.js"></script>
		<link rel="stylesheet" href="sweetalert-master/dist/sweetalert.css">

		<style>
		.no-js #loader { display: none;  }
		.js #loader { display: block; position: absolute; left: 100px; top: 0; }
		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(loader/Preloader_2.gif) center no-repeat #fff;
		}
		</style>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
		<script>
			$(window).load(function() {
				$(".se-pre-con").fadeOut("slow");;
			});
		</script>

  </head>
<body id="login">
<?php
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
			 $fname = mysql_real_escape_string($fname);
		 }
		 if(empty($_POST["mname"])){
			 $mnameErr="Middle name is required.";
		 }
		 else{
			 $mname=test_input($_POST["mname"]);
			 $mname = mysql_real_escape_string($mname);
		 }
		 if(empty($_POST["lname"])){
			 $lnameErr="Last name is required.";
		 }
		 else{
			 $lname=test_input($_POST["lname"]);
			 $lname = mysql_real_escape_string($lname);
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
			 $contact = mysql_real_escape_string($contact);
		 }
		  if(empty($_POST["currentAdd"])){
			 $addErr="Address is required.";
		 }
		 else{
			 $addr=test_input($_POST["currentAdd"]);
			 $addr = mysql_real_escape_string($addr);
		 }
		  if(empty($_POST["bdate"])){
			 $bdateErr="Birthdate is required.";
		 }
		 else{
			 $bdate=test_input($_POST["bdate"]);
			 $bdate = mysql_real_escape_string($bdate);
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
	
$query = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `profile`.`Mname`, `degree`.`userDegree`, `profile`.`Sex`, `profile`.`Address`, `profile`.`Birthdate`, `profile`.`Contactno`,`profile`.`CivilStatus`, `degree`.`Yearno` FROM `profile` INNER JOIN `degree` ON `profile`.`userLRN` = `degree`.`userLRN` WHERE `profile`.`userLRN`='$lrn'") or die("ERROR QUERY");
if($rowinfo = mysql_fetch_array($query)){
?>
<div class="container">
<form method="post" action="editdetails.php">
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>

	<div id="navcolor">
	<ul class="nav nav-tabs">
	  <li role="presentation" class="w3-small"><a href="home.php" style="color:#66757f;"><span class="fa fa-home" aria-hidden="true"></span></a></li>
	  <li role="presentation" class="w3-small"><a href="profile.php" style="color:#66757f;"><span class="fa fa-user" aria-hidden="true"></span></a></li>
	 <li role="presentation" class="w3-small"><a href="connect.php" style="color:#66757f;"><span class="fa fa-heart" aria-hidden="true"></span>
	 <?php
			$querycount = mysql_query("SELECT connectrequest.userID, profile.Fname, profile.Lname FROM connectrequest INNER JOIN profile ON connectrequest.userID = profile.userLRN WHERE connectrequest.requestID='$lrn' AND connectrequest.requeststatus=''") or die("ERROR QUERY");
			$count = 0;
			while($rows = mysql_fetch_array($querycount)){
				$count = $count + 1;
			}
			if($count > 0){
				?>
				<span class="badge badge-success pull-right"> <?php echo $count; } ?></span></a>
</li>
<li role="presentation" class="w3-small"><a href="message.php" style="color:#66757f;"><span class="fa fa-envelope" aria-hidden="true"></span></a></li>
	   <li role="presentation" class="w3-small"><a href="pictures.php" style="color:#66757f;"><span class="fa fa-photo" aria-hidden="true"></span></a></li>
	     <li role="presentation" class="w3-small"><a href="department.php" style="color:#66757f;"><span class="fa fa-building" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-small"><a href="announcement.php" style="color:#66757f;"><span class="fa fa-list-alt" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-small"><a href="search.php" style="color:#66757f;"><span class="fa fa-search" aria-hidden="true"></span></a></li>
	</ul>
	</div>
	<div class="se-pre-con"></div>
	<?php
	if(isset($_POST["btnSave"])){
	if(!empty($_POST["fname"]) && !empty($_POST["mname"]) && !empty($_POST["lname"])){
		if(!empty($_POST["gender"]) && !empty($_POST["currentAdd"]) && !empty($_POST["bdate"])){
			if(is_numeric($_POST["yearno"]) && !empty($_POST["yearno"]) && !empty($_POST["civil"])){
				if(!empty($_POST["degree"]) && !empty($_POST["contactnum"])){
					$query = mysql_query("UPDATE profile SET Fname='$fname', Lname='$lname', Mname='$mname', Sex='$gender', Address='$addr', Birthdate='$bdate', Contactno='$contact', CivilStatus='$civil' WHERE userLRN='$lrn'") or die("ERROR QUERY");
					$query1 = mysql_query("UPDATE degree SET userDegree='$deg', Yearno='$year' WHERE userLRN='$lrn'") or die("ERROR QUERY");
					?>
				<script>
					swal({
				    title: "Success!",
				    text: "User information successfully updated!",
				    type: "success",
				    confirmButtonColor: 'skyblue',
				    confirmButtonText: 'Yes',
				    closeOnConfirm: false,
				  },
				  function(isConfirm){
				    if (isConfirm){
				    	location.href = 'editdetails.php';
				    }
				  });
				</script>
				<?php
}}}}}
	?>
	
		<div id="bg">
		<center>
		<?php
$queryPic = mysql_query("SELECT * FROM displaypic WHERE userID='$lrn'");
if(mysql_num_rows($queryPic) <=0){
	?>
	<img src="images/faceless.jpg" alt="This is an image"  style="width: 150px; height: 150px; border:4px solid #ececec;" class="img-circle"><br><br>
	<?php
}
else{
if($rows = mysql_fetch_array($queryPic)){
	$_SESSION["picID"] = $rows[1];
	$filedir = "images/" . basename($rows["picpath"]);
	?>
	<br>
	<div class="col-sm-4">
	<center><img src="<?php echo $filedir; ?>" alt="This is an image"  style="width: 150px; height: 150px;  border:4px solid #ececec;" class="img-circle"><br><br>
	</div>
	<?php
$picID = $_SESSION["picID"];
}
}
	?>
<h4><?php echo $rowinfo[1] . " " . $rowinfo[3] . " " . $rowinfo[2]; ?></h4>
<h4><?php echo $rowinfo[4]; ?></h4>
		<h5><a href="viewdetails.php">View Profile</a></h5>
		</center>
		<hr>
		 <div class="span12" id="content">
                     <div class="row-fluid">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Details</div>
                            </div>
							
                            <div class="block-content collapse in">
                                <div class="span12">
								<div>
									<a href="profile.php" class="btn"><i class="icon-arrow-left"></i> Back</a>
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
										<td>Degree: </td>
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
									<option value="BS Mechanical Engineering" <?php if($rowinfo["userDegree"] == "BS Mechanical Engineering"){ echo "selected";} ?>>BS Mechanical Engineering</option>
								</select>
							</div>
									</tr>
										<tr>
										<td>Year:</td>
										<td><input type="text" name="yearno" class="form-control" value="<?php echo $rowinfo["Yearno"]; }?>"></span></td>
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
            <hr>
	</div>
	</form>

	    <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
  </body>
</html>