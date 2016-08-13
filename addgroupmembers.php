<?php
session_start();
$lrn = $_SESSION["lrn"];
$id = $_GET["ID"];
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
	<form method="POST" action="addgroupmembers.php?ID=<?php echo $id; ?>">
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
	require "conn.php";
		if(isset($_POST["btnSelect"])){	
			if(empty($_POST["select"])){
					echo "<script> swal('Warning!', 'Please select atleast one member to add!', 'warning');</script>";
			}
			else{

			$value = $_POST["select"];
			$idcombine = implode("/", $value);
			
			$arr = explode("/", $idcombine);
			$name = "";
			$count = 0;
			foreach ($arr as $data) {
			$queryfilter = mysql_query("SELECT groupID, Fname FROM groupmember INNER JOIN profile ON groupmember.userID=profile.userLRN WHERE userID='$data' AND groupID='$id'") or die("ERROR QUERY");
			$queryshow = mysql_query("SELECT groupID, userID, Fname FROM groupmember INNER JOIN profile ON groupmember.userID=profile.userLRN") or die("ERROR QUERY");

			if(mysql_num_rows($queryfilter) > 0){
				while($rows = mysql_fetch_array($queryfilter)){
					$name = $rows[1] . " / " . $name;
					$count = $count + 1;
					break;
				}
			}
			else{
				$count = 0;
		}
	}
		if($count > 0){
			echo "<script> swal('Warning!', 'The following are already a member: $name', 'warning');</script>";
		}
		else{
			foreach ($arr as $data) {
			$queryADD = mysql_query("INSERT INTO groupmember(groupID, userID) VALUES('$id', '$data')") or die("ERROR QUERY");
			
		}
		echo "<script> swal('Success!', 'Members have been successfully updated!', 'success');</script>";
		}
		}
	}
		$query = mysql_query("SELECT * FROM creategroup WHERE ID='$id'") or die("ERROR QUERY");
		while($rows = mysql_fetch_array($query)){
			$name = $rows[1];
		}
		echo "<legend>" . $name;	
	?>
	<small><a href="group_explore.php?ID=<?php echo $id; ?>"> View group details </a> </small></legend>
</h3>
<h4>Add group members</h4>
<table style="padding: 5px;">
<?php
$query = mysql_query("SELECT userID, connectedID, Fname, Lname FROM connected INNER JOIN profile ON connected.connectedID=profile.userLRN WHERE userID='$lrn' ORDER BY Fname") or die("ERROR QUERY");
while($rows = mysql_fetch_array($query)){
$queryPic = mysql_query("SELECT profilepic.path FROM profilepic INNER JOIN connected ON profilepic.userLRN=connected.connectedID WHERE connectedID='$rows[1]' ORDER BY picID DESC");

			if($rowspic = mysql_fetch_array($queryPic)){
						$filedir = "images/" . basename($rowspic[0]);
						?>
						
						<tr>
							<td>
								<input type="checkbox" name="select[]" value="<?php echo $rows[1];?>">
							</td>
							<td> 
								<img src="<?php echo $filedir; ?>" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
								<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
							</td>
						</tr>

						<?php
					}
					if(mysql_num_rows($queryPic) == 0){

						$filedir = "images/" . basename($rowspic[0]);
						?>
						<tr>
							<td>
								<input type="checkbox" name="select[]" value="<?php echo $rows[1];?>">
							</td>
							<td> 
								<img src="images/faceless.jpg" alt="This is an image" style="width: 50px; height: 50px; border:4px solid #ececec;" class="img-circle">
								<a href="profile_explore.php?userLRN=<?php echo $exploreLRN; ?>"><?php echo $rows["Fname"] . " " . $rows["Lname"]; ?></a>
							</td>
						 </tr>
						<?php
					}
				}
?>			
</table>

<input type="submit" name="btnSelect" value="ADD" class="btn btn-default">
</form>
<script src="vendors/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="assets/scripts.js"></script>
</body>
<html>