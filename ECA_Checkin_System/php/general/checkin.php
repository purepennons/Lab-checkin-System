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
    $name = $result['name'];
    $sql = sprintf("SELECT * FROM RECORD WHERE record_date=curdate() AND record_time=(SELECT MAX(record_time) FROM RECORD WHERE username='%s' AND status!=3)", $_SESSION['sessionusername']);
    $db->query($sql);
    $result = $db->fetch_array();
	$checkStatus = $result['status'];
	if($checkStatus!=1){
 		$sql = sprintf("INSERT INTO RECORD(username, name, status, record_date, record_time, ip) VALUES ('%s','%s', '%d', curdate(), curtime(), '%s')", 
 				mysql_real_escape_string($_SESSION['sessionusername']), $name, 1, $_SESSION['sessionUserIP']);
 		$flag = $db->query($sql);
	}else {
		echo "<script>alert('你今天已經Check in, 請先Check out後，才可以次Check in。')</script>";
		echo "<script>document.location.href='../../index.php'</script>";
		exit;
	}
?>