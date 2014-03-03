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
    $changename = $_POST['name'];
    $originPassword = $_POST['origin-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];
    $changename = stripslashes($changename);
	$originPassword = stripslashes($originPassword);
	$newPassword = stripslashes($newPassword);
	$confirmPassword = stripslashes($confirmPassword);
    $sql = sprintf("SELECT * FROM ACCOUNT WHERE username='%s' AND password='%s'", mysql_real_escape_string($_SESSION['sessionusername']), mysql_real_escape_string($originPassword));
    $db->query($sql);
    $result = $db->fetch_array();
	if($result){
		if($newPassword == "" ^ $confirmPassword == ""){
			//新密碼或新密碼確認其中一欄未填寫
			echo "<script>alert('New Password or Confirm Password is Null!')</script>";
			echo "<script>history.go(-1)</script>";
			exit;
		}else {
			if($newPassword == "" && $confirmPassword == ""){ //新密碼與密碼確認皆未填寫，執行姓名更新
				$sql = sprintf("UPDATE `ACCOUNT` SET `name`= '%s' WHERE username='%s'", mysql_real_escape_string($changename), mysql_real_escape_string($_SESSION['sessionusername']));
				$db->query($sql);
				$_SESSION['sessionname'] = $changename;
				echo "<script>alert('Name has been updated!')</script>";	
				echo "<script>document.location.href='../../index.php'</script>";	
				exit;						
			}else {  
				if($newPassword != $confirmPassword){
					echo "<script>alert('New password is not matched with confirm password!')</script>";
					echo "<script>history.go(-1)</script>";
					exit;
				}else {		//新密碼與密碼確認皆填寫，執行密碼修改
					$sql = sprintf("UPDATE `ACCOUNT` SET `name`='%s',`password`='%s' WHERE username='%s'", mysql_real_escape_string($changename), mysql_real_escape_string($newPassword), mysql_real_escape_string($_SESSION['sessionusername']));
					$db->query($sql);
					$_SESSION['sessionname'] = $changename;
					echo "<script>alert('Password and Name have been changed!')</script>";	
					echo "<script>document.location.href='../../index.php'</script>";
					exit;							
				}

			}
		}
	}else {
		echo "<script>alert('密碼錯誤')</script>";
		echo "<script>history.go(-1)</script>";
		exit;
	}
?>