<?php
session_start();
require "conn.php";
$lrn = $_SESSION["lrn"];
$id = $_GET["ID"];
$userLevel = $_SESSION["userLevel"];

?>
<html>
<head>
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
<body>
	<div class="container">
	<form method="POST" action="group_explore.php?ID=<?php echo $id; ?>">
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>
<div id="navcolor">
	
	<ul class="nav nav-tabs">
	<li role="presentation" class="w3-small "><a href="home.php" style="color:#66757f;"><span class="fa fa-home" aria-hidden="true"></span></a></li>
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
$query1 = mysql_query("SELECT groupID, userID, Fname, Lname, userLRN FROM groupmember INNER JOIN profile ON groupmember.userID=profile.userLRN WHERE groupID='$id' AND userID<>'$lrn' ORDER BY Fname") or die("ERROR QUERY");
	while($rows2 = mysql_fetch_array($query1)){
		if(isset($_POST["$rows2[1]"])){
			header("Refresh: 0, url = delete_member.php?userID=$rows2[1]&&groupID=$id");
	}
}
$query = mysql_query("SELECT * FROM creategroup WHERE ID='$id'") or die("ERROR QUERY");
		while($rows = mysql_fetch_array($query)){
			$name = $rows[1];
		}
		echo "<legend>" . $name;	

		if($userLevel == "faculty"){
?>
<small><a href="group.php"> Back </a></small>
<?php
		}
		if($userLevel == "student"){
?>
<small><a href="group_student.php"> Back </a></small>
<?php
		}
?>
</legend>
<?php
$count = 0;
$query = mysql_query("SELECT groupID, userID, Fname, Lname FROM groupmember INNER JOIN profile ON groupmember.userID=profile.userLRN WHERE groupID='$id'") or die("ERROR QUERY");
$queryAdmin = mysql_query("SELECT groupadminID, Fname, Lname FROM creategroup INNER JOIN profile ON creategroup.groupadminID = profile.userLRN where ID='$id'") or die("ERROR QUERY");

while(mysql_fetch_array($query)){
	$count = $count + 1;
}

echo "Created by ";

if($userLevel == "faculty"){
	echo "you ";
}
if($userLevel == "student"){
	if($rows = mysql_fetch_array($queryAdmin)){
		echo $rows[1] . " " . $rows[2];
	}

}
echo " with <b>$count members</b>. <br><br>";

echo "<h5><a href='addgrouppost.php?ID=$id' style='text-decoration: none;'> Add Post</a> | <a href='group_explore.php?ID=$id' style='text-decoration: none;'> Members List </a></h5>";
$query1 = mysql_query("SELECT groupID, userID, Fname, Lname, userLRN FROM groupmember INNER JOIN profile ON groupmember.userID=profile.userLRN WHERE groupID='$id' AND userID<>'$lrn' ORDER BY Fname") or die("ERROR QUERY");
while($rows = mysql_fetch_array($query1)){
	$querypic = mysql_query("SELECT path FROM profilepic INNER JOIN groupmember ON profilepic.userLRN = groupmember.userID WHERE userLRN='$rows[4]' AND userID<>'$lrn' ORDER BY picID DESC") or die("ERROR QUERY");
	if(mysql_num_rows($querypic) <=0){
	?>
	<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
	<?php
}
else{
if($rows1 = mysql_fetch_array($querypic)){
	$filedir = "images/" . basename($rows1["path"]);
	?>
	<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
	<?php
}
}

echo "<a href='profile_explore.php?userLRN=$rows[4]'>" . $rows[2] . " " . $rows[3] . "</a><br>" ;

$querySelect = mysql_query("SELECT * FROM creategroup WHERE ID='$id' AND groupadminID='$lrn'") or die("ERROR QUERY");
if($rows3 = mysql_fetch_array($querySelect)){
	if($rows3[2] == $lrn){
		echo "<button name='$rows[1]' class='btn btn-danger'><span class='icon icon-remove'></span>Remove</button><br>";
	}
}

}
?>
 <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="assets/scripts.js"></script>
</body>
<html>