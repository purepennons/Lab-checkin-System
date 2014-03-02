<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 3){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
		exit;
	}

	include_once(realpath("../DB_Conf.php"));
	include_once(realpath("../DB_Class.php"));
	$db = new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<!-- Optional theme -->
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap-theme.min.css">

	<!-- other CSS -->
	<link href="../../css/signin.css" rel="stylesheet">
	<link href="../../css/style.css" rel="stylesheet">

	<!-- other js -->
<!-- 	 <script src="js/sha1.js" type="text/javascript"></script> -->
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
    	<form id="chageInfo" class="form-signin" role="form" name="changeInfoForm" method="post" action="">
    		<h2 class="form-signin-heading">個人資料修改：</h2>
    		<input name="username" id="username" type="text" class="form-control" placeholder="Username" disabled>
    		<input name="name" id="name" type="text" class="form-control" placeholder="Name" required>
    		<input onchange="encoder()" name="origin-password" id="origin-password" type="password" class="form-control" placeholder="Original Password" required>
    		<input onchange="encoder()" name="new-password" id="new-password" type="password" class="form-control" placeholder="New Password" required>
    		<input onchange="encoder()" name="confirm-password" id="confirm-password" type="password" class="form-control" placeholder="Confirm Password" required>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
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
