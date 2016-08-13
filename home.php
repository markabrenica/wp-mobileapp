<?php
session_start();
require "conn.php";
$lrn = $_SESSION["lrn"];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Home</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
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
	<form method="POST" action="home.php">
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>
<div id="navcolor">
	<ul class="nav nav-tabs">
	  <li role="presentation" class="w3-small"><a href="home.php" style="color:#66757f;"><span class="fa fa-home" aria-hidden="true"></span></a></li>
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
$query= mysql_query("SELECT post.ID, content, dateposted, timeposted, Fname, Lname, profile.userLRN, connectedID FROM post INNER JOIN profile ON post.userLRN = profile.userLRN INNER JOIN connected ON connected.userID=profile.userLRN WHERE connected.connectedID='$lrn' ORDER BY post.ID DESC") or die("ERROR QUERY");

	while($rows = mysql_fetch_array($query)){
		$_SESSION["exploreProfile"] = $rows["userLRN"];
		$exploreLRN = $_SESSION["exploreProfile"];
		$_SESSION["ID"] = $rows[0];
		$_SESSION["seemoreID"] = $rows[0];
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
?>				
		    <b><font color="#00679b"><a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>" style="text-decoration: none;"><?php echo $rows[4] . " " . $rows[5] . "</a> </b></font><font color='a599ae' size='2'>@ " . $rows[2] . " " . $rows[3];?></p>
			</font>
			<font size="2">
			<p>
			<?php
			$string = $rows[1];
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
		</font>
		    <div class="btn-group" role="group" aria-label="buttongroup">
			<a href="viewreply.php?ID=<?php $id = $_SESSION["ID"]; echo $id; ?>" data-toggle="modal" class="btn btn-default"><span class="icon-comment" aria-hidden="true"></span> 
			<?php
			$countquery = mysql_query("SELECT * FROM comments WHERE postID='$id'");
			$count = 0;
			while($rows = mysql_fetch_array($countquery)){
				$count = $count + 1;
			}
			echo $count;
			?>
			Comments</a>
			</div>

		</div>
		<?php
	}
?>
	</form>

	<script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/scripts.js"></script>
  </body>
</html>