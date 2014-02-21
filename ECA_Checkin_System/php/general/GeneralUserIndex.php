<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 3){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
		exit;
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

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<!-- other CSS -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css">

	<!-- jQuery -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!-- 	<link rel="stylesheet" href="/resources/demos/style.css"> -->
<!-- 
	<script>
		$(function() {
			$( "#datepicker" ).datepicker();
		});
	</script>
 -->
</head>
<body>
	<div class="container">
<!-- 		<a href="../login/Logout.php">登出</a>
 --><!-- 		<p>Date: <input type="text" id="datepicker"></p>
 -->
<!--  		<table class="table">
 			<thead>
 				<tr>
 					<th></th>
 					<th>08:00</th><th>08:30</th><th>09:00</th><th>09:30</th><th>10:00</th><th>10:30</th><th>11:00</th>
 					<th>11:30</th><th>12:00</th><th>12:30</th><th>13:00</th><th>13:30</th><th>14:00</th><th>14:30</th>
 					<th>15:00</th><th>15:30</th><th>16:00</th><th>16:30</th><th>17:00</th><th>17:30</th><th>18:00</th>
 				</tr>
 			</thead>
 			<tbody>
 				<tr>
 					<th></th>
 					<td></td>
 					<td></td>
 					<td></td>

 				</tr>
 			</tbody>
 		</table>
 -->
		<div class="jumbotron">
			<div class="row">
				<div class="col-md-8">
	  				<h1>PM 11:30:44</h1>
				</div>
  				<div class="col-md-4">
  					<p><a class="btn btn-primary btn-lg btn-block pull-right" role="button">Check in</a></p>
  					<p><a class="btn btn-primary btn-lg btn-block pull-right" role="button">Check out</a></p>  				
  				</div>
			</div>
		</div>
	</div>    
</div> 
</body>
</html>