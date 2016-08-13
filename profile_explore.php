<?php
session_start();
$lrn = $_SESSION["lrn"];
$explorelrn = $_GET["userLRN"];
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
$querySelect = mysql_query("SELECT * FROM post");
while($rows = mysql_fetch_array($querySelect)){
		$_SESSION["postID"] = $rows[0];
}
?>
<div class="container">
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
	<div id="bg">
		<center>
		<!----------PROFILE PICTURE------------>
<hr>
<?php
$queryPic = mysql_query("SELECT * FROM profilepic WHERE userLRN='$explorelrn' ORDER BY picID DESC");
if(mysql_num_rows($queryPic) <=0){
	?>
	<img src="images/faceless.jpg" alt="This is an image" style="width: 150px; height: 150px; border:4px solid #ececec;" class="img-circle"><br>
	<?php
}
else{
if($rows = mysql_fetch_array($queryPic)){
	$_SESSION["picID"] = $rows[0];
	$filedir = "images/" . basename($rows["path"]);
	?>
	<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 150px; height: 150px; border:4px solid #ececec;" class="img-circle"><br>
	<?php
$picID = $_SESSION["picID"];
}
}
$query = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `profile`.`Mname`, `degree`.`userDegree` FROM `profile` INNER JOIN `degree` ON `profile`.`userLRN` = `degree`.`userLRN` WHERE `profile`.`userLRN`='$explorelrn'") or die("ERROR QUERY");
if($rowsprofile = mysql_fetch_array($query)){
	?>
<h4><br><?php echo "<span style=\"font-size:20px; font-weight:bold\">"; 
echo $rowsprofile[1] . " " . $rowsprofile[3] . " " . $rowsprofile[2]; echo "</span>";?></h4>
<h5><?php echo $rowsprofile[4]; } ?></h5>

<?php
$queryselect = mysql_query("SELECT * FROM connected WHERE userID='$lrn' AND connectedID='$explorelrn'") or die("ERROR QUERY");
if(mysql_num_rows($queryselect) > 0){
					//continue;
				}
				else{
					if($lrn <> $explorelrn){ 
?>
		<h6><a href="insertconnected.php?ID=<?php echo $explorelrn; ?>"> Connect </a> | 
<?php
}
}
?>
		<a href="viewdetails_explore.php?userLRN=<?php echo $explorelrn; ?>"> View more details </a></h6><br>
		</center></center>
		</div>
		
		<hr>
		<form id="form-login" method="post" action="profile_explore.php">
		<fieldset><legend>Recent Posts</legend>
		<?php
		$query1 = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `post`.`content`, `post`.`dateposted`, `post`.`timeposted`, `post`.`ID`  FROM `profile` INNER JOIN `post` ON `profile`.`userLRN` = `post`.`userLRN` WHERE `profile`.`userLRN`='$explorelrn'  ORDER BY `post`.`ID` DESC") or die("ERROR QUERY");
		if(mysql_num_rows($query1)<=0){
	echo "<div class='well'><p>No post on this profile.</p></div>";
}
else{
		while($rowspost = mysql_fetch_array($query1)){
			$_SESSION["exploreProfile"] = $rows["userLRN"];
			$exploreLRN = $_SESSION["exploreProfile"];	
			$_SESSION["postID"] = $rowspost["ID"];
			$_SESSION["seemoreID"] = $rowspost["ID"];
		?>
		<div class="well"> 
			<p>
			<?php
			$querypic = mysql_query("SELECT * FROM displaypic RIGHT JOIN profile ON displaypic.userID=profile.userLRN WHERE userID='$exploreLRN'") or die("ERROR QUERY");
				if($rowspic = mysql_fetch_array($querypic)){
						$filedir = "images/" . basename($rowspic[1]);
						?>
						<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					if(mysql_num_rows($querypic) == 0){
						?>
						<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					
?>
	   <b><font color="#00679b"><?php echo $rowspost[1] . " " . $rowspost[2] . " </font></b> <font color='a599ae' size='2'>@ " . $rowspost[4] . " " . $rowspost[5]; ?></p></font>
		<p>
		<?php
		$string = $rowspost[3];
		$seemoreID = $_SESSION["seemoreID"];
		if(strlen($string) > 250){
			$trimstring = substr($string, 0, 250) . '<a href="viewreply.php?ID='.$seemoreID.'" style="text-decoration: none; font-weight: italic;">Read more</a>';
		}
		else{
			$trimstring = $string;
		}
		echo $trimstring . "</font><br>"; 
		?> 
		</p>
		<hr>
	    <div class="btn-group" role="group" aria-label="buttongroup">
		<a href="viewreply.php?ID=<?php $id = $_SESSION["postID"]; echo $id; ?>" data-toggle="modal" class="btn btn-default"><span class="icon-comment" aria-hidden="true"></span> 
		<?php
		$countquery = mysql_query("SELECT * FROM comments WHERE postID='$id'");
		$count = 0;
		while($rowscount = mysql_fetch_array($countquery)){
			$count = $count + 1;
		}echo $count;
		?> Comments</a>
		</div>
		</div>
		<?php
		}
}
		?>
		</fieldset>
	</div>
	</form>
	    <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="assets/scripts.js"></script>
  </body>
</html>