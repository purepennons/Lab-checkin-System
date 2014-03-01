<?php
	session_start();
	//DB connect
	include_once(realpath("../DB_Conf.php"));
	include_once(realpath("../DB_Class.php"));
	$db = new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$chooseDate = $_POST['datepicker'];
	$chooseUsername = $_POST['select-option-name'];
	$sql = sprintf("SELECT name FROM ACCOUNT WHERE username='%s'",mysql_real_escape_string($chooseUsername));
	$db->query($sql);
	$result = $db->fetch_array();
	$_SESSION['sessionChooseName'] = $result['name'];
	$_SESSION['sessiondate'] = $chooseDate;
	$_SESSION['sessionChooseUsername'] = $chooseUsername;
	echo "<script>document.location.href='AdminIndex.php'</script>";
	exit;
?>
