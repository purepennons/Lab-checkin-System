<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 3){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
		exit;
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
	$buttonFlag = $_POST['leave-search'];
	$chooseDate = $_POST['datepicker'];
	$leaveText = $_POST['leave-textarea'];
	if($buttonFlag=='search'){
		$_SESSION['sessiondate'];
		echo "<script>alert('search')</script>";
		
	}else if($buttonFlag=='leave'){
		if(empty($_POST['leave-textarea']) || empty($_POST['datepicker'])){
			echo "<script>alert('請假事由與請假日期皆不可為空。')</script>";
			echo "<script>document.location.href='GeneralUserIndex.php'</script>";
			exit;
		}
		$sql = sprintf("SELECT '%s' > curdate()", mysql_real_escape_string($chooseDate));
		$flag = $db->query($sql);
		$result = $db->fetch_array();
		if(!$result[0]){
			echo "<script>alert('已過時間，不可補請假。')</script>";
			echo "<script>document.location.href='GeneralUserIndex.php'</script>";
			exit;
		}
		$sql = sprintf("INSERT INTO RECORD(username, name, status, record_date, record_time, ip) VALUES ('%s','%s', '%d', curdate(), curtime(), '%s')",
				mysql_real_escape_string($_SESSION['sessionusername']), mysql_real_escape_string($_SESSION['sessionname']), 3, mysql_real_escape_string($_SESSION['sessionUserIP']));
		$flag = $db->query($sql);
		$sql = sprintf("INSERT INTO `LEAVE_RECORD`(`username`, `content`, `leave_date`) VALUES ('%s','%s', '%s')", mysql_real_escape_string($_SESSION['sessionusername']), mysql_real_escape_string($leaveText), mysql_real_escape_string($chooseDate));
 		$flag = $db->query($sql);
		echo "<script>alert('請假成功！')</script>";
		echo "<script>document.location.href='GeneralUserIndex.php'</script>";
		exit;
	}else{
		echo "<script>document.location.href='GeneralUserIndex.php'</script>";
		exit;
	}
?>