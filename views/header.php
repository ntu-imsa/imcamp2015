<!DOCTYPE HTML>
<html>
	<head>
		<title>2015 臺灣大學資訊管理營</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<link rel="icon" type="image/png" href="images/favicon.png" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.poptrox.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.scrollex.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
			<link rel="stylesheet" href="css/style-normal.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body>

		<!-- Header -->
			<header id="header">

				<!-- Logo -->
					<h1 id="logo"><img src="images/logo.png" style="height:1.2em;"> 2015 臺灣大學資訊管理營</h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
              <?php
                switch($nav){
                  case "reg":
                    include "header_nav_reg.php";
                    break;
                  default:
                    include "header_nav_public.php";
                }
              ?>
						</ul>
					</nav>

			</header>
