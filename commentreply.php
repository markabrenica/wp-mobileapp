<?php
session_start();
$lrn = $_SESSION["lrn"];
$id= $_GET['ID'];
require "conn.php";
?>
<html>
 <head>
    <title>Home</title>
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
<body>
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>
	<div class="se-pre-con"></div>
	<fieldset><legend>Comments</legend>
<?php
echo "<form action=\"\" method=\"POST\">";
$query= mysql_query("SELECT ID, content, dateposted, timeposted, post.userLRN, Fname, Lname FROM post INNER JOIN profile ON post.userLRN = profile.userLRN WHERE ID=".$id."");

while($rows = mysql_fetch_array($query)){
?>
<div style="width: 100%;">
<?php 
	echo $rows[5] . " " . $rows[6] . " @ " . $rows[2] . " " . $rows[3] . "<br>"; 
	echo $rows[1] . "<br>";
	echo "<a href='profile.php'>Back</a><br>";
	?>
	<input type="hidden" name="postno" value="<?php echo $id; $_SESSION["id"] = $id;?>">
	<?php
	$query1 = mysql_query("SELECT commentcontent, datecommented, timecommented, Fname, Lname  FROM comments INNER JOIN profile on profile.userLRN=profile.userLRN WHERE ID='$id'") or die("ERROR QUERY");
	while($rows = mysql_fetch_array($query1)){
		$_SESSION["replyID"] = $rows["replyID"];
		$replyID= $_SESSION["replyID"]
		echo "<fieldset><div style=\"width: 90%; margin: 5px;\">";
		echo $rows[3] . " " . $rows[4] . " @ " . $rows[1] . " " . $rows[2] . "<br>";
		echo $rows[0] . " <br> ";
		echo "<a href='deletecomment.php?replyID=$replyID'>Delete Comment</a>";
		echo "<br></div></fieldset><hr>";
	}
?>
<textarea name="replycontent" rows="3" style="width: 90%"></textarea>
<input type="submit" name="reply" value="REPLY">
</div>
</fieldset>
</form>
<?php
}
if(isset($_POST["reply"])){
	$postID = $_POST["postno"];
	$reply = $_POST["replycontent"];
	date_default_timezone_set("Asia/Manila");
	$dateposted = date("F j, Y");
	$timeposted = date("h:i:s a");
	$replyquery = mysql_query("INSERT INTO comments (commentcontent, datecommented, timecommented, postID, userLRN) VALUES('$reply','$datereplied', '$timereplied','$postID', '$lrn')") or die("ERROR QUERY");
	header("Refresh: 0, url=commentreply.php?postID=$postID");
	echo "<script> alert ('Your reply will be posted.')</script>";
}
?>
</html>
</body>
