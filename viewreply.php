<?php
session_start();
require "conn.php";
$lrn = $_SESSION["lrn"];
$postID= $_GET['ID'];
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
	</ul></div>
	<div class="se-pre-con"></div>

<?php
echo "<form action=\"\" method=\"POST\">";

$query= mysql_query("SELECT ID, content, dateposted, timeposted, post.userLRN, Fname, Lname FROM post INNER JOIN profile ON post.userLRN = profile.userLRN WHERE ID=".$postID."");
while($rows1 = mysql_fetch_array($query)){
$_SESSION["exploreProfile"] = $rows1["userLRN"];
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

<b><font color="#00679b">
<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>">
<?php
	echo $rows1[5] . " " . $rows1[6] . "</a></font></b><font color='a599ae' size='2'>@ " . $rows1[2] . " " . $rows1[3] . "</font><br>";
	echo $rows1[1] . "<br>";
	echo "<hr>";
	?>
	<input type="hidden" name="postno" value="<?php echo $postID; $_SESSION["postID"] = $postID;?>">
<?php
	$query1 = mysql_query("SELECT commentcontent, datecommented, timecommented, Fname, Lname, comments.ID, profile.userLRN FROM comments INNER JOIN profile on profile.userLRN=comments.userLRN WHERE postID='$postID'") or die("ERROR QUERY");
	while($rows = mysql_fetch_array($query1)){
		$_SESSION["exploreProfile"] = $rows["userLRN"];
		$exploreLRN = $_SESSION["exploreProfile"];	
		$_SESSION["ID"] = $rows["ID"];
		$id = $_SESSION["ID"];
		$replyID = $_SESSION["ID"];
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
					
		echo "<font color='#00679b'><b><a href=\"profile_explore.php?userLRN=$exploreLRN\">";
		echo $rows[3]." ".$rows[4]."</a></b></font><font color='a599ae' size='2'> @ ".$rows[1]." ".$rows[2]."</font><br>";
		echo $rows[0] . " <br> ";
		$count = 0;
		$querycountreply = mysql_query("SELECT replycontent, datereplied, timereplied, Fname, Lname, reply.ID  FROM reply INNER JOIN profile on profile.userLRN=reply.userLRN WHERE commentID='$id' ORDER BY commentID") or die("ERROR QUERY");
		while($rows = mysql_fetch_array($querycountreply)){
			$count = $count + 1;
		}
		echo "<i>" . $count . " Replies </i><br>";
		echo "<a href='reply.php?ID=$replyID'>Reply</a> ";

		if($lrn == $rows1["userLRN"]){
echo "| <a href='deletecomment.php?ID=$replyID'>Delete Comment</a>";
		
		}
		echo "</div>";
	}
?>
</div>
<center>
<textarea name="replycontent" rows="3" style="width: 80%"></textarea>
<input type="submit" name="reply" class="btn btn-medium btn-info" value="REPLY">
</center>
</div>
<?php
}
if(isset($_POST["reply"])){
	echo "Posting...";
	$postID = $_POST["postno"];
	$reply = mysql_real_escape_string($_POST["replycontent"]);
	date_default_timezone_set("Asia/Manila");
	$datereplied = date("F j, Y");
	$timereplied = date("h:i:s a");
	$replyquery = mysql_query("INSERT INTO comments (commentcontent, datecommented, timecommented, postID, userLRN) VALUES('$reply','$datereplied', '$timereplied','$postID', '$lrn')") or die("ERROR QUERY");
	echo("<script>location.href='viewreply.php?ID=$postID';</script>");

}
?>
</form>
</body>
</html>