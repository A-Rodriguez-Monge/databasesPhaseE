<?php
	include 'open.php';
	$iso = $_POST['text'];

	$res = $conn->query("CALL worldMap('".$iso."');");
	$row = mysqli_fetch_assoc($res);

	echo "ISO: ".$row["isocode"];
	echo "\nDeaths: ".$row["totalDeaths"];
        echo "\nTests: ".$row["testsAdministered"];
        echo "\nVaccinations: ".$row["totalVacs"];
        echo "\nHospitalizations: ".$row["hospitalizations"];
        echo "\nCases: ".$row["totalCases"];
	$conn->close();
?>
