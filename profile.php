<?php
session_start();
require "conn.php";
$lrn = $_SESSION["lrn"];
$userLevel = $_SESSION["userLevel"];
$department = $_SESSION["department"];
?>
<html>
  <head>
    <title>Profile</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="assets/styles.css" rel="stylesheet">
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
        <link href="css/StyleSheet.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">

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
$querySelect = mysql_query("SELECT * FROM post");
while($rows = mysql_fetch_array($querySelect)){
		$_SESSION["postID"] = $rows[0];
	}
if(isset($_POST["btnPOST"])){
	$content = mysql_real_escape_string($_POST["content"]);	
	date_default_timezone_set("Asia/Manila");
	$dateposted = date("F j, Y");
	$timeposted = date("h:i:s a");
	if(empty($_POST["content"])){
		echo "<script> swal('Error!', 'Your post appears to be blank! Please type anything first', 'error');</script>";
	}
	else{
		if($userLevel == "student"){
		$queryAddpost = mysql_query("INSERT INTO post(content, dateposted, timeposted, userLRN) VALUES('$content', '$dateposted', '$timeposted', '$lrn')");
			echo "<script> swal('Success!', 'Your post has been successfully posted!', 'success');</script>";
		}
		else{
			if(!empty($_POST["confirm"])){
			if($_POST["confirm"] == "Yes"){
				$queryAdd = mysql_query("INSERT INTO announcement(content, dateposted, timeposted, userLRN) VALUES('$content', '$dateposted', '$timeposted', '$lrn')");
				echo "<script> swal('Success!', 'Your post has been successfully posted on the announcements tab!', 'success');</script>";
			}
			if($_POST["confirm"] == "No"){
				$queryAdd = mysql_query("INSERT INTO post(content, dateposted, timeposted, userLRN) VALUES('$content', '$dateposted', '$timeposted', '$lrn')");
				echo "<script> swal('Success!', 'Your post has been successfully posted!', 'success');</script>";
			}
			}
			}
}
}
	if(isset($_POST["btnUpload"])){
	$arr = implode("/",$_FILES['ekek']['name']);
	$arr1 = explode("/", $arr);
	$count = 0;
	foreach($arr1 as $data){
	$count = $count + 1;
	}
	for($x=0; $x<$count; $x++){
		$path="D://xampp/htdocs/Prototype1/images/".$_FILES['ekek']['name'][$x];
		$len=strlen($_FILES['ekek']['name'][$x]);
		$pos=strpos($_FILES['ekek']['name'][$x],".");
		$fileext=substr($_FILES['ekek']['name'][$x],($pos+1)-$len);
		$exte=array('jpg','png','gif');
		if (in_array($fileext,$exte)){
			if (move_uploaded_file($_FILES['ekek']['tmp_name'][$x],$path)){
				require "conn.php";
				date_default_timezone_set("Asia/Manila");
				$dateuploaded = date("F j, Y");
				$timeuploaded = date("h:i:s a");
				$querypicture = mysql_query("INSERT INTO profilepic(path, dateuploaded, timeuploaded, userLRN) VALUES('$path', '$dateuploaded','$timeuploaded', '$lrn')");
				
				echo "<script> swal('Success!', 'Your photo has been successfully updated!', 'success');</script>";

				$queryFilter = mysql_query("SELECT * FROM displaypic WHERE userID='$lrn'") or die("ERROR QUERY");
				if(mysql_num_rows($queryFilter) > 0){
					$queryUpdate = mysql_query("UPDATE displaypic SET picpath='$path' WHERE userID='$lrn'");
				}
				else{
					$queryAddDisplay = mysql_query("INSERT INTO displaypic(picpath, userID) VALUES('$path', '$lrn')");
				}
			}
			else{
					echo "<script> swal('Oops...', 'Something went wrong!', 'error');</script>";
			}
			}
		else{
			echo "<script> swal('Upload interrupted!', 'Invalid File Format', 'error');</script>";
		}
		}
	}
	if(isset($_POST["btnYes"])){
		echo("<script>location.href='logout.php';</script>");
	}
?>
	<div class="well">
		<center>
		<form enctype="multipart/form-data" action="profile.php" method="POST">
