<?php
session_start();
$lrn = $_SESSION["lrn"];
$id = $_GET["ID"];
require "conn.php";

$query = mysql_query("SELECT imgpath, dateuploaded, timeuploaded, userLRN FROM picgallery WHERE ID='$id' ORDER BY dateuploaded DESC, timeuploaded DESC") or DIE("ERROR IN QUERY");
					while($rows = mysql_fetch_array($query)){
						$filename = basename($rows[0]);
						$source = "images/".$filename;
?>
<html>
  <head>
    <title>Home</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="assets/styles.css" rel="stylesheet">
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
	  <li role="presentation" class="w3-small"><a href="profile.php" style="color:#66757f;"><span class="fa fa-user" aria-hidden="true"></span></a></li>
	 <li role="presentation" class="w3-small"><a href="connect.php" style="color:#66757f;"><span class="fa fa-heart" aria-hidden="true"></span>
	 <?php
			$querycount = mysql_query("SELECT connectrequest.userID, profile.Fname, profile.Lname FROM connectrequest INNER JOIN profile ON connectrequest.userID = profile.userLRN WHERE connectrequest.requestID='$lrn' AND connectrequest.requeststatus=''") or die("ERROR QUERY");
			$count = 0;
			while($rows1 = mysql_fetch_array($querycount)){
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

<div id="myAlert" class="modal show" style="margin-top: 70px;">
					<div class="modal-header">
						<h4>Photo Info</h4>
					</div>
					<div class="modal-body">
						<center>
						<a href="<?php echo $source; ?>">
						<img class="img-responsive" src="<?php echo $source; ?>" alt="3.jpg" height="150px" width="150px">
						</a>
						<br><br>
						Uploaded: <?php echo $rows["dateuploaded"] . " @ " . $rows["timeuploaded"];?>
						</center>
					</div>
					<div class="modal-footer">
						<a class="btn btn-primary" href="<?php echo $source; ?>">View Full size</a>
						<a class="btn" href="pictures.php">Back to album</a>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="assets/scripts.js"></script>
  </body>
</html>
