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
	$sql = sprintf("SELECT * FROM RECORD WHERE record_date=curdate() AND record_time=(SELECT MAX(record_time) FROM RECORD WHERE username='%s' AND status!=3)", $_SESSION['sessionusername']);
	$db->query($sql);
	$result = $db->fetch_array();
	$checkStatus = $result['status'];
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
 		<p class="text-right" >當前使用者：<?php echo $_SESSION['sessionusername']?>&nbsp&nbsp<a href="../login/Logout.php">登出</a></p>
 		<div class="content">
			<div class="jumbotron">
				<div class="row">
					<div class="col-md-8">
						<h2 id="system-date"></h2>
	  					<h1 id="system-time"></h1>
					</div>
  					<div class="col-md-4">
	    				<?php 
	  						if($checkStatus!=1){
								echo '<p><a class="btn btn-lg btn-block btn-warning pull-right" role="button" href="checkin.php">Check in&nbsp <span class="glyphicon glyphicon-info-sign"></span>
	  					</a></p>';
								echo '<p><a class="btn btn btn-info btn-lg btn-block pull-right" role="button" disabled="disabled">
  								Check out&nbsp <span class="glyphicon glyphicon-ban-circle"></span></a></p>';
							}else {
								echo '<a class="btn btn-lg btn-block btn-success pull-right" role="button" disabled="disabled" href="checkin.php">Check in&nbsp <span class="glyphicon glyphicon-ok-sign"></span>
	  					</a>';
								echo '<p><a class="btn btn btn-lg btn-block btn-warning pull-right" role="button">
  								Check out&nbsp <span class="glyphicon glyphicon-info-sign"></span></a></p>';
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
        					<li class="active"><a href="#today-records" data-toggle="tab">今日記錄</a></li>
        					<li><a href="#week-records" data-toggle="tab">一週記錄</a></li>
        					<li><a href="#leave" data-toggle="tab">請假</a></li>
        				</ul>
      					<div id="eca-tabs-content" class="tab-content">
        					<div class="tab-pane fade in active" id="today-records">
          						<p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
        					</div>
        					<div class="tab-pane fade" id="week-records">
          						<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
        					</div>
        					<div class="tab-pane fade" id="leave">
          						<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
        					</div>
      					</div>
					</div>
					<div class="col-md-4">
						<div id="datepicker-parent">
							<div id="datepicker"></div>
							<script>
								$( "#datepicker" ).datepicker();
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>    
</div> 
<script type="text/javascript" src="../../js/action.js"></script>
</body>
</html>