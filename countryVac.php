<?php
        include 'open.php';

        $STAT=$_POST['countryVacSelect'];

        echo "<br><h1 style='text-align:center; font-size:5vh;'>".$STAT." Vaccines by Country</h1><br>";

	$STAT=$STAT."%";


	if ($stmt=$conn->prepare("CALL countryVac(?);")) {
		$stmt->bind_param("s", $STAT);

		if ($stmt->execute()) {
			$res = $stmt->get_result();
        		$dataPoints = array();
        		array_push($dataPoints, array("Region", "Total"));
        		foreach($res as $row) {
                		array_push($dataPoints, array($row["isocode"], $row["total"]));
        		}

        		$out = array_values($dataPoints);

		} else {
			echo "Execute Failed<br>";
		}
	} else {
		echo "Prepare failed<br>";
		$error = $conn->errno.' '.$conn->error;
		echo $error;
	}

        $conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="./stateMap.css">
</head>
<div class="map-container">
    <div id="chart"></div>
</div>
<div id="info">
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.load('visualization', '1', {
    	'packages': ['geochart', 'table']
    });
    google.setOnLoadCallback(drawMap);

    function drawMap() {
    var regionDataArray = <?php echo json_encode($out); ?>;
    var data = google.visualization.arrayToDataTable(regionDataArray);
    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1]);

    var geoChart = new google.visualization.GeoChart(document.getElementById('chart'));

    var options = {
    };

    geoChart.draw(view, options);
    };
</script>
</html>
