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
	<link rel="stylesheet" type="text/css" href="../../css/style.css">

<!-- 	<link rel="stylesheet" href="/resources/demos/style.css"> -->
</head>
<body>
	<div class="container">
<!-- 		<a href="../login/Logout.php">登出</a>
 --><!-- 		 -->
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
 		<p class="text-right" >當前使用者：<?php echo $_SESSION['sessionname']?> &nbsp&nbsp<a href="../login/Logout.php">登出</a></p>
 		<div class="content">
			<div class="jumbotron">
				<div class="row">
					<div class="col-md-8">
						<h2 id="system-date"></h2>
	  					<h1 id="system-time"></h1>
					</div>
  					<div class="col-md-4">
	    				<?php 
	    					$sql = sprintf("SELECT * FROM RECORD WHERE record_date=curdate() AND record_time=(SELECT MAX(record_time) FROM RECORD WHERE username='%s' AND status!=3)", mysql_real_escape_string($_SESSION['sessionusername']));
							$db->query($sql);
							$result = $db->fetch_array();
							$checkStatus = $result['status'];
	  						if($checkStatus!=1){
								echo '<p><a class="btn btn-lg btn-block btn-warning pull-right" role="button" href="checkin.php"><span class="glyphicon glyphicon-info-sign"></span> Check in &nbsp
	  					</a></p>';
								echo '<p><a class="btn btn btn-primary btn-lg btn-block pull-right" role="button" disabled="disabled" href="checkout.php">
  								<span class="glyphicon glyphicon-ban-circle"></span> Check out</a></p>';
							}else {
								echo '<a class="btn btn-lg btn-block btn-success pull-right" role="button" disabled="disabled" href="checkin.php"><span class="glyphicon glyphicon-ok-sign"></span> Check in &nbsp
	  					</a>';
								echo '<p><a class="btn btn btn-lg btn-block btn-warning pull-right" role="button" href="checkout.php">
  								<span class="glyphicon glyphicon-info-sign"></span> Check out </a></p>';
							}
	  					?>
  						<p>

  						</p>  				
  					</div>
				</div>
			</div>
			<div class="row" id="bottom-content">
				<div id="record-content">
					<div class="col-md-8">
      					<ul id="eca-tabs" class="nav nav-tabs">
        					<li class="active"><a href="#one-day-records" data-toggle="tab">當日記錄</a></li>
        					<li><a href="#week-records" data-toggle="tab">一週記錄</a></li>
        					<li><a href="#leave" data-toggle="tab">請假</a></li>
        				</ul>
      					<div id="eca-tabs-content" class="tab-content">
        					<div class="tab-pane fade in active" id="one-day-records">
        						<p>當前查詢日期：<?php echo $_SESSION['sessiondate']?></p>
        						<table class="table">
        							<thead>
        								<tr>
        									<th>＃</th><th>狀態</th><th>記錄日期</th><th>記錄時間</th><th>登入IP</th><th>請假日期</th>
        								</tr>
        							</thead>
        							<tbody>
        								<?php
        									$sql = sprintf("SELECT * FROM `RECORD` WHERE username='%s' AND record_date='%s'", mysql_real_escape_string($_SESSION['sessionusername']), mysql_real_escape_string($_SESSION['sessiondate']));
        									$db->query($sql);
        									$counter = 0;
        									while($result = $db->fetch_array()){
        										$counter++;
        										$statusText = array('Check in', 'Check out', 'Leave');
        										$statusNum = $result[3] - 1;
        										$tableRowColor = array('<tr class="info">', '<tr class="success">', '<tr class="warning">');
        										echo 
        											$tableRowColor[$statusNum] //<tr>
        											  .'<td>' .$counter.   '</td>'
        											  .'<td>' .$statusText[$statusNum]. '</td>'
        											  .'<td>' .$result[4]. '</td>'
        											  .'<td>' .$result[5]. '</td>'
        											  .'<td>' .$result[6]. '</td>'
        											  .'<td>' .$result[7]. '</td>'        					
        										 . '</tr>';
        									}
        								?>
        							</tbody>
        						</table>
        						<table>
        							<tbody>
        								<tr>
        									<td class="color-demo"><div class="colorfulCircle" id="info-circle"></div></td><td>Check in</td>
        									<td class="color-demo"><div class="colorfulCircle" id="success-circle"></div></td><td>Check out</td>
        									<td class="color-demo"><div class="colorfulCircle" id="warning-circle"></div></td><td>Leave</td>
        								</tr>
        							</tbody>
        						</table>
        					</div>
        					<div class="tab-pane fade" id="week-records">
        						<?php 
        						?>
        						<table class="table table-bordered">
        							<thead>
        								<tr>
        									<th>日期\時間</th>
 											<th>08:00</th><th>08:30</th><th>09:00</th>
 											<th>09:30</th><th>10:00</th><th>10:30</th>
 											<th>11:00</th><th>11:30</th><th>12:00</th>
 											<th>12:30</th><th>13:00</th>
        								<tr>
        							</thead>
        							<tbody>
        							</tbody>       							
        						</table>
        						<hr>
        						<table class="table table-bordered">
        							<thead>
        								<tr>
        									<th>日期\時間</th>
 											<th>13:30</th><th>14:00</th><th>14:30</th>
					 						<th>15:00</th><th>15:30</th><th>16:00</th>
					 						<th>16:30</th><th>17:00</th><th>17:30</th>
					 						<th>18:00</th><th>18:30</th>
        								<tr>
        							</thead>
        							<tbody>
        							</tbody> 
        						</table>
        						<table>
        							<tbody>
        								<tr>
        									<td class="color-demo"><div class="colorfulCircle" id="info-circle"></div></td><td>Check in</td>
        									<td class="color-demo"><div class="colorfulCircle" id="success-circle"></div></td><td>Check out</td>
        									<td class="color-demo"><div class="colorfulCircle" id="warning-circle"></div></td><td>Leave</td>
        								</tr>
        							</tbody>
        						</table>
        					</div>
        					<div class="tab-pane fade" id="leave">
        					</div>
      					</div>
					</div>
					<div class="col-md-4">
 						<form class="form-leave" role="form" name="leaveForm" method="post" action="leaveOrSearch.php">
							<textarea class="form-control input-components" rows="5" placeholder="請假事由：" id="leave-textarea" name="leave-textarea" value=""></textarea>
							<div class="input-group input-components">
  								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								<input class="form-control" placeholder="選擇請假日期或記錄時間" type="text" id="datepicker" name="datepicker" value="">
							</div>
							<button class="btn btn-lg btn-info btn-block input-components" type="submit" name="leave-search" id="search-button" value="search">
								<span class="glyphicon glyphicon-search"></span>
								查詢									
							</button>
							<button class="btn btn-lg btn-success btn-block input-components" type="submit" name="leave-search" id="leave-button" value="leave">
								<span class="glyphicon glyphicon-pushpin"></span>
								請假									
 							</button>
 						</form>
					</div>
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