<?php
	session_start(); 
	if(!empty($_SESSION['sessionusername'])){
		if($_SESSION['sessionlevel'] > 2){
			//echo "<meta http-equiv='refresh' content=;0;URL＝../general/GeneralUserIndex.php'>";
			//echo 'general';
			header('Location:php/general/GeneralUserIndex.php');
		}else {
			//echo "<meta http-equiv='refresh' content=;0;URL=../admin/AdminIndex.php'>";
			//echo 'admin';
			header('Location:php/admin/AdminIndex.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>ECA Checkin</title>
	<noscript>
		你的瀏覽器不支援javascript
	</noscript>
	<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
    </script>
    <![endif]-->

    <link rel="shortcut icon"href="../../images/logo.ico">

   	<!-- jQuery -->
	<link rel="stylesheet" href="jquery/css/jquery-ui.css">
	<script src="jquery/js/jquery-1.9.1.js"></script>
	<script src="jquery/js/jquery-ui.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>	

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- Optional theme -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

	<!-- other CSS -->
	<link href="css/signin.css" rel="stylesheet">

	<!-- other js -->
	<script src="js/sha1.js" type="text/javascript"></script>
	<script type="text/javascript">
		//加密
		function encoder() {
			var ps = document.getElementById('password');
			ps.value = SHA1(ps.value);
		}
	</script>


</head>
<body>
	<div class="container">
    	<form class="form-signin" role="form" name="loginForm" method="post" action="php/login/checkLogin.php">
    		<h2 class="form-signin-heading"><p>ECA LAB</p> <p>Check in System</p></h2>
    		<input name="username" id="username" type="text" class="form-control" placeholder="Username" required autofocus>
    		<input onchange="encoder()" name="password" id="password" type="password" class="form-control" placeholder="Password" required>
	        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
    <div class="container" id="footer">
    	<div class="row">
            <hr>
            <p class="text-right">2014 ECA LAB 使用<a target="_blank" href="http://getbootstrap.com">Bootstrap.</a>製作</p>
            <p class="text-right">建議使用<a target="_blank" href="https://www.google.com/intl/zh-TW/chrome/">Chrome</a>、<a target="_blank" href="http://moztw.org/firefox/">Firefox</a>或Internet Explorer 9 以上的瀏覽器瀏覽，以達最佳的瀏覽體驗。</p>
        </div>
    </div>
</body>
</html>