<?php
if(isset($_POST["btnCREATE"])){
		$name = $_POST["tbCreate"];
		$query = mysql_query("INSERT INTO creategroup(groupname, groupadminID) VALUES('$name', '$lrn')") or die("ERROR QUERY");
		echo "<script> swal('Success!', 'Your group has been successfully created!', 'success');</script>";
		}

$queryPic = mysql_query("SELECT * FROM displaypic WHERE userID='$lrn'");
if(mysql_num_rows($queryPic) <=0){
	?>
	<img src="images/faceless.jpg" alt="This is an image" style="width: 150px; height: 150px; border:4px solid #ececec;" class="img-circle"><br><br>
	<?php
}
else{
if($rows = mysql_fetch_array($queryPic)){
	$_SESSION["picID"] = $rows[1];
	$filedir = "images/" . basename($rows["picpath"]);
	?>
	<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 150px; height: 150px; border:4px solid #ececec;" class="img-circle"><br><br>
	<?php
$picID = $_SESSION["picID"];
}
}
	?>
	<input class="form" type='file' name='ekek[]'>
	<input type="submit" name="btnUpload" value="Upload Profile Picture"><br clear=both>
<?php
$query = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `profile`.`Mname`, `degree`.`userDegree` FROM `profile` INNER JOIN `degree` ON `profile`.`userLRN` = `degree`.`userLRN` WHERE `profile`.`userLRN`='$lrn'") or die("ERROR QUERY");
if($rowsprofile = mysql_fetch_array($query)){
	?>
<h4><br><?php echo "<span style=\"font-size:20px; font-weight:bold\">"; 
echo $rowsprofile[1] . " " . $rowsprofile[3] . " " . $rowsprofile[2]; echo "</span>";?></h4>
<h5><?php echo $rowsprofile[4]; } ?></h5>

		<?php if($userLevel == "student"){?>
		<h6><a href="viewdetails.php"><span class="icon-eye" aria-hidden="true"></span> More details | </a> 
		<a href="group_student.php?ID=<?php echo $lrn; ?>">Groups </a>
		<?php
		}
		if($userLevel == "faculty"){?>
		<h6><a href="viewdetails_fac.php"> More details | </a>
			<a href="#creategroup" data-toggle="modal"><span class="icon-plus" aria-hidden="true"></span> CREATE GROUP | </a>

			<div id="creategroup" class="modal hide" style="margin-top: 70px;">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">&times;</button>
				<h4>CREATE GROUP</h4>
			</div>
			<div class="modal-body">
				<h4>Group name </h4><input type="text" name="tbCreate" class="form-control">
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" name="btnCREATE">CREATE</button>

				<a data-dismiss="modal" class="btn" href="#">CANCEL</a>
			</div>
		</div>	
		<a href="group.php">View Groups</a>
		<?php
		}
		?>
		<ul class="examples" style="list-style-type: none;">
			<li>
			      <a href="friends.php">Friends</a>
			  </li>
			 <li class="warning confirm">
			    <div class="ui">
			      <a href="#">Logout</a></h6>
			    </div>
			  </li>
		</ul>
		</form>
		</center>
		</center>
		<hr>
		<form method="post" action="profile.php">
		<center><a href="#poststat" data-toggle="modal" class="btn btn-default" style="width: 50%;"><span class="icon-plus" aria-hidden="true"></span> POST STATUS</a></center>
		<?php
		$queryLevel = mysql_query("SELECT * FROM users WHERE userLRN='$lrn'");
		while($rows = mysql_fetch_array($queryLevel)){
			$userLevel = $rows["userLevel"];
			
			if($userLevel == "student"){
		?>
		<div id="poststat" class="modal hide" style="margin-top: 50px;">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">&times;</button>
				<h4>Post Status Update</h4>
			</div>
			<div class="modal-body">
				<textarea style="min-width: 100%;" rows="4" class="form-control" name="content"></textarea>
			</div>
			<div class="modal-footer">
				<center><button class="btn btn-primary" name="btnPOST">POST</button>
				<a data-dismiss="modal" class="btn" href="#">CANCEL</a></center>
			</div>
		</div>
		<?php
			}
		if($userLevel == "faculty"){
		?>
		<div id="poststat" class="modal hide" style="margin-top: 50px;">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">&times;</button>
				<h4>Post Status Update</h4>
			</div>
			<div class="modal-body">
				<textarea style="min-width: 100%;" rows="4" class="form-control" name="content"></textarea>
			</div>
			<div class="modal-footer">
				<center>
				<a href="#confirm" data-toggle="modal" class="btn btn-primary"><span aria-hidden="true"></span> Confirm</a>
				<div id="confirm" class="modal hide" style="margin-top: 50px;">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">&times;</button>
				<h4>Post Status Update</h4>
			</div>
			<div class="modal-body">
				<div id="option"><h5>Do you want this to be posted on the Announcements tab?</h5> </div>
				<input type="radio" name="confirm" value="Yes" checked>Yes
				<input type="radio" name="confirm" value="No"> No
				<br>
				</div>
			<div class="modal-footer">
				<center><button class="btn btn-primary" name="btnPOST">POST </button>
				<a data-dismiss="modal" class="btn" href="#">CANCEL</a></center>
			</div>
			</div>
				<a data-dismiss="modal" class="btn" href="#">CANCEL</a></center>
			</div>
		</div>
		<?php
			}
		}
		?>
		<hr>
		<legend>Recent Posts</legend>
		<?php
		$query1 = mysql_query("SELECT `profile`.`userLRN`, `profile`.`Fname`, `profile`.`Lname`, `post`.`content`, `post`.`dateposted`, `post`.`timeposted`, `post`.`ID`  FROM `profile` INNER JOIN `post` ON `profile`.`userLRN` = `post`.`userLRN` WHERE `profile`.`userLRN`='$lrn' ORDER BY `post`.`ID` DESC") or die("ERROR QUERY");
		if(mysql_num_rows($query1)<=0){
	echo "<div class='well'> <p>You have not posted anything yet.</p></div>";
}
else{
		while($rowspost = mysql_fetch_array($query1)){
			$_SESSION["exploreProfile"] = $rows["userLRN"];
			$exploreLRN = $_SESSION["exploreProfile"];	
			$_SESSION["postID"] = $rowspost["ID"];
			$_SESSION["seemoreID"] = $rowspost["ID"];
		?>
		<div class="well">

		<?php
			$querypic = mysql_query("SELECT * FROM displaypic RIGHT JOIN profile ON displaypic.userID=profile.userLRN WHERE userID='$lrn'") or die("ERROR QUERY");
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
		<p><font size="2">
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
		</p></font>
		<hr>
	    <div class="btn-group" role="group" aria-label="buttongroup">
		<a href="viewreply.php?ID=<?php $id = $_SESSION["postID"]; echo $id; ?>" data-toggle="modal" class="btn btn-default"><span class="icon-comment" aria-hidden="true"></span> 
		<?php
		$countquery = mysql_query("SELECT * FROM comments WHERE postID='$id'");
		$count = 0;
		while($rowscount = mysql_fetch_array($countquery)){
			$count = $count + 1;
		}echo $count;
		?></a>
		<a href="editpost.php?ID=<?php $id = $_SESSION["postID"]; echo $id; ?>" class="btn btn-default" stylele="margin: 20px;"><span class="icon-edit medium" aria-hidden="true"></span> </a>
		<a href="deletepost.php?postID=<?php $id = $_SESSION["postID"]; echo $id; ?>" class="btn btn-default"><span class="icon-trash" aria-hidden="true"></span> </a>
		</div>
		</div>
		<?php
		}
}
		?>
	</div></div>
</div>
	</form>
	<script type="text/javascript">
	document.querySelector('ul.examples li.warning.confirm a').onclick = function(){
		swal({
			title: "Logout Confirmation",
			text: "Are you sure you want to logout?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "skyblue",
			confirmButtonText: "Yes, I want to logout!",
			closeOnConfirm: false
		},
	  function(){
	    window.location = 'logout.php';
	  });
	};


	</script>
	<script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/scripts.js"></script>
</div>
  </body>
</html>