<?php
    include_once(realpath("../DB_Conf.php"));
    include_once(realpath("../DB_Class.php"));
    $db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $sectionUsername = $_POST['username'];
    $sectionPassword = $_POST['password'];
    $sectionUsername = stripslashes($sectionUsername);
	$sectionPassword = stripslashes($sectionPassword);
	$sectionUsername = mysql_real_escape_string($sectionUsername);
	$sectionPassword = mysql_real_escape_string($sectionPassword);
    $sql = sprintf("SELECT * FROM ACCOUNT WHERE username='%s' AND password='%s'", mysql_real_escape_string($sectionUsername), mysql_real_escape_string($sectionPassword));
    $db->query($sql);
    $result = $db->fetch_array();
	if($result){
		session_start();
		$_SESSION['sessionusername'] = $result['username'];
		$_SESSION['sessionname'] = $result['name'];
		$_SESSION['sessionlevel'] = $result['priority'];
		//真實ip判別，但不確定
		// if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		//   		$myip = $_SERVER['HTTP_CLIENT_IP'];
			// }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//   		$myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			// }else{
			//   		$myip= $_SERVER['REMOTE_ADDR'];
			// }
			// echo $myip;
		$_SESSION['sessionUserIP'] = $_SERVER['REMOTE_ADDR'];  //代理無效
		//echo"<meta http-equiv='refresh' content=;0;URL=Login_Success.php'>";
		header('Location:Login_Success.php');
		exit;
	}else {
		echo "錯誤的帳號或密碼";
		echo "<script>document.location.href='../../index.php'</script>";
		exit;
	}
?>