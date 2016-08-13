<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Create Account</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="assets/styles.css" rel="stylesheet">
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
        <link rel="stylesheet" href="sweetalert-master/example/example.css">
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
        <script type="text/Javascript">
			function try1(){
				location.href='Signup.php';
			}
			function try2(){
				location.href='Signup_fac.php';
			}
		</script>
</head>
<body>
<?php
require "conn.php";

	$lrnErr = $fnameErr = $lnameErr = $mnameErr = $contactErr = $genderErr = $bdateErr = $addErr = $civilErr = "";
	$degErr =  $yearErr = $blockErr = $usernameErr = $passwordErr = "";
	$lrn = $fname = $lname = $mname = $contact = $gender = $bdate = $addr = $civil = "";
	$deg =  $year = $block = $username = $password = "";
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		 if(empty($_POST["lrn"])){
			 $lrnErr="ID Number is required.";
		 }
		 else{
			 $lrn=test_input($_POST["lrn"]);
		 }
		 
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
			 $genderErr="Sex is required.";
		 }
		 else{
			 $gender=test_input($_POST["gender"]);
		 }
		 if(empty($_POST["contact"])){
			 $contactErr="Contact is required.";
		 }
		 else{
			 $contact=test_input($_POST["contact"]);
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
		 if(empty($_POST["year"])){
			 $yearErr="Year is required.";
		 }
		 else{
			 $year=test_input($_POST["year"]);
		 }
		 if(empty($_POST["username"])){
			 $usernameErr="Username is required.";
		 }
		 else{
			 $username=test_input($_POST["username"]);
		 }
		 if(empty($_POST["password"])){
			 $passwordErr="Password is required.";
		 }
		 else{
			 $password=test_input($_POST["password"]);
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
	
 if(isset($_POST["btnADD"])){
	require "conn.php";
	if(!empty($_POST["lrn"]) && !empty($_POST["fname"]) && !empty($_POST["mname"]) && !empty($_POST["lname"])){
				if(!empty($_POST["gender"]) && !empty($_POST["contact"]) && !empty($_POST["currentAdd"]) && !empty($_POST["bdate"])){
					if(!empty($_POST["year"]) && !empty($_POST["civil"])){
						if(!empty($_POST["degree"]) && !empty($_POST["username"]) && !empty($_POST["password"])){
	//INSERT TO DATABASE
	//USER INFORMATION AND USER ACCOUNT
		$checkLRN = mysql_query("SELECT * FROM userLRN WHERE LRN='".$lrn."'") or die("ERROR QUERY");
		$checkUsername = mysql_query("SELECT * FROM users WHERE username='".$username."'") or die("ERROR QUERY");
		if(mysql_num_rows($checkLRN)>0){
			$checkuser = mysql_query("SELECT * FROM users WHERE userLRN='".$lrn."'") or die("ERROR QUERY");
			if(mysql_num_rows($checkuser)>0){
				echo "<script> swal('Ooops...','It looks like the ID number you entered is already taken!','error'); </script>";
			}
			else if(mysql_num_rows($checkUsername)>0){
				echo "<script> swal('Ooops...','It looks like the username you entered is already taken!','error'); </script>";
			}
			else{
$insertAccount = mysql_query("INSERT INTO users(username, password, userlevel, userLRN) VALUES('$username', '$password', 'student', '$lrn')") or die("ERROR QUERY");
$insertProfile = mysql_query("INSERT INTO profile(userLRN, Fname, Lname,Mname,Sex,Address, Birthdate,Contactno, CivilStatus) VALUES('$lrn','$fname', '$lname', '$mname', '$gender', '$addr','$bdate','$contact','$civil')") or die("ERROR QUERY");
$insertDegree = mysql_query("INSERT INTO degree(userDegree, Yearno, userLRN) VALUES('$deg','$year','$lrn')") or die("ERROR QUERY");
?>
<script>
	swal({
    title: "Success!",
    text: "Your account has been successfuly created!",
    type: "success",
    confirmButtonColor: 'skyblue',
    confirmButtonText: 'OKAY',
    closeOnConfirm: false,
  },
  function(isConfirm){
    if (isConfirm){
    	location.href = 'index.php';
    }
  });

</script>
<?php
			}
		}
		else{
			echo "<script> swal('Ooops...','The ID number you entered do not match any of our data!','error'); </script>";
 }}}}}}
 
?>
<div class="container">
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>
	<div class="se-pre-con"></div>
<h4 align="center" class="style1">Create Your Account</h4>
<center>
Already have an account? <a href="index.php">Login here.</a>
</center>
<div class="center_box_content">
	
	<form id="form1" name="form1" method="post" action="Signup.php">
	 <div>
	 	<br>
	 	<center>
	 	<!-----------POSITION CHECK-------->
	 	<input type="radio" name="gender" value="Student" onclick="try1()" checked>Student
		<input type="radio" name="gender" value="Fac" onclick="try2()" >Faculty / Staff
		<!-----------END POSITION CHECK--------></center>
		<h4>General Information</h4>
		<div class="form-group">
		<label class="control-label">ID Number<span class="required">*</span></label>
		<input type="text" class="form-control" id="lrn" name="lrn" value="<?php echo $lrn; ?>" placeholder="<?php echo " " . $lrnErr; ?>"/>
		
		<label class="control-label">First Name<span class="required">*</span></label></td>
		<input type="text" class="form-control"  id="firstname" value="<?php echo $fname; ?>" name="fname" placeholder="<?php echo $fnameErr; ?>"/>
			
		<label class="control-label">Middle Name<span class="required">*</span></label></td>
		<input type="text" class="form-control" id="middlename" name="mname" value="<?php echo $mname; ?>" placeholder="<?php echo $mnameErr; ?>"/>
			
			<label class="control-label">Last Name<span class="required">*</span></label>
					<input type="text" class="form-control" id="lastname" name="lname" value="<?php echo $lname; ?>" placeholder="<?php echo $lnameErr; ?>"/>
					<label class="control-label">Sex<span class="required">*</span></label>
							<div class="controls">
								<select name="gender">
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
					<label class="control-label">Contact Number<span class="required">*</span></label>
					<input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" placeholder="<?php echo $contactErr; ?>"/>
					
					<label class="control-label">Address<span class="required">*</span></label>
					<input type="text" id="currentAdd" name="currentAdd" value="<?php echo $addr; ?>" placeholder="<?php echo $addErr; ?>"/>
					
					<label class="control-label">Birthdate<span class="required">*</span></label>
					<input type="date" placeholder="MM/DD/YY" name="bdate" class="datepicker" id="bdate" value="<?php echo $bdate; ?>" placeholder="<?php echo $bdateErr; ?>"/>
					
					<label class="control-label">Civil Status<span class="required">*</span></label>
					<select name="civil">
						<option value="Single" <?php if($civil == "Single"){ echo "selected";} ?>>Single</option>
						<option value="Married" <?php if($civil == "Married"){ echo "selected";} ?>>Married</option>
						<option value="Widow" <?php if($civil == "Widow"){ echo "selected";} ?>>Widowed</option>
						<option value="Divorce" <?php if($civil == "Divorce"){ echo "selected";} ?>>Divorced</option>
					</select>
					<label class="control-label">Program<span class="required">*</span></label>
							<div class="controls">
								<select name="degree">
									<option value="">-Select your degree-</option>
									<option value="AB English Language" <?php if($deg == "AB English Language"){ echo "selected";}?>>AB English Language</option>
									<option value="BS Elementary Education" <?php if($deg == "BS Elementary Education"){ echo "selected";}?>>BS Elementary Education</option>
									<option value="BS Architecture" <?php if($deg == "BS Architecture"){ echo "selected";}?>>BS Architecture</option>
									<option value="BS Civil Engineering" <?php if($deg == "BS Civil Engineering"){ echo "selected";}?>>BS Civil Engineering</option>
									<option value="BS Computer Engineering" <?php if($deg == "BS Computer Engineering"){ echo "selected";}?>>BS Computer Engineering</option>
									<option value="BS Secondary Education" <?php if($deg == "BS Secondary Education"){ echo "selected";}?>>BS Secondary Education</option>
									<option value="BS Electrical Engineering" <?php if($deg == "BS Electrical Engineering"){ echo "selected";}?>>BS Electrical Engineering</option>
									<option value="BS Information Technology" <?php if($deg == "BS Information Technology"){ echo "selected";}?>>BS Information Technology</option>
									<option value="BS Mechanical Engineering" <?php if($deg == "BS Mechanical Engineering"){ echo "selected";}?>>BS Mechanical Engineering</option>
								</select>
							</div>
							
					<label class="control-label">Year Level<span class="required">*</span></label>
					<select name="year"> <span class="error" style="color:red;"><?php echo $yearErr; ?> </span>
						<option value="">-Select your year level-</option>
						<option value="1" <?php if($year == "1"){ echo "selected";}?>>1</option>
						<option value="2" <?php if($year == "2"){ echo "selected";}?>>2</option>
						<option value="3" <?php if($year == "3"){ echo "selected";}?>>3</option>
						<option value="4" <?php if($year == "4"){ echo "selected";}?>>4</option>
						<option value="5" <?php if($year == "5"){ echo "selected";}?>>5</option>
					</select>
				</table>
				<br clear=both>
				<hr>
				<h4>Login Information</h4>
				<table style="margin-left: 100px; cell-padding: 50px;">
						<label class="control-label">Username<span class="required">*</span></label></td>
						<input type="text" id="username" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $usernameErr; ?>"/>
						
						<label class="control-label">Password<span class="required">*</span></label>
						<input type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $passwordErr; ?>"/>				
			</div>
		
	</div>
	</div>
	<br clear=both><br clear=both>
	<center>
    <input type="submit" value="Add User and Save" class="btn btn-primary" name="btnADD"> 
	<a href='index.php' class="btn btn-default">Clear</a>
	</center>
	</form>
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/scripts.js"></script>
	<script src="vendors/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#contact").keydown(function(event){
				if(event.keyCode == 46 || event.keyCode == 8){

				}
				else{
					if(event.keyCode < 48 || event.keyCode > 57){
						event.preventDefault();
					}
				}
			});
		});
	</script>
</body>
</html>
