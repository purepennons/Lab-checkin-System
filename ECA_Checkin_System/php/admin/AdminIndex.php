<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 2){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
	}
?>

<?php
//DB connect
	include_once(realpath("../DB_Conf.php"));
	include_once(realpath("../DB_Class.php"));
	$db = new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	if(empty($_SESSION['sessiondate'])){
		$sql = sprintf("SELECT curdate()");
		$db->query($sql);
		$result = $db->fetch_array();
		$_SESSION['sessiondate'] = $result[0];
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<!-- other CSS -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>
<body>
	<div class="container">
    </div>
	<div class="container">
        <p class="text-right" >當前使用者：<?php echo $_SESSION['sessionname']?> (管理員)&nbsp&nbsp<a href="../login/Logout.php">登出</a></p>
        <div class="content">
			<div class="jumbotron" id="inner-content1">
				<div class="row">
					<div class="col-md-6">
						<h2 id="system-date"></h2>
	  					<h1 id="system-time"></h1>
					</div>
  					<div class="col-md-6">
  						<div id="admin-jumbotron-right">
 						<form class="form-query" role="form" name="queryForm" method="post" action="adminQuery.php">
							<div class="input-group input-components adminInput">
  								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								<input class="form-control" placeholder="選擇記錄時間" type="text" id="datepicker" name="datepicker" value="">
							</div>
							<select class="form-control adminInput">
							    <option value="one">One</option>
							</select>
							<button class="btn btn-lg btn-info btn-block input-components adminInput" type="submit" name="leave-search" id="search-button" value="search">
								<span class="glyphicon glyphicon-search"></span>
								查詢									
							</button>
 						</form> 						
  						</div>
  					</div>
				</div>
			</div>
			<div id="inner-content2">
				<ul id="eca-tabs" class="nav nav-tabs">
					<li class="active"><a href="#one-day-records" data-toggle="tab">當日記錄</a></li>
					<li><a href="#week-records" data-toggle="tab">一週記錄</a></li>
					<li><a href="#leave" data-toggle="tab">請假記錄</a></li>
				</ul>
				<div id="eca-tabs-content" class="tab-content">
					<div class="tab-pane fade in active" id="one-day-records">
					a
					</div>
					<div class="tab-pane fade" id="week-records">  
				b                          
					</div>
					<div class="tab-pane fade" id="leave">
					c
					</div>
				</div>
			</div>        	
        </div>
    </div>
    <div class="container" id="footer">
    	<div class="row">
            <hr>
            <p class="text-right">2014 ECA LAB 使用<a target="_blank" href="http://getbootstrap.com">Bootstrap.</a>製作</p>
            <p class="text-right">建議使用<a target="_blank" href="https://www.google.com/intl/zh-TW/chrome/">Chrome</a>、<a target="_blank" href="http://moztw.org/firefox/">Firefox</a>或Internet Explorer 9 以上的瀏覽器瀏覽，以達最佳的瀏覽體驗。</p>
        </div>
    </div>
    <script type="text/javascript" src="../../js/action.js"></script>  
</body>
</html>