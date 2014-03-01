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
?>

<?php
	if(empty($_SESSION['sessiondate'])){
		$sql = sprintf("SELECT curdate()");
		$db->query($sql);
		$result = $db->fetch_array();
		$_SESSION['sessiondate'] = $result[0];
	}	
?>

<?php 
    $colorCircle = array("", 
                         "<div class='colorfulCircle' id='info-circle'></div>", 
                         "<div class='colorfulCircle' id='success-circle'></div>",
                         "<div class='colorfulCircle' id='warning-circle'></div>");
    $date_end = $_SESSION['sessiondate'];
?>

<?php 
	//user list (priority=3)
	$sql = sprintf("SELECT `username`, `name` FROM `ACCOUNT` WHERE priority=3");
	$db->query($sql);
	$userList = array(array());
	$i = 0;
	while (	$result = $db->fetch_array() ) {
		$tempUsername = $result['username'];
		$tempName = $result['name'];
		if(empty($_SESSION['sessionChooseUsername']) && $i=0){
			$_SESSION['sessionChooseUsername'] = $tempUsername;
		}
		$userList[$i][0] = $tempUsername;
		$userList[$i][1] = $tempName;
		$i++;
	}
	$p = $_SESSION['sessionChooseUsername'];
	$numOfUserList = count($userList);
	echo "<script>alert('$p')</script>";
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
							<select class="form-control adminInput" name="select-option-name">
							    <?php 
							    	for($i=0;$i<$numOfUserList;$i++){
							    		echo '<option value="'.$userList[$i][0].'">'.$userList[$i][1].'</option>';
							    	}
							    ?>							    
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
                        <?php
                            $sql = sprintf("SELECT INTERVAL '%d' DAY + '%s'", -6, $date_end);
                            $db->query($sql);
                            $result = $db->fetch_array();
                            $dateStart = $result[0];
                        ?>
                        <p>當前查詢日期區間:&nbsp<?php echo $dateStart?>&nbsp ~ &nbsp<?php echo $date_end?></p>
						<div id="admin-week-record-table">
                        <table class="table table-bordered table-condensed table-hover table-responsive">
							<thead>
								<tr>
									<th>時間<br>\日期</th>
									<th>08:00</th><th>08:30</th><th>09:00</th>
									<th>09:30</th><th>10:00</th><th>10:30</th>
									<th>11:00</th><th>11:30</th><th>12:00</th>
									<th>12:30</th><th>13:00</th>
								 	<th>13:30</th><th>14:00</th><th>14:30</th>
			 						<th>15:00</th><th>15:30</th><th>16:00</th>
			 						<th>16:30</th><th>17:00</th><th>17:30</th>
			 						<th>18:00</th><th class="isLeave">Leave</th>
								<tr>
							</thead>
							<tbody>
                                <?php
                                    for($i=0;$i<7;$i++){
                                        $timeMapping1 = array('08'=>array(0, 0),
                                                              '09'=>array(0, 0),
                                                              '10'=>array(0, 0),
                                                              '11'=>array(0, 0),
                                                              '12'=>array(0, 0),
                                                              '13'=>array(0, 0),
                                                              '14'=>array(0, 0),
                                                              '15'=>array(0, 0),
                                                              '16'=>array(0, 0),
                                                              '17'=>array(0, 0),
                                                              '18'=>array(0, 0));  //顯示區域與時間映射
                                        $sql = sprintf("SELECT INTERVAL '%d' DAY + '%s'", ((-6)+$i), $date_end);
                                        $db->query($sql);
                                        $result = $db->fetch_array();
                                        $date_start = $result[0];
                                        $sql = sprintf("SELECT * FROM `RECORD` WHERE record_date = '%s' AND username = '%s' AND status != 3 AND record_time >= '08:00:00' AND record_time <= '18:00:00' ORDER BY record_date, record_time", mysql_real_escape_string($date_start), mysql_real_escape_string($_SESSION['sessionusername']));
                                        $db->query($sql);
                                        while($result = $db->fetch_array()){
                                            $recordTime = $result['record_time'];
                                            $subTimeHour = substr($recordTime, 0, 2);
                                            $subTimeMin = substr($recordTime, 2, 2);
                                            $minMapping = 0;
                                            if($subTimeMin>=30){
                                                $minMapping = 1;
                                            }
                                            $timeMapping1[$subTimeHour][$minMapping] = $result['status'];
                                        }

                                        echo 
                                            '<tr>'
                                                .'<td>' .$date_start. '</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['08'][0]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['08'][1]]. '</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['09'][0]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['09'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['10'][0]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['10'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['11'][0]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['11'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['12'][0]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['12'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['13'][0]].'</td>'                          
                                                .'<td>' .$colorCircle[$timeMapping1['13'][1]].'</td>'                                                                          
                                                .'<td>' .$colorCircle[$timeMapping1['14'][0]].'</td>'                          
                                                .'<td>' .$colorCircle[$timeMapping1['14'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['15'][0]].'</td>'                          
                                                .'<td>' .$colorCircle[$timeMapping1['15'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['16'][0]].'</td>'                          
                                                .'<td>' .$colorCircle[$timeMapping1['16'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['17'][0]].'</td>'                          
                                                .'<td>' .$colorCircle[$timeMapping1['17'][1]].'</td>'
                                                .'<td>' .$colorCircle[$timeMapping1['18'][0]].'</td>'                          
                                                .'<td>' .$colorCircle[$timeMapping1['18'][1]].'</td>'                                                                               
                                            .'</tr>';
                                    } 
                                ?>                                        
							</tbody>       							
						</table>
						<hr>
                        </div>                                
						<table>
							<tbody>
								<tr>
									<td class="color-demo"><div class="colorfulCircle" id="info-circle"></div></td><td>Check in</td>
									<td class="color-demo"><div class="colorfulCircle" id="success-circle"></div></td><td>Check out</td>
									<td class="color-demo"><div class="colorfulCircle" id="warning-circle"></div></td><td>Leave</td>
								    <td>&nbsp &nbsp備註：</td><td> 查詢區間為查詢日期往前六天</td>
                                </tr>
							</tbody>
						</table>                                				                          
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