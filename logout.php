<?php
session_start();
?>
<html>
<title> Profile </title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="assets/styles.css" rel="stylesheet">
		<link href="css/StyleSheet.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="sweetalert-master/example/example.css">
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

        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="js/jquery.js"></script>
        <script type="text/javascript">
		    $(window).load(function(){
		      swal({
			    title: "Success",
			    text: "You have been successfully logged out!",
			    type: "success",
			    confirmButtonColor: 'skyblue',
			    confirmButtonText: 'OKAY',
			    closeOnConfirm: false,
			  },
			  function(isConfirm){
			    if (isConfirm){
			    	location.href = 'index.php';
			    }
			  });
		    });
	  </script>
</head>
<body>
	<div class="container">
	<form method="POST" action="logout.php">
 <div style='padding-top: 0px;'>
	  <div class="page-header">
		<h4 style="font-family: Arial"><img src="images/PSUConnect_Logo4.png" height="60" width="60"><font color="white" size="4"> PSU Connect</font></h4>
	  </div>
	</div>
	<div class="se-pre-con"></div>
</div>
</body>
</html>