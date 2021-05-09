<?php
	include 'open.php';

        $arr = array();
	$res = $conn->query("CALL stateMap()");
	array_push($arr, array("Region", "State", "Population", "Party"));

	foreach($res as $row) {
		array_push($arr, array($row["country"], $row["stateName"], $row["population"], $row["polParty"]));
	}

	$out = array_values($arr);
	echo json_encode($out);
	$conn->close();
?>
