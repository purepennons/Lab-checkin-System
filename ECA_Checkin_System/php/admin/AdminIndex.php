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
                         "<div class='colorfulCircle' id='checkin-circle'></div>", 
                         "<div class='colorfulCircle' id='checkout-circle'></div>",
                         "<div class='colorfulCircle' id='leave-circle'></div>");
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
		$userList[$i][0] = $tempUsername;
		$userList[$i][1] = $tempName;
		if(empty($_SESSION['sessionChooseUsername']) && $i==0){
			$_SESSION['sessionChooseUsername'] = $tempUsername;
			$_SESSION['sessionChooseName'] = $tempName;
		}
		$i++;
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
	<link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>
<body>
	<div class="container">
        <span id="header-icon"><a href="../update_DB/addAccount.php"> &nbsp <span class="glyphicon glyphicon-plus"></span></a> &nbsp <a href="../update_DB/changeInfo.php"> &nbsp <span class="glyphicon glyphicon-wrench"></span></a> &nbsp&nbsp <a href="../login/Logout.php"> &nbsp<span class="glyphicon glyphicon-log-out"></span></a></span>
 		<p class="text-left" >  &nbsp 當前管理員：<?php echo $_SESSION['sessionname']?></p>
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
								<input class="form-control" placeholder="選擇記錄時間" type="text" id="datepicker" name="datepicker" value="<?php echo $_SESSION['sessiondate']?>">
							</div>
							<select class="form-control adminInput" name="select-option-name">
							    <?php 
							    	echo '<option value="'.$_SESSION['sessionChooseUsername'].'">'.$_SESSION['sessionChooseName'].'</option>';
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
						<div id="admin-one-day-record-table">
                        <p>當前查詢日期:&nbsp<?php echo $date_end?></p>
						<div id="admin-one-day-record-table">
	                        <table class="table table-bordered table-condensed table-hover table-responsive">
								<thead>
									<tr>
										<th>時間<br>\姓名</th>
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
										for($i=0;$i<$numOfUserList;$i++){
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
	                                        $leaveFlagArray = array();
											$sql = sprintf("SELECT * FROM `RECORD` WHERE record_date = '%s' AND username = '%s' AND status != 3 AND record_time >= '08:00:00' AND record_time <= '18:00:00' ORDER BY record_date, record_time", mysql_real_escape_string($date_end), mysql_real_escape_string($userList[$i][0]));																					
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
	                                        $sql = sprintf("SELECT * FROM `RECORD` WHERE leave_date = '%s' AND username='%s' AND status=3", mysql_real_escape_string($date_end), mysql_real_escape_string($userList[$i][0]));
	                                        $db->query($sql);
	                                        $leaveFlagArray[$i] = 0;
	                                        while($result = $db->fetch_array()){
	                                            $leaveFlagArray[$i] = $result['status'];
	                                        }                                        	
	                                        echo 
	                                            '<tr>'
	                                                .'<td>' .$userList[$i][1]. '</td>'
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
	                                                .'<td>' .$colorCircle[$leaveFlagArray[$i]].'</td>'                                                                               
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
									<td class="color-demo"><div class="colorfulCircle" id="checkin-circle"></div></td><td>Check in</td>
									<td class="color-demo"><div class="colorfulCircle" id="checkout-circle"></div></td><td>Check out</td>
									<td class="color-demo"><div class="colorfulCircle" id="leave-circle"></div></td><td>Leave</td>
								    <td>&nbsp &nbsp備註：</td><td> 查詢區間為查詢日期往前六天</td>
                                </tr>
							</tbody>
						</table>
						</div>
					</div>
					<div class="tab-pane fade" id="week-records">  
                        <?php
                            $sql = sprintf("SELECT INTERVAL '%d' DAY + '%s'", -6, $date_end);
                            $db->query($sql);
                            $result = $db->fetch_array();
                            $dateStart = $result[0];
                        ?>
                        <p>當前查詢日期區間:&nbsp<?php echo $dateStart?>&nbsp ~ &nbsp<?php echo $date_end?></p>
                        <p>姓名:<?php echo $_SESSION['sessionChooseName']?></p>
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
	                                        $sql = sprintf("SELECT * FROM `RECORD` WHERE record_date = '%s' AND username = '%s' AND status != 3 AND record_time >= '08:00:00' AND record_time <= '18:00:00' ORDER BY record_date, record_time", mysql_real_escape_string($date_start), mysql_real_escape_string($_SESSION['sessionChooseUsername']));
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
	                                        $sql = sprintf("SELECT * FROM `RECORD` WHERE leave_date = '%s' AND username='%s' AND status=3", mysql_real_escape_string($date_start), mysql_real_escape_string($_SESSION['sessionChooseUsername']));
	                                        $db->query($sql);
	                                        $leaveFlag = 0;
	                                        while($result = $db->fetch_array()){
	                                            $leaveFlag = $result['status'];
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
	                                                .'<td>' .$colorCircle[$leaveFlag].'</td>'                                                                               
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
									<td class="color-demo"><div class="colorfulCircle" id="checkin-circle"></div></td><td>Check in</td>
									<td class="color-demo"><div class="colorfulCircle" id="checkout-circle"></div></td><td>Check out</td>
									<td class="color-demo"><div class="colorfulCircle" id="leave-circle"></div></td><td>Leave</td>
								    <td>&nbsp &nbsp備註：</td><td> 查詢區間為查詢日期往前六天</td>
                                </tr>
							</tbody>
						</table>                                				                          
					</div>
					<div class="tab-pane fade" id="leave">
                        <?php
                            $sql = sprintf("SELECT INTERVAL '%d' DAY + '%s', INTERVAL '%d' DAY + '%s'", -7, $date_end, 7, $date_end);
                            $db->query($sql);
                            $result = $db->fetch_array();
                            $dateStart = $result[0];
                            $dateEnd = $result[1];
                        ?>
                        <p>當前查詢日期區間:&nbsp<?php echo $dateStart?>&nbsp ~ &nbsp<?php echo $dateEnd?></p>						
                        <div id="leave-table">
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>#</th><th>姓名</th><th>請假日期</th><th>記錄日期</th><th>記錄時間</th><th>請假事由</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
	                                $counter = 0;                                
                                	for($i=0;$i<15;$i++) {
                                        $sql = sprintf("SELECT INTERVAL '%d' DAY + '%s'", (7-$i), $date_end);
                                        $db->query($sql);
                                        $result = $db->fetch_array();
                                        $date_start = $result[0];
	                                    $sql = sprintf("SELECT * FROM `RECORD` WHERE leave_date='%s' AND status=3 ORDER BY leave_date DESC, record_date DESC, name", mysql_real_escape_string($date_start));
	                                    $db->query($sql);
	                                    while($result = $db->fetch_array()){
	                                        $counter++;
	                                        $leaveContent = $result['content'];
	                                        echo 
	                                           '<tr>'
	                                              .'<td>' .$counter.   '</td>'
	                                              .'<td>' .$result['name']. '</td>'
	                                              .'<td>' .$result['leave_date']. '</td>'
	                                              .'<td>' .$result['record_date']. '</td>'
	                                              .'<td>' .$result['record_time']. '</td>'
	                                              .'<td>' .'<a href="#" data-toggle="tooltip"data-original-title="'.$leaveContent.'"><span class="glyphicon glyphicon-comment"></a>'.'</td>'
	                                         . '</tr>';
	                                    }                
	                                }                            
                                ?>
                            </tbody>
                        </table>
                        <table>
                            <tbody>
                                <tr>
                                    <td>&nbsp &nbsp備註1：</td><td> 鼠標移到<span class="glyphicon glyphicon-comment" style="color:#428bca"></span>可顯示請假事由</td>                                        
                                    <td></td><td></td>
                                    <td></td><td></td>
                                    <td></td><td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp &nbsp備註2：</td><td>查詢區間為查詢日期前後一週</td>                                        
                                    <td></td><td></td>
                                    <td></td><td></td>
                                    <td></td><td></td>
                                </tr>                                
                            </tbody>
                        </table>                                                                
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