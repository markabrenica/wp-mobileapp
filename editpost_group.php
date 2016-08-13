<?php
session_start();
$lrn= $_SESSION["lrn"];
$postID = $_GET["ID"];
$id = $_SESSION['grouppostID'];
require "conn.php";
?>
<html>
<title> </title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="assets/styles.css" rel="stylesheet">
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
	<div class="container">
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>
	<div id="navcolor">
	<ul class="nav nav-tabs">
	  <li role="presentation" class="w3-small"><a href="home.php" style="color:#66757f;"><span class="fa fa-home" aria-hidden="true"></span></a></li>
	  <li role="presentation" class="w3-medium"><a href="profile.php" style="color:#66757f;"><span class="fa fa-user" aria-hidden="true"></span></a></li>
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
	     <li role="presentation" class="w3-medium"><a href="department.php" style="color:#66757f;"><span class="fa fa-building" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-small"><a href="announcement.php" style="color:#66757f;"><span class="fa fa-list-alt" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-small"><a href="search.php" style="color:#66757f;"><span class="fa fa-search" aria-hidden="true"></span></a></li>
	</ul>
	</div>
	<div class="se-pre-con"></div>
	<p id="ID" hidden> <?php echo $id; ?> </p>
<?php
if(isset($_POST["save"])){
	$content = $_POST["postcontent"];
	$query = mysql_query("UPDATE grouppost SET content='$content' WHERE ID='$postID'");
	?>
<script>
	var num = "";
	num = document.getElementById("ID").value;

	swal({
    title: "Confirmation",
    text: "Your post has been successfully updated!",
    type: "success",
    confirmButtonColor: 'skyblue',
    confirmButtonText: 'OKAY',
    closeOnConfirm: false,
  },
  function(isConfirm){
    if (isConfirm){
    	location.href = 'addgrouppost.php?ID=' + document.getElementById("ID").innerHTML;
    }
  });

</script>
<?php
}
if(!isset($_POST["save"])){
$query= mysql_query("SELECT ID, content, dateposted, timeposted, userID, Fname, Lname FROM grouppost INNER JOIN profile ON grouppost.userID = profile.userLRN WHERE grouppost.ID='$postID'");
while($rows = mysql_fetch_array($query)){
?>
<form action="" method="POST">
</br>
<div class="well">
<b><font color='#00679b'><?php 
	echo $rows[5] . " " . $rows[6] . " </font></b><font color='a599ae' size='2'>@ " . $rows[2] . " " . $rows[3] . "<br>"; 
	?></font>
<div>
		<textarea name="postcontent" rows="5" style="width: 90%;"><?php echo $rows[1];} ?></textarea>
		<input type="submit" name="save" class="btn btn-medium btn-info" value="SAVE">
	</div>
<br>
</div>
</form>
<?php
}
?>
</body>
</html>