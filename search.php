<?php
session_start();
require "conn.php";
$lrn = $_SESSION["lrn"];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Profile</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" media="screen" href="http://www.w3schools.com/lib/w3.css">
	<link rel="stylesheet" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<style type="text/css">
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

		@import url("//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css");
		.search{
			position:relative;
		}
		.search input{
			text-indent: 30px;
		}
		.search .fa-search{
			position: absolute;
			top: 5px;
			left: 7px;
			font-size: 15px;
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
</li><li role="presentation" class="w3-small"><a href="message.php" style="color:#66757f;"><span class="fa fa-envelope" aria-hidden="true"></span></a></li>
<li role="presentation" class="w3-small"><a href="pictures.php" style="color:#66757f;"><span class="fa fa-photo" aria-hidden="true"></span></a></li>
	  	<li role="presentation" class="w3-small"><a href="department.php" style="color:#66757f;"><span class="fa fa-building" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-small"><a href="announcement.php" style="color:#66757f;"><span class="fa fa-list-alt" aria-hidden="true"></span></a></li>
		<li role="presentation" class="w3-medium"><a href="search.php" style="color:#66757f;"><span class="fa fa-search" aria-hidden="true"></span></a></li>
	</ul>
	</div>
	<div class="se-pre-con"></div>

	<form method="POST" action="search.php">
	<div class="search">
		<span class="fa fa-search"></span>
		<input name="tbSearch" placeholder="Search" style="min-width: 70%;">
		<button name="btnSearch" class="btn btn-default">Search</button>
	</div>
	<br>
	<select name="criteria" style="min-width: 100%;">
		<option value="all">All</option>
		<option value="studno">Student Number</option>
		<option value="people">People</option>
		<option value="address">Address</option>
		<option value="degree">Degree</option>
		<option value="yearlevel">Year Level</option>
	</select>
	<?php
	if(!isset($_POST["btnSearch"])){
	?>
	<div style="background-color: white; foreground-color: ; text-align: center; padding: 10px; margin-top: 5px; ">
		<label><font color="#00679b">Filter your search by people, address, degree or year level</font></label>
	</div>
	<?php
}
else{
	$search = mysql_real_escape_string($_POST["tbSearch"]);
	$count = 0;
	if($_POST["criteria"] == "all"){
		//SELECTED: ALL
		$query = mysql_query("SELECT profile.userLRN, Fname, Lname, Address, userDegree, Yearno, picpath FROM profile LEFT JOIN displaypic ON displaypic.userID =profile.userLRN INNER JOIN degree ON profile.userLRN=degree.userLRN WHERE profile.userLRN LIKE '%$search%' OR Fname LIKE '%$search%' OR  Lname LIKE '%$search%' OR Address LIKE '%$search%' OR userDegree LIKE '%$search%' OR Yearno LIKE '%$search%'") or die("ERROR QUERY");
		
			if(mysql_num_rows($query) > 0){
				$count = 0;
				while($rows = mysql_fetch_array($query)){
					$_SESSION["exploreProfile"] = $rows["userLRN"];
					$exploreLRN = $_SESSION["exploreProfile"];	
					?>
					<div class="well">
					<?php
					if($rows[6] == ""){
						?>
						<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					else{
						$exploreLRN = $rows[0];
						$filedir = "images/" . basename($rows[6]);
						?>
						<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					?>
						<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a><br>
						<?php echo $rows[4] . " | " . $rows[3]; ?><br>
					</td>

					<?php
					echo "</div>";
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
	if($_POST["criteria"] == "studno"){
		//echo "MERON";
		//SELECTED: Student Number
		$query = mysql_query("SELECT profile.userLRN, Fname, Lname, Address, picpath FROM profile LEFT JOIN displaypic ON displaypic.userID=profile.userLRN WHERE profile.userLRN LIKE '%$search%'") or die("ERROR QUERY");
			if(mysql_num_rows($query) > 0){
				while($rows = mysql_fetch_array($query)){
					$_SESSION["exploreProfile"] = $rows["userLRN"];
					$exploreLRN = $_SESSION["exploreProfile"];	
					if($rows[4] == ""){
						?>
						<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					else{
						$exploreLRN = $rows[0];
						$filedir = "images/" . basename($rows[4]);
						?>
						<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					?>
						<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a><br>
						<?php echo $rows[3]; ?><br>
						<?php
				}
			}
			else{
				//echo "WALA";
				?>
				<div style="background-color: white; text-align: center; padding: 10px; margin-top: 5px; ">
					<label><font color="#00679b">No record matches your search..</font></label>
				</div>
	<?php
			}
		//END CODE
	}
	if($_POST["criteria"] == "people"){
		//SELECTED: People
		$query = mysql_query("SELECT profile.userLRN, Fname, Lname, Address,picpath FROM profile LEFT JOIN displaypic ON displaypic.userID=profile.userLRN WHERE Fname LIKE '%$search%' OR  Lname LIKE '%$search%'") or die("ERROR QUERY");
			if(mysql_num_rows($query) > 0){
				while($rows = mysql_fetch_array($query)){
					$_SESSION["exploreProfile"] = $rows["userLRN"];
					$exploreLRN = $_SESSION["exploreProfile"];	
					if($rows[4] == ""){
						?>
						<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					else{
						$exploreLRN = $rows[0];
						$filedir = "images/" . basename($rows[4]);
						?>
						<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					?>
						<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a><br>
						<?php echo $rows[3]; ?><br>
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
		//END CODE
	}
	if($_POST["criteria"] == "address"){
		//SELECTED: Address
		$query = mysql_query("SELECT DISTINCT profile.userLRN, Fname, Lname, Address, picpath FROM profile LEFT JOIN displaypic ON displaypic.userID=profile.userLRN WHERE Address LIKE '%$search%'") or die("ERROR QUERY");
			if(mysql_num_rows($query) > 0){
				while($rows = mysql_fetch_array($query)){
					$_SESSION["exploreProfile"] = $rows["userLRN"];
					$exploreLRN = $_SESSION["exploreProfile"];	
					if($rows[4] == ""){
						?>
						<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					else{
						$exploreLRN = $rows[0];
						$filedir = "images/" . basename($rows[4]);
						?>
						<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					?>
						<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a><br>
						<?php echo $rows[3]; ?><br>
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
		//END CODE
	}
	if($_POST["criteria"] == "degree"){
		//SELECTED: Degree
		$query = mysql_query("SELECT profile.userLRN, Fname, Lname, Address, userDegree, picpath FROM profile LEFT JOIN displaypic ON displaypic.userID=profile.userLRN INNER JOIN degree ON degree.userLRN=profile.userLRN WHERE userDegree LIKE '%$search%'") or die("ERROR QUERY");
			if(mysql_num_rows($query) > 0){
				while($rows = mysql_fetch_array($query)){
					$_SESSION["exploreProfile"] = $rows["userLRN"];
					$exploreLRN = $_SESSION["exploreProfile"];	
					if($rows[5] == ""){
						?>
						<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					else{
						$exploreLRN = $rows[0];
						$filedir = "images/" . basename($rows[5]);
						?>
						<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					?>
						<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a><br>
						<?php echo $rows[3]; ?><br>
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
		//END CODE
	}
	if($_POST["criteria"] == "yearlevel"){
		//SELECTED: Year Level
		$query = mysql_query("SELECT profile.userLRN, Fname, Lname, Address, Yearno, picpath FROM profile LEFT JOIN displaypic ON displaypic.userID=profile.userLRN INNER JOIN degree ON degree.userLRN=profile.userLRN WHERE Yearno LIKE '%$search%'") or die("ERROR QUERY");
			if(mysql_num_rows($query) > 0){
			while($rows = mysql_fetch_array($query)){
				$_SESSION["exploreProfile"] = $rows["userLRN"];
				$exploreLRN = $_SESSION["exploreProfile"];	
					if($rows[5] == ""){
						?>
						<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					else{
						$exploreLRN = $rows[0];
						$filedir = "images/" . basename($rows[5]);
						?>
						<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
						<?php
					}
					?>
						<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a><br>
						<?php echo $rows[3]; ?><br>
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
		//END CODE
	}	
}
?>
	</form>

	<script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/scripts.js"></script>
  </body>
</html>