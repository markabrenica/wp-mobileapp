<?php
session_start();
require "conn.php";
?>
<html>
  <head>
    <title>Login Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="assets/styles.css" rel="stylesheet">
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
if(isset($_POST["btnYes"])){
	$username= $_POST["username"];
	$pw= $_POST["password"];
	$sql= "SELECT * FROM users WHERE username='".$username."' AND password='".$pw."'";
	$result = mysql_query($sql) or die("ERROR QUERY");

	if(mysql_num_rows($result)>0){
		while($row = mysql_fetch_array($result)){	
			$_SESSION["userLevel"]= $row["userLevel"];
			$_SESSION["lrn"] = $row["userLRN"];
			$id = $row["userLRN"];
			$dept = mysql_query("SELECT userDegree FROM degree WHERE userLRN='$id'") or die("ERROR QUERY");
			while($rows1 = mysql_fetch_array($dept)){
				$_SESSION["department"] = $rows1[0];
			}
			echo("<script>location.href='home.php';</script>");
			if($_SESSION["userLevel"]=="admin"){
				echo("<script>location.href='admin-panel.php';</script>");
			}
			}
}
	else{
		echo "<script> swal('Error!', 'Invalid username and password!', 'error');</script>";
	}
	}
?>
    <div class="container">
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>
	<div class="se-pre-con"></div>
	<form id="form-login" class="form-signin"  style="padding-top: 20px;" method="post" action="index.php">
        <center><h4 class="form-signin-heading">Please Sign in to Continue</h4>
		<label>Does not have an account? <a href="Signup.php">Sign-up here.</a></center></br>
</label>
		<input type="text" name="username" required class="input-block-level" placeholder="Username*">
		<input type="password"  name="password" required class="input-block-level" placeholder="Password*">
		<center>
		<button class="btn btn-default" name="btnYes">Login</button>
		<input class="btn btn-medium btn-primary" type="reset" value="Clear" />
		<span>*Required</span></center>
		
      </form>
    </div>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="assets/scripts.js"></script>
	<script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
		<script>
			$('#submit-data').click(function(){
			$('#form-login').submit();
			});	
	</script>

  </body>
</html>