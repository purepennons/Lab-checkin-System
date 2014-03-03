<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 2){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
		exit;
	}

	include_once(realpath("../DB_Conf.php"));
	include_once(realpath("../DB_Class.php"));
	$db = new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

?>

<?php 
	$sql = sprintf("SELECT * FROM ACCOUNT WHERE username='%s'", $_SESSION['sessionusername']);
	$db->query($sql);
	$result = $db->fetch_array();
	$curUsername = $result['username'];
	$curName = $result['name'];
?>

<?php 
	//user list (priority=3)
	$sql = sprintf("SELECT `username`, `name`, `priority` FROM `ACCOUNT`");
	$db->query($sql);
	$userList = array(array());
	$i = 0;
	while (	$result = $db->fetch_array() ) {
		$tempUsername = $result['username'];
		$tempName = $result['name'];
		$tempPriority = $result['priority'];
		if($tempUsername != $curUsername){
			$userList[$i][0] = $tempUsername;
			$userList[$i][1] = $tempName;
			$userList[$i][2] = $tempPriority;
			$i++;
		}
	}
	$numOfUserList = count($userList);
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
	<link rel="stylesheet" href="../../jquery/css/jquery-ui.css">
	<script src="../../jquery/js/jquery-1.9.1.js"></script>
	<script src="../../jquery/js/jquery-ui.js"></script>

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

</head>
<body>
	<div class="container">
    	<form id="deleteAccount" class="form-signin" role="form" name="deleteAccountForm" method="post" action="deleteAccountSQL.php">
    		<h2 class="form-signin-heading">刪除帳號</h2>
				<select class="form-control adminInput" name="select-option-deletename" id="select-option-deletename">
				    <?php
				    	$priorityMapping = array(2=>'管理員', 3=>'一般使用者'); 
				    	for($i=0;$i<$numOfUserList;$i++){
				    		echo '<option value="帳號為'.$userList[$i][0].'且姓名為'.$userList[$i][1].'">'.$userList[$i][1].'('.$priorityMapping[$userList[$i][2]].')'. '</option>';
				    	}
				    ?>							    
				</select>
			<button onclick="return confirm('確定刪除' + document.getElementById('select-option-deletename').value + '之帳號嗎?');"  class="btn btn-lg btn-primary btn-block" type="submit" name="deleteSubmit">Delete</button>
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
