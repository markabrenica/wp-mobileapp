<?php
session_start();
require "conn.php";
$lrn = $_SESSION["lrn"];
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
	<?php
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
			if(!empty($_FILES['ekek']['name'][$x])){
				if(in_array($fileext,$exte)){
					if (move_uploaded_file($_FILES['ekek']['tmp_name'][$x],$path)){
						$caption = mysql_real_escape_string($_POST["title"]);
						date_default_timezone_set("Asia/Manila");
						$dateuploaded = date("F j, Y");
						$timeuploaded = date("h:i:s a");
						$querypicture = mysql_query("INSERT INTO picgallery VALUES('', '$caption','$path', '$dateuploaded','$timeuploaded', '$lrn')") or die("ERROR QUERY");
					}
					else{
							echo "<script> swal('Error!', 'Ooops... Something went wrong! Please try again later!', 'error');</script>";
					}
				}
			else{
				echo "<script> swal('Error!', 'It looks like you are uploading an invalid File!', 'error');</script>";
			}
			}
			}
			}

		?>
<div class="container">
<form enctype="multipart/form-data" action="add-photo.php" method="POST">
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
<input type="text" name="title" placeholder="Caption"><br>
<input class="form" type='file' name='ekek[]'><br>
<input class="form" type='file' name='ekek[]'><br>
<input class="form" type='file' name='ekek[]'><br>
<input class="form" type='file' name='ekek[]'><br>
<input class="form" type='file' name='ekek[]'><br>
<input type="submit" name="btnUpload" value="Upload Pictures"><br clear=both>

<?php
$query = mysql_query("SELECT * FROM picgallery WHERE userLRN = '$lrn' ORDER BY ID DESC") or die("ERROR QUERY");
while($rows = mysql_fetch_array($query))
{
	echo $rows[1] . " " . $rows[3] . " @ $rows[4] <br>";
	?>
				<?php
						$filename = basename($rows[2]);
						$source = "images/".$filename;
				?>
                <a class="thumbnail" href="#">
                    <img src="<?php echo $source; ?>" alt="3.jpg" height="100px" width="150px">
                </a>
           
<?php
}
?> 
</form>
 <script src="vendors/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="assets/scripts.js"></script>
</body>
<html>