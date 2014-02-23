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
	echo "<script>alert('$buttonFlag')</script>";
	// if($buttonFlag=='search'){
	// 	echo "<script>alert('search')</script>";
		
	// }else if($buttonFlag=='leave'){
	// 	echo "<script>alert('leave')</script>";
	// }else{
	// 	echo "<script>document.location.href='GeneralUserIndex.php'</script>";
	// 	exit;
	// }
?>