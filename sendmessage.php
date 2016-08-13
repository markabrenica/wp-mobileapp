<?php
session_start();
$lrn = $_SESSION["lrn"];
require "conn.php";
?>
<html>
  <head>
    <title>Send Message</title>
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

        <script type="text/javascript">
        	function func(){
        		var str = "";
				<?php
				$queryFilter = mysql_query("SELECT profile.Fname, profile.Lname,connected.connectedID, profile.userLRN FROM connected INNER JOIN profile ON connected.connectedID=profile.userLRN WHERE connected.userID='$lrn'") or die("ERROR QUERY");
				while($rows = mysql_fetch_array($queryFilter)){
				?>
				if(document.getElementById("<?php echo $rows[3]; ?>").checked == true){
					document.getElementById("names").innerHTML = "<?php echo $rows[0] . ' ' . $rows[1] . ' / '; ?>";
					str += document.getElementById("names").innerHTML; 
				}
				<?php
			}
			?>
			document.getElementById("names").innerHTML = str;
			}
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
	<form method="POST" action="sendmessage.php">
		<?php
			if(isset($_POST["btnSEND"])){
				$count = 0;
				$message = mysql_real_escape_string($_POST["message"]);
				date_default_timezone_set("Asia/Manila");
				$datesent = date("F j, Y");
				$timesent = date("h:i:s a");

				if(!empty($message)){
					if(!empty($_POST["rec"])){
						$str = implode($_POST["rec"],"/");
						$str1 = explode("/", $str);
						foreach($str1 as $data){
							$querySend = mysql_query("INSERT INTO messages VALUES('','$lrn', '$data', '$message','$datesent','$timesent')") or die("ERROR QUERY");
							$count = $count + 1;
						}
					}
					else{
						echo "<script> swal('Error!', 'Please select at least one recipient!', 'error');</script>";
					}
				}
				else{
						echo "<script> swal('Error!', 'It looks like you are sending an empty message! Please fill in the message box first!', 'error');</script>";
				}
				if($count > 0){
					echo "<script> swal('Success!', 'Message sent!', 'success');</script>";
				}
			}
		?>
	<fieldset><legend>Send a message</legend>
	<textarea name="message" rows="3" style="width: 100%"></textarea>
	<div class='alert alert-info'  style='margin-top: 5px;'>
	<p>Send to: <p id="names"></p></p>
	</div>
	<button class="btn btn-medium btn-info" name="btnSEND" style="margin-bottom: 10px;"><span class="icon icon-share-alt"></span> SEND </button>
		<div class="well">
		<table class="table table-responsive table-bordered">
		<?php
		if(!isset($_POST["btnGo"])){
			$queryFilter = mysql_query("SELECT profile.Fname, profile.Lname,connected.connectedID, profile.userLRN FROM connected INNER JOIN profile ON connected.connectedID=profile.userLRN WHERE connected.userID='$lrn'") or die("ERROR QUERY");
			
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
								<td>
								<center><input type="checkbox" id="<?php echo $rows[3]; ?>" name="rec[]" value="<?php echo $rows[3]; ?>" onclick="func()" style="margin-top: 20px;"></center>
								</td>
								<td>
								<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
								<?php echo $rows["Fname"] . " " . $rows["Lname"]; ?>
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