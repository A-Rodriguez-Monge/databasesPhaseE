<?php
	include 'open.php';

	$STAT=$_POST['patSelect'];

	echo "<br><h1 style='text-align:center; font-size:5vh;'>".$STAT." by Race/Ethnicity</h1><br>";

	$res=$conn->query("CALL ".$STAT."();");

	$dataPoints = array();

	foreach($res as $row) {
		     array_push($dataPoints, array("label"=> $row["raceEthnicity"], "y"=> $row["Percent"]));
	}
	
	$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 70%; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>