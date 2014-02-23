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

   	<!-- jQuery -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<!-- other CSS -->
	<link href="css/signin.css" rel="stylesheet">

</head>
<body>
	<div class="container">
    	<form class="form-signin" role="form" name="loginForm" method="post" action="php/login/checkLogin.php">
    		<h2 class="form-signin-heading">Please sign in.</h2>
    		<input name="username" id="username" type="text" class="form-control" placeholder="Username" required autofocus>
    		<input name="password" id="password" type="password" class="form-control" placeholder="Password" required>
<!--     		<label class="checkbox">
        		<input type="checkbox" value="remember-me"> Remember me
        	</label>
 -->        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
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