<?php
session_start();
$lrn = $_SESSION["lrn"];
require "conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>Connect</title>
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
	<form method="POST" action="connect.php">

	<fieldset><legend>Connect Requests</legend>
		<?php
			//$queryShow = mysql_query("SELECT users.username,profile.Fname, profile.Lname,profile.userLRN  FROM users INNER JOIN profile ON users.userLRN=profile.userLRN WHERE users.userLRN<>'$lrn'") or die("ERROR QUERY");
			$queryShow = mysql_query("SELECT connectrequest.userID, profile.Fname, profile.Lname FROM connectrequest INNER JOIN profile ON connectrequest.userID = profile.userLRN WHERE connectrequest.requestID='$lrn' AND connectrequest.requeststatus=''") or die("ERROR QUERY");

			if(mysql_num_rows($queryShow) > 0){
				while($rows1 = mysql_fetch_array($queryShow)){
				echo $rows1[1] . " " . $rows1[2] . "<br>";
			?>
			<button class="btn btn-info" name="<?php echo $rows1[0]; ?>"><span class="icon icon-ok"></span> Accept</button><br>
			<?php
				}
			}
			else{
				?>
				<div style="background-color: white; foreground-color: ; text-align: center; padding: 10px; margin-top: 5px; ">
					<label><font color="#00679b">You have no new requests.</font></label>
				</div>
				<?php
			}
	$queryShow = mysql_query("SELECT connectrequest.userID, profile.Fname, profile.Lname, connectrequest.ID  FROM connectrequest INNER JOIN profile ON connectrequest.userID = profile.userLRN WHERE connectrequest.requestID='$lrn'") or die("ERROR QUERY");

	while($rows2 = mysql_fetch_array($queryShow)){

		if(isset($_POST["$rows2[0]"])){
			$queryINSERT = mysql_query("INSERT INTO connected(userID, connectedID) VALUES('$lrn', '$rows2[0]')") or die("ERROR QUERY");
			$queryINSERT = mysql_query("INSERT INTO connected(userID, connectedID) VALUES('$rows2[0]', '$lrn')") or die("ERROR QUERY");
			$update = mysql_query("UPDATE connectrequest SET requeststatus='Accepted' WHERE ID='$rows2[3]'") or die("ERROR QUERY");
			?>
			<script>
				var num = "";
				num = document.getElementById("ID").value;

				swal({
			    title: "Confirmation",
			    text: "Request Accepted!",
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
	}
	?>
	</fieldset>
	<br>
	<legend>People To Connect</legend>
		<div class="well">
		<input type="text" name="search" placeholder="Search" style="max-width: 55%; margin-top: 10px;">
		<input type="submit" name="btnGo" class="btn btn-default" value="Go"><br>
		<table class="table table-bordered">
		<?php
		if(isset($_POST["btnGo"])){
			$search = mysql_real_escape_string($_POST["search"]);
			$queryConnect = mysql_query("SELECT users.username,profile.Fname, profile.Lname,profile.userLRN FROM users INNER JOIN profile ON users.userLRN=profile.userLRN WHERE users.userLRN<>'$lrn' AND username LIKE '%$search%' OR Fname LIKE '%$search%' OR Lname LIKE '%$search%'") or die("ERROR QUERY");
			if(mysql_num_rows($queryConnect) > 0){
				while($rows = mysql_fetch_array($queryConnect)){
				$_SESSION["exploreProfile"] = $rows["userLRN"];
				$exploreLRN = $_SESSION["exploreProfile"];
				?>
				<tr> 
					<?php 
					$queryselect = mysql_query("SELECT * FROM connected WHERE  userID='$lrn' AND connectedID='$exploreLRN'") or die("ERROR QUERY");
					$queryPic = mysql_query("SELECT profilepic.path FROM profilepic INNER JOIN profile ON profilepic.userLRN=profile.userLRN WHERE profile.userLRN='$exploreLRN' ORDER BY picID DESC");
			
					if(mysql_num_rows($queryselect) > 0){
						continue;
					}
					else{

						if($rowspic = mysql_fetch_array($queryPic)){
							$filedir = "images/" . basename($rowspic[0]);
							?>
								<td> <img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
								<?php echo "@" . $rows["username"]; ?><br>
								<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
								 </td>

							<?php
						}
						if(mysql_num_rows($queryPic) == 0){

							$filedir = "images/" . basename($rowspic[0]);
							?>
								<td> <img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
								<?php echo "@" . $rows["username"]; ?><br>
								<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
								 </td>
							<?php
					}
					?>					
						<td>
							<?php

							echo "<a href='insertconnected.php?ID=$exploreLRN'>Connect</a>"; 
							?>
						</td>
						<?php
					}
					?>
				</tr>
				<tr>
					<td></td>
				</tr>
				<?php
			}
		}	
		else{
			?>
			<div style="background-color: white; foreground-color: ; text-align: center; padding: 10px; margin-top: 5px; ">
				<label><font color="#00679b">No record matches your search..</font></label>
			</div>
				<?php
		}
		}
		if(!isset($_POST["btnGo"])){
		$queryConnect = mysql_query("SELECT users.username,profile.Fname, profile.Lname,profile.userLRN FROM users INNER JOIN profile ON users.userLRN=profile.userLRN WHERE users.userLRN<>'$lrn'") or die("ERROR QUERY");
		while($rows = mysql_fetch_array($queryConnect)){
			$_SESSION["exploreProfile"] = $rows["userLRN"];
			$exploreLRN = $_SESSION["exploreProfile"];
			?>
			<tr> 
				<?php 
				$queryselect = mysql_query("SELECT * FROM connected WHERE  userID='$lrn' AND connectedID='$exploreLRN'") or die("ERROR QUERY");
				$queryPic = mysql_query("SELECT profilepic.path FROM profilepic INNER JOIN profile ON profilepic.userLRN=profile.userLRN WHERE profile.userLRN='$exploreLRN' ORDER BY picID DESC");
		
				if(mysql_num_rows($queryselect) > 0){
					continue;
				}
				else{

					if($rowspic = mysql_fetch_array($queryPic)){
						$filedir = "images/" . basename($rowspic[0]);
						?>
							<td> <img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
							<?php echo "@" . $rows["username"]; ?><br>
							<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
							 </td>

						<?php
					}
					if(mysql_num_rows($queryPic) == 0){

						$filedir = "images/" . basename($rowspic[0]);
						?>
							<td> <img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
							<?php echo "@" . $rows["username"]; ?><br>
							<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
							 </td>
						<?php
					}
?>					
					<td>
						<?php

						echo "<a href='insertconnected.php?ID=$exploreLRN'>Connect</a>"; 
						?>
					</td>
					<?php
				}
				?>
			</tr>
			<tr>
				<td></td>
			</tr>
			<?php
		}
	}
		?>
		</table>
		</div>
	    <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="assets/scripts.js"></script>
  </body>
</html>