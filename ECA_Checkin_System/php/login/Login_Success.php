<?php 
	session_start();
	if(empty($_SESSION['sessionusername'])){
		header('Location:../../index.php');
	}else {
		if($_SESSION['sessionlevel'] < 3){
			//echo"<meta http-equiv='refresh' content=;0;URL=../admin/AdminIndex.php'>";
			header('Location:../admin/AdminIndex.php');
			exit;
		}else {
			//echo"<meta http-equiv='refresh' content=;0;URL＝../general/GeneralUserIndex.php'>";
			header('Location:../general/GeneralUserIndex.php');
			exit;
		}
	}
?>