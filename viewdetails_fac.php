<?php
session_start();
$lrn = $_SESSION["lrn"];
require "conn.php";

?>
<html>
  <head>
    <title>Profile</title>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="assets/styles.css" rel="stylesheet">
		<link href="css/StyleSheet.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>

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
require "conn.php";
$query = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `profile`.`Mname`, `degree`.`userDegree`, `profile`.`Sex`, `profile`.`Address`, `profile`.`Birthdate`, `profile`.`Contactno`,`profile`.`CivilStatus`, `degree`.`Yearno` FROM `profile` INNER JOIN `degree` ON `profile`.`userLRN` = `degree`.`userLRN` WHERE `profile`.`userLRN`='$lrn'") or die("ERROR QUERY");
if($rowinfo = mysql_fetch_array($query)){
?>
<div class="container">
<form method="post" action="viewdetails.php">
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
		<div id="bg">
		<center>
		<?php
$queryPic = mysql_query("SELECT * FROM profilepic WHERE userLRN='$lrn' ORDER BY dateuploaded DESC, timeuploaded DESC");
if(mysql_num_rows($queryPic) <=0){
	?>
	<img src="images/faceless.jpg" alt="This is an image" style="width: 150px; height: 150px;  border:4px solid #ececec;" class="img-circle"><br><br>
	<?php
}
else{
if($rows = mysql_fetch_array($queryPic)){
	$_SESSION["picID"] = $rows[0];
	$filedir = "images/" . basename($rows["path"]);
	?>
	<br>
	<div class="col-sm-4">
	<center><img src="<?php echo $filedir; ?>" alt="This is an image"  style="width: 150px; height: 150px; border:4px solid #ececec;" class="img-circle"><br><br>
	</div>
	<?php
$picID = $_SESSION["picID"];
}
}
	?>
<h4><?php echo $rowinfo[1] . " " . $rowinfo[3] . " " . $rowinfo[2]; ?></h4>
<h4><?php echo $rowinfo[4]; ?></h4>
		<h5><a href="editdetails_fac.php">Edit Profile</a></h5>
		<br>
		</center>
		</div>
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
											</div>
										<div class="span12">
										<h4>Personal Information</h4>
										<table>
										<tr>
										<td>First Name:</td> 
										<td><span style="color:skyblue;"><?php echo $rowinfo["Fname"];?></span></td>
										</tr>
										<tr>
										<td>Last Name:</td>
										<td><span style="color:skyblue;"><?php echo $rowinfo["Lname"];?></span></td>
										</tr>
										<tr>
										<td>Middle Name: </td>
										<td><span style="color:skyblue;"><?php echo $rowinfo["Mname"];?></span></td>
										</tr>
										<tr>
										<td>Birthdate: </td>
										<td><span style="color:skyblue;"><?php echo $rowinfo["Birthdate"];?></span></td>
										</tr>
										<tr>
										<td>Sex: </td>
										<td><span style="color:skyblue;"><?php echo $rowinfo["Sex"];?></span></td>
										</tr>
										<tr>
										<td>Address:</td>
										<td><span style="color:skyblue;"><?php echo $rowinfo["Address"];?></span></td>
										</tr>
										<tr>
										<td>Civil Status:</td>
										<td><span style="color:skyblue;"><?php echo $rowinfo["CivilStatus"];?></span></td>
										</tr>
										</table>
										</div>
										<div class="span12">
										<h4>School Information</h4>
										<table>
										<tr>
										<td>Department: </td>
										<td><span style="color:skyblue;"><?php echo $rowinfo["userDegree"]; }?></span></td>
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
        <script src="assets/scripts.js"></script>
  </body>
</html>