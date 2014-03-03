<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 3){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
		exit;
	}
?>

<?php
	//status=1:checkin
	//status=2:checkout
	//status=3:leave
	include_once(realpath("../DB_Conf.php"));
    include_once(realpath("../DB_Class.php"));
    $db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $sql = sprintf("SELECT * FROM ACCOUNT WHERE username='%s'", mysql_real_escape_string($_SESSION['sessionusername']));
    $db->query($sql);
    $result = $db->fetch_array();
    $name = $_SESSION['sessionname'];
    //找出當天時間最新的特定會員資料 且status!=3
    $sql = sprintf("SELECT * FROM RECORD WHERE record_date=curdate() AND username='%s' AND record_time=(SELECT MAX(record_time) FROM RECORD WHERE username='%s' AND status!=3 AND record_date=curdate())", mysql_real_escape_string($_SESSION['sessionusername']), mysql_real_escape_string($_SESSION['sessionusername']));
    $db->query($sql);
    $result = $db->fetch_array();
	$checkStatus = $result['status'];
 	$sql = sprintf("SELECT curdate()");
 	$flag = $db->query($sql);
 	$result = $db->fetch_array();
 	$_SESSION['sessiondate'] = $result[0];
	if($checkStatus!=2){
 		$sql = sprintf("INSERT INTO RECORD(username, name, status, record_date, record_time, ip) VALUES ('%s','%s', '%d', curdate(), curtime(), '%s')", 
 				mysql_real_escape_string($_SESSION['sessionusername']), mysql_real_escape_string($name), 2, mysql_real_escape_string($_SESSION['sessionUserIP']));
 		$flag = $db->query($sql);
 		echo "<script>alert('Check out!')</script>";
 		echo "<script>document.location.href='GeneralUserIndex.php'</script>";
 		exit;
	}else {
		echo "<script>alert('你今天已經Check out或尚未Check in, 請先Check in後，才可以Check out。')</script>";
		echo "<script>document.location.href='GeneralUserIndex.php'</script>";
		exit;
	}
?>