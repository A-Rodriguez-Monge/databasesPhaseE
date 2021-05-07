<?php
	include 'open.php';

	$res = $conn->query("CALL stateMap()");
	$row = mysqli_fetch_assoc($res);

	echo "test";
	$conn->close();
?>
