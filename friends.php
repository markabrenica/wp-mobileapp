<?php
session_start();
$lrn = $_SESSION["lrn"];
require "conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>Friends</title>
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
	<form method="POST" action="friends.php">
		<?php
		$queryRemove = mysql_query("SELECT profile.Fname, profile.Lname,connected.connectedID, profile.userLRN FROM connected INNER JOIN profile ON connected.connectedID=profile.userLRN WHERE connected.userID='$lrn'") or die("ERROR QUERY");
		while($del = mysql_fetch_array($queryRemove)){
			if(isset($_POST["$del[3]"])){
				$delfriend = mysql_query("DELETE FROM connected WHERE userID='$lrn' AND connectedID='$del[3]'") or die("ERROR QUERY");
				$delfriend1 = mysql_query("DELETE FROM connected WHERE userID='$del[3]' AND connectedID='$lrn'") or die("ERROR QUERY");
				$delrequest = mysql_query("DELETE FROM connectrequest WHERE userID='$lrn' AND requestID='$del[3]'") or die("ERROR QUERY");
				$delrequest1 = mysql_query("DELETE FROM connectrequest WHERE userID='$del[3]' AND requestID='$lrn'") or die("ERROR QUERY");
				?>
				<script>
					swal({
				    title: "Removed!",
				    text: "Successfully Removed!",
				    type: "warning",
				    confirmButtonColor: '#DD6B55',
				    confirmButtonText: 'Yes',
				    closeOnConfirm: false,
				  },
				  function(isConfirm){
				    if (isConfirm){
				    	location.href = 'friends.php';
				    }
				  });
				</script>
				<?php
				
			}
		}
		?>
	<fieldset><legend>Friends List</legend>
		<div class="well">
		<input type="text" name="search" placeholder="Search by name" style="max-width: 55%; margin-top: 10px;">
		<input type="submit" name="btnGo" class="btn btn-default" value="Go"><br>
		<hr>
		<table class="table table-responsive table-bordered">
		<?php
		if(isset($_POST["btnGo"])){
			$search = mysql_real_escape_string($_POST["search"]);

				$queryFilter = mysql_query("SELECT profile.Fname, profile.Lname,connected.connectedID, profile.userLRN FROM connected INNER JOIN profile ON connected.connectedID=profile.userLRN WHERE connected.userID='$lrn' AND Fname LIKE '%$search%' OR Lname LIKE '%$search%'") or die("ERROR QUERY");
				if(mysql_num_rows($queryFilter) > 0){
				while($rows = mysql_fetch_array($queryFilter)){
					$_SESSION["exploreProfile"] = $rows["userLRN"];
					$exploreLRN = $_SESSION["exploreProfile"];
					?>
					<tr> 
						<?php 
						$queryPic = mysql_query("SELECT profilepic.path FROM profilepic INNER JOIN profile ON profilepic.userLRN=profile.userLRN WHERE profile.userLRN='$exploreLRN' ORDER BY picID DESC");
							if($rowspic = mysql_fetch_array($queryPic)){
								$filedir = "images/" . basename($rowspic[0]);
								?>
									<td> <img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
									<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
									</td>
									<td>
									<button name="<?php echo $rows[3]; ?>" class="btn btn-danger"><span class="icon icon-remove"></span>Remove</button>
									</td>
								<?php
							}
							if(mysql_num_rows($queryPic) == 0){

								$filedir = "images/" . basename($rowspic[0]);
								?>
									<td> <img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
									<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
									</td>
								<?php
							}
						?>
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
			$queryFilter = mysql_query("SELECT profile.Fname, profile.Lname,connected.connectedID, profile.userLRN, userDegree FROM connected INNER JOIN profile ON connected.connectedID=profile.userLRN  INNER JOIN degree ON degree.userLRN=profile.userLRN WHERE connected.userID='$lrn' ORDER BY Fname") or die("ERROR QUERY");
			
			if(mysql_num_rows($queryFilter) > 0){

			while($rows = mysql_fetch_array($queryFilter)){
				$_SESSION["exploreProfile"] = $rows["userLRN"];
				$exploreLRN = $_SESSION["exploreProfile"];
				?>
				<tr> 
					<?php 
					$queryPic = mysql_query("SELECT profilepic.path FROM profilepic INNER JOIN profile ON profilepic.userLRN=profile.userLRN WHERE profile.userLRN='$exploreLRN' ORDER BY picID DESC");
						if($rowspic = mysql_fetch_array($queryPic)){
							$filedir = "images/" . basename($rowspic[0]);
							?>
								<td> <img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle"><br>
								<font color="#00679b"><a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>" style="text-decoration: none;"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a></font>
								<br><font style="font-size: 13px;"><?php echo $rows[4]; 	?></font>

								</td>
								<td>	
								<button name="<?php echo $rows[3]; ?>" class="btn btn-danger" style="margin-top: 20px;"><span class="icon icon-remove"></span> Remove</button>
								
								</td>
							<?php
						}
						if(mysql_num_rows($queryPic) == 0){

							$filedir = "images/" . basename($rowspic[0]);
							?>
								<td> <img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
								<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
								<br><font style="font-size: 13px;"><?php echo $rows[4]; ?></font>
								</td>
							<?php
						}
					?>
				</tr>
				<?php
			}
		}
		else{
		?>
				<div style="background-color: white; foreground-color: ; text-align: center; padding: 10px; margin-top: 5px; ">
					<label><font color="#00679b">You have no friends yet..</font></label>
				</div>
				<?php
			}	
		}
		?>
		</table>
		</div>
	</fieldset>
	    <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="assets/scripts.js"></script>
  </body>
</html>