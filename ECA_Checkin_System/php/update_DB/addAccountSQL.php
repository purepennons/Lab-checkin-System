<?php 
	session_start();
	if(empty($_SESSION['sessionusername']) || $_SESSION['sessionlevel'] > 2){
		echo "尚未登入或無權限觀看此頁面，3秒後跳轉回首頁。";
		echo"<meta http-equiv='refresh' content='3;URL=../../index.php'>";
		exit;
	}

	include_once(realpath("../DB_Conf.php"));
	include_once(realpath("../DB_Class.php"));
	$db = new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$addUsername = $_POST['username'];
    $addName = $_POST['name'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];
    $priority = $_POST['priority'];
    $addUsername = stripslashes($addUsername);
    $addName = stripslashes($addName);
	$newPassword = stripslashes($newPassword);
	$confirmPassword = stripslashes($confirmPassword);
	$priority = stripslashes($priority);
    $sql = sprintf("SELECT * FROM ACCOUNT WHERE username='%s'", mysql_real_escape_string($addUsername));
    $db->query($sql);
    $result = $db->fetch_array();
	if($result){
		echo "<script>alert('Username exist!')</script>";
		echo "<script>history.go(-1)</script>";
		exit;
	}else {
		if($newPassword != $confirmPassword){
			echo "<script>alert('New password is not matched with confirm password!')</script>";
			echo "<script>history.go(-1)</script>";
			exit;
		}else {
			$sql = sprintf("INSERT INTO `ACCOUNT`(`username`, `name`, `password`, `priority`) VALUES ('%s','%s','%s', %d)", mysql_real_escape_string($addUsername), mysql_real_escape_string($addName), mysql_real_escape_string($newPassword), mysql_real_escape_string($priority));
			$db->query($sql);
			echo "<script>alert('Add a new account, success!')</script>";	
			echo "<script>document.location.href='../../index.php'</script>";
			exit;										
		}
	}
?>