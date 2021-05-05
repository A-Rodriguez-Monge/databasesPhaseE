<?php
	include 'open.php';
	$iso = $_POST['text'];
	echo $iso;

	$res = $conn->query("CALL worldMap('".$iso."');");
	$row = mysqli_fetch_array($res);

	echo implode(", ", $row);
	$conn->close();
?>
