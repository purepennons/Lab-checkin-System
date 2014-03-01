<?php
	$chooseDate = $_POST['datepicker'];
	$chooseUsername = $_POST['select-option-name']
	$_SESSION['sessiondate'] = $chooseDate;
	$_SESSION['sessionChooseUsername'] = $chooseUsername;
	echo "<script>document.location.href='AdminIndex.php'</script>";
	exit;
?>
