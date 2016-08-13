<?php
session_start();
$lrn = $_SESSION["lrn"];
$commentID= $_GET['ID'];
require "conn.php";

?>
<html>
 <head>
    <title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="assets/styles.css" rel="stylesheet">
	<script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
 	 <link rel="stylesheet" media="screen" href="http://www.w3schools.com/lib/w3.css">
	<link rel="stylesheet" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  
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
echo "<form action=\"\" method=\"POST\">";

$query= mysql_query("SELECT ID, commentcontent, datecommented, timecommented,userID, Fname, Lname FROM commentgroup INNER JOIN profile ON commentgroup.userID = profile.userLRN WHERE ID=".$commentID."");
while($rows = mysql_fetch_array($query)){
	$_SESSION["exploreProfile"] = $rows["userID"];
	$exploreLRN = $_SESSION["exploreProfile"];		
?>
<div class="well">
<div style="width: 100%;">

	<?php
			$querypic = mysql_query("SELECT * FROM displaypic RIGHT JOIN profile ON displaypic.userID=profile.userLRN WHERE userID='$exploreLRN'") or die("ERROR QUERY");
				if($rowspic = mysql_fetch_array($querypic)){
						$filedir = "images/" . basename($rowspic[1]);
						?>
						<p><img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					if(mysql_num_rows($querypic) == 0){
						?>
						<p><img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
?>		
<b><font color="#00679b"><?php 
	echo "<a href=\"profile_explore.php?userLRN=$exploreLRN\">" . $rows[5] . " " . $rows[6] . " </a></font></b><font color='a599ae' size='2'>@ " . $rows[2] . " " . $rows[3] . "</font><br>";
	echo $rows[1] . "<br>";
	echo "<br/><hr>";
	?>
	<input type="hidden" name="postno" value="<?php echo $commentID; $_SESSION["commentID"] = $commentID;?>">
	<?php
	$query1 = mysql_query("SELECT replycontent, datereplied, timereplied, Fname, Lname, reply_group.ID, profile.userLRN   FROM reply_group INNER JOIN profile on profile.userLRN=reply_group.userID WHERE commentID='$commentID'") or die("ERROR QUERY");
	while($rows = mysql_fetch_array($query1)){
		$_SESSION["exploreProfile"] = $rows["userLRN"];
		$exploreLRN = $_SESSION["exploreProfile"];	
		$_SESSION["ID"] = $rows["ID"];
		$replyID= $_SESSION["ID"];
?>
<div class="well">
<?php
			$querypic = mysql_query("SELECT * FROM displaypic RIGHT JOIN profile ON displaypic.userID=profile.userLRN WHERE userID='$exploreLRN'") or die("ERROR QUERY");
				if($rowspic = mysql_fetch_array($querypic)){
						$filedir = "images/" . basename($rowspic[1]);
						?>
						<p><img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					if(mysql_num_rows($querypic) == 0){
						?>
						<p><img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
						}
		echo "<font color='#00679b'><b>";
		echo "<a href=\"profile_explore.php?userLRN=$exploreLRN\">" . $rows[3] . " " . $rows[4] . " </a></b></font><font color='a599ae' size='2'>@ " . $rows[1] . " " . $rows[2] . "</font><br>";
		echo $rows[0];
		echo "<br>";
		if($rows[6] == $lrn){
			echo "<a href='deletereply_group.php?ID=$replyID'>Delete Reply</a></div>";
		}
	}
?>

</div>
<center>
<textarea name="replycontent" rows="3" style="width: 80%"></textarea>
<input type="submit" name="reply" class="btn btn-medium btn-info" value="REPLY">
</center>
</div>
</fieldset>
</form>
<?php
}
if(isset($_POST["reply"])){
	$commentID = $_POST["postno"];
	$reply = $_POST["replycontent"];
	date_default_timezone_set("Asia/Manila");
	$datereplied = date("F j, Y");
	$timereplied = date("h:i:s a");
	$replyquery = mysql_query("INSERT INTO reply_group (replycontent, datereplied, timereplied, commentID, userID) VALUES('$reply','$datereplied', '$timereplied','$commentID', '$lrn')") or die("ERROR QUERY");
	echo("<script>location.href='reply_group.php?ID=$commentID';</script>");
}
?>
</html>
</body>
