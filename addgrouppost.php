<?php
session_start();
$lrn = $_SESSION["lrn"];
$id = $_GET["ID"];
$userLevel = $_SESSION["userLevel"];
require "conn.php";
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
	<form method="POST" action="addgrouppost.php?ID=<?php echo $id; ?>">
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
if(isset($_POST["btnPOST"])){
	if(empty($_POST["grouppostcontent"])){
		echo "<script> swal('Warning!', 'It looks like you are posting a empty post! Plese type anything anything first!', 'warning');</script>";
	}
	else{
		$content = mysql_real_escape_string($_POST["grouppostcontent"]);
		date_default_timezone_set("Asia/Manila");
		$dateposted = date("F j, Y");
		$timeposted = date("h:i:s a");
		$queryInsert = mysql_query("INSERT INTO grouppost(content, dateposted, timeposted, groupID, userID) VALUES('$content','$dateposted','$timeposted', '$id', '$lrn')") or die("ERROR QUERY");
		echo "<script> swal('Success!', 'Your post has been successfully posted!', 'success');</script>";
	}	
}
$query = mysql_query("SELECT * FROM creategroup WHERE ID='$id'") or die("ERROR QUERY");
		while($rows = mysql_fetch_array($query)){
			$name = $rows[1];
		}
		echo "<legend>" . $name;

		if($userLevel == "faculty"){
?>
<small><a href="group.php"> Back </a> </small>
<?php
		}
		if($userLevel == "student"){
?>
<small><a href="group_student.php"> Back </a> </small>
<?php
		}
?>
</legend>
<input type="hidden" name="tbID" value="<?php echo $id; $_SESSION['grouppostID'] = $id; ?>">
</h3>
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
echo " with <b>$count members</b>. <br>";
echo "<h5><a href='addgrouppost.php?ID=$id'>Add Post</a> | <a href='group_explore.php?ID=$id'>Members List</a></h5>";

?>
<textarea style="min-width: 100%;" rows="4" class="form-control" name="grouppostcontent"></textarea>	
<button class="btn btn-primary" name="btnPOST">POST</button>
<input type="reset" class="btn" value="CLEAR">
<hr>	

<fieldset><legend>Recent Posts</legend>
<?php
$query = mysql_query("SELECT content, dateposted, timeposted,userID, Fname, Lname, grouppost.ID, profile.userLRN FROM grouppost INNER JOIN profile ON grouppost.userID=profile.userLRN WHERE groupID='$id' ORDER BY ID DESC") OR die("ERROR QUERY");
if(mysql_num_rows($query) <=0){
	?>
<div class="well">
	    <p><b>
		<p><font size="2">
			There are no new posts.
		</p></font>
		<hr>
	<?php
}
else{
while($rowspost = mysql_fetch_array($query)){
	$_SESSION["postID"] = $rowspost["ID"];
	$_SESSION["seemoreID"] = $rowspost["ID"];
	?>
	<div class="well">
	    <p><b><font color="#00679b"><?php echo $rowspost[4] . " " . $rowspost[5] . " </font></b> <font color='a599ae' size='2'>@ " . $rowspost[1] . " " . $rowspost[2]; ?></p></font>
		<p><font size="2">
		<?php
		$string = $rowspost[0];
		$seemoreID = $_SESSION["seemoreID"];
		if(strlen($string) > 250){
			$trimstring = substr($string, 0, 250) . '<a href="viewreply_group.php?ID='.$seemoreID.'" style="text-decoration: none; font-weight: italic;">Read more</a>';
		}
		else{
			$trimstring = $string;
		}
		echo $trimstring . "</font><br>"; 
		?> 
		</p></font>
		<hr>
	    <div class="btn-group" role="group" aria-label="buttongroup">
		<a href="viewreply_group.php?ID=<?php echo $seemoreID; ?>" style="text-decoration: none; font-weight: italic;" class="btn btn-default"><span class="icon-comment" aria-hidden="true"></span> 
		<?php
		$id = $_SESSION["postID"] ;
		$countquery = mysql_query("SELECT * FROM commentgroup WHERE postID='$id'");
		$count = 0;
		while($rowscount = mysql_fetch_array($countquery)){
			$count = $count + 1;
		}echo $count;
		?></a>

		<?php
					if($rowspost[7] == $lrn){
						?>
						<a href="editpost_group.php?ID=<?php $id = $_SESSION["postID"]; echo $id; ?>" data-toggle="modal" class="btn btn-default"><span class="icon-edit" aria-hidden="true"></span> </a>
						<a href="deletepost_group.php?postID=<?php $id = $_SESSION["postID"]; echo $id; ?>" data-toggle="modal" class="btn btn-default"><span class="icon-trash" aria-hidden="true"></span> </a>
		<?php
					}
		?>
		</div>
		</div>
		<?php
}
}
?>

</fieldset>
 <script src="vendors/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="assets/scripts.js"></script>
</body>
<html>