<?php
	$chooseDate = $_POST['datepicker'];
	$_SESSION['sessiondate'] = $chooseDate;
	echo "<script>document.location.href='AdminIndex.php'</script>";
	exit;
?>
