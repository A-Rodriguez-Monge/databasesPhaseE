<?php
	include 'open.php';
        $COUNTRY = $_POST['cSelect'];
	echo "<br><h1 style='text-align:center; font-size:5vh;'>Total Vaccines Ordered vs Time<h1>";
	echo "<h2 style='text-align:center; margin-top:-2vh;'>Country IsoCode: ".$COUNTRY."</h2><br>";	

	$res=$conn->query("CALL vacsTime('".$COUNTRY."');");
	$row=mysqli_fetch_array($res);

	$dataPoints = array();

	if (strcmp($row["manuName"], "INVALID") == 0) {
	  echo "<br><h1>This Country Has Not Ordered Vaccines...</h1>";
	} else {
	  foreach($res as $row) {
		       array_push($dataPoints, array("label"=> $row["dateOrdered"], "y"=> $row["amount"]));
	  }
	}
	
	$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"

	axisX: {
	        title: "Date Ordered"
	},
	axisY: {
	        title: "Number of Vaccines Ordered"
	},
	data: [{
		type: "line", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 70%; width: 90%; margin:auto;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>       