<?php
        include 'open.php';

        $STAT=$_POST['countryRateSelect'];

        echo "<br><h1 style='text-align:center; font-size:5vh;'>Covid Death Rate To Normal Death Rate</h1><br>";

        $res=$conn->query("CALL ".$STAT."();");

        $dataPoints = array();
	array_push($dataPoints, array("Country", "Rate"));

        foreach($res as $row) {
		$t = 0;
		if (strcmp($STAT, "nrdRate") == 0) {
			$a = $row["covidDeaths"];
			$b = $row["covidDeaths"];
			if ($b != 0) {
				$t = (float)$row["covidDeaths"] / (float)$row["normalDeaths"];
			} else {
				$t = 0;
			}
		} else {
			$t = $row["testingDeathRatio"];
		}
        	array_push($dataPoints, array($row["country"], $t * 100));
        }

	$out = array_values($dataPoints);
        $conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="./stateMap.css">
</head>
<div class="map-container">
    <div id="chart" align="center"></div>
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

    console.log(regionDataArray);

    var geoChart = new google.visualization.GeoChart(document.getElementById('chart'));

    var options = {
        colorAxis: {
            colors: ['#acb2b9', '#2f3f4f']
        }
    };

    geoChart.draw(view, options);
    };
</script>
</html>
