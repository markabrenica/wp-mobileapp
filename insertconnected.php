<?php
session_start();
$lrn = $_SESSION["lrn"];
$userID = $_SESSION["lrn"];
$requestID = $_GET["ID"];
require "conn.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Profile</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" media="screen" href="http://www.w3schools.com/lib/w3.css">
	<link rel="stylesheet" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">

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
  </head>
<body>
<div class="container">
 <div style='padding-top: 0px;'>
    <div class="page-header">
    <h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
    </div>
  </div>
<div id="navcolor">
	<ul class="nav nav-tabs">
		<li role="presentation" class="w3-small"><a href="home.php" style="color:#66757f;"><span class="fa fa-home" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-small "><a href="profile.php" style="color:#66757f;"><span class="fa fa-user" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-medium"><a href="connect.php" style="color:#66757f;"><span class="fa fa-heart" aria-hidden="true"></span>
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
$queryselect = mysql_query("SELECT * FROM connectrequest WHERE userID='$userID' AND requestID='$requestID'") or die("ERROR QUERY");
if(mysql_num_rows($queryselect) > 0){
	?>
<script>
	swal({
    title: "Warning!",
    text: "You have already sent a request to this person!",
    type: "warning",
    confirmButtonColor: 'skyblue',
    confirmButtonText: 'OKAY',
    closeOnConfirm: false,
  },
  function(isConfirm){
    if (isConfirm){
    	location.href = 'connect.php';
    }
  });

</script>
<?php
}
else{
	$query = mysql_query("INSERT INTO connectrequest(userID, requestID, requeststatus) VALUES('$userID', '$requestID', '')") or die("ERROR QUERY");
?>
<script>
	swal({
    title: "Success!",
    text: "Request sent!",
    type: "success",
    confirmButtonColor: 'skyblue',
    confirmButtonText: 'OKAY',
    closeOnConfirm: false,
  },
  function(isConfirm){
    if (isConfirm){
    	location.href = 'connect.php';
    }
  });

</script>
<?php
}
?>
</div>
</body>
</html>