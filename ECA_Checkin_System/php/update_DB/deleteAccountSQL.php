<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 2){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
		exit;
	}

	if($_POST['deleteSubmit']){
		echo "<script>alert('true')</script>";
	}

	include_once(realpath("../DB_Conf.php"));
	include_once(realpath("../DB_Class.php"));
	$db = new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$deleteUsername = $_POST['select-option-deletename'];
	$sql = sprintf("SELECT * FROM `ACCOUNT` WHERE username='%s'", mysql_real_escape_string($deleteUsername));
	$db->query($sql);
	$result = $db->fetch_array();
	$deleteName = $result['name'];
?>