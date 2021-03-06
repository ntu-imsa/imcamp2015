<!DOCTYPE HTML>
<html>
	<head>
		<title>2015 臺灣大學資訊管理營</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="你有沒有，看過台大的星空？你有沒有，在椰林大道上盡情奔馳過？2015 年夏天，讓我們一同留下屬於自己的足跡！台大資管營以入門的程式設計課程，搭配有趣的策略模擬遊戲，帶領高中生體驗資管系的特色，進而啟發學習的興趣。" />
		<meta property="og:title" content="2015 臺灣大學資訊管理營" />
		<meta property="og:image" content="https://ntu.im/camp/2015/images/og.png" />
		<meta property="og:description" content="你有沒有，看過台大的星空？你有沒有，在椰林大道上盡情奔馳過？2015 年夏天，讓我們一同留下屬於自己的足跡！台大資管營以入門的程式設計課程，搭配有趣的策略模擬遊戲，帶領高中生體驗資管系的特色，進而啟發學習的興趣。" />
		<link rel="icon" type="image/png" href="images/favicon.png" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.poptrox.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.scrollex.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/init.js"></script>
    <script src="js/flipclock.min.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
			<link rel="stylesheet" href="css/style-normal.css" />
		</noscript>
    <link rel="stylesheet" href="css/flipclock.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
		<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '899109640119560']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=899109640119560&amp;ev=PixelInitialized" /></noscript>

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
                  case "admin":
                    include "header_nav_admin.php";
                    break;
                  default:
                    include "header_nav_public.php";
                }
              ?>
						</ul>
					</nav>

			</header>
