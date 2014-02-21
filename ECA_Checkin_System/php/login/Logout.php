<?php
	session_start();
	session_destroy();
	echo "登出中...";
	echo"<meta http-equiv='refresh' content='1;URL=../../index.php'>";
?>