<?php
session_start();
$lrn = $_SESSION["lrn"];
$department = $_SESSION["department"];
require "conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<?php
	if(isset($_POST["btnPOST"])){

		$content = mysql_real_escape_string($_POST["postcontent"]);
		date_default_timezone_set("Asia/Manila");
		$dateposted = date("F j, Y");
		$timeposted = date("h:i:s a");
		$query = mysql_query("INSERT INTO `department` VALUES('','$content','$dateposted','$timeposted','$lrn','$department')") or die("ERROR QUERY");
		?>
<script>
	swal({
    title: "Success!",
    text: "Your post has been successfully posted!",
    type: "success",
    confirmButtonColor: 'skyblue',
    confirmButtonText: 'OKAY',
    closeOnConfirm: false,
  },
  function(isConfirm){
    if (isConfirm){
    	location.href = 'department.php';
    }
  });

</script>
<?php
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
		<form action="department.php" method="POST">
		
		<?php
		$query = mysql_query("SELECT userDegree FROM degree WHERE userLRN='$lrn'") or die("ERROR QUERY");
			while($rows = mysql_fetch_array($query)){
				$degree = $rows[0];
		?>
		<legend>Department <small><?php echo $rows[0]; }?></small></legend>
		<textarea name="postcontent" placeholder="Post an update about your department!" style="min-width: 40%;"></textarea>
		<button name="btnPOST" class="btn btn-info" style="margin-bottom: 5px;">POST</button>
		<?php
			$queryFilter = mysql_query("SELECT department.ID, content, dateposted, timeposted, department.userLRN, Fname, Lname FROM department INNER JOIN profile ON department.userLRN = profile.userLRN WHERE department = '$degree' ORDER BY ID DESC") or die("ERROR QUERY");
			
			if(mysql_num_rows($queryFilter) <= 0){
				echo "<div class='well'> <p>There is no post in this group!</p></div>";
			}
			else{
			while($result = mysql_fetch_array($queryFilter)){
			$_SESSION["exploreProfile"] = $result["userLRN"];
			$exploreLRN = $_SESSION["exploreProfile"];	
			$_SESSION["postdeptID"] = $result["ID"];
			$_SESSION["seemoreID"] = $result["ID"];
		?>
		<div class="well">

		<?php
			$querypic = mysql_query("SELECT * FROM displaypic RIGHT JOIN profile ON displaypic.userID=profile.userLRN WHERE profile.userLRN ='$exploreLRN'") or die("ERROR QUERY");
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
	    <b><font color="#00679b"><a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>" style="text-decoration: none;"><?php echo $result[5] . " " . $result[6] . " </a></font></b> <font color='a599ae' size='2'>@ " . $result[2] . " " . $result[3]; ?></p></font>
		<p><font size="2">
		<?php
		$string = $result[1];
		$seemoreID = $_SESSION["seemoreID"];
		if(strlen($string) > 250){
			$trimstring = substr($string, 0, 250) . '<a href="viewreply_dept.php?ID='.$seemoreID.'" style="text-decoration: none; font-weight: italic;">Read more</a>';
		}
		else{
			$trimstring = $string;
		}
		echo $trimstring . "</font><br>"; 
		?> 
		</p></font>
		<hr>
	    <div class="btn-group" role="group" aria-label="buttongroup">
		<a href="viewreply_dept.php?ID=<?php $id = $_SESSION["postdeptID"]; echo $id; ?>" data-toggle="modal" class="btn btn-default"><span class="icon-comment" aria-hidden="true"></span> 
		<?php
		$countquery = mysql_query("SELECT * FROM comment_dept WHERE postID='$id'");
		$count = 0;
		while($rowscount = mysql_fetch_array($countquery)){
			$count = $count + 1;
		}echo $count;
		?></a>
		<?php
			if($result["userLRN"] == $lrn){
				?>
					<a href="editpost_dept.php?ID=<?php $id = $_SESSION["postdeptID"]; echo $id; ?>" class="btn btn-default" stylele="margin: 20px;"><span class="icon-edit medium" aria-hidden="true"></span> </a>
					<a href="deletepost_dept.php?postID=<?php $id = $_SESSION["postdeptID"]; echo $id; ?>" class="btn btn-default"><span class="icon-trash" aria-hidden="true"></span> </a>
				<?php
			}
			echo "</div></div>";
		}
		}
		?>	
	</div>
		</form>
	    <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="assets/scripts.js"></script>
  </body>
</html>