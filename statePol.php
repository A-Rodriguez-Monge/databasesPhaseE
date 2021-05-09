<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
        include 'open.php';

        $STAT=$_POST['statePolSelect'];

        echo "<br><h1 style='text-align:center; font-size:5vh;'>Education by State</h1><br>";

        $res=$conn->query("CALL statePol();");
        $dataPoints = array();
	array_push($dataPoints, array("State", "Rate"));
        foreach($res as $row) {
		if (strcmp($row["polParty"], $STAT) != 0) {
			continue;
		}
        	array_push($dataPoints, array($row["stateName"], $row["covidRate"] * 100));
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
	console.log(regionDataArray);
    var data = google.visualization.arrayToDataTable(regionDataArray);
    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1]);

    var geoChart = new google.visualization.GeoChart(document.getElementById('chart'));

    var options = {
        region: 'US',
        resolution: 'provinces',
        legend: 'none',
        backgroundColor: '#8d8d8d'
    };

    geoChart.draw(view, options);
    };
</script>
</html>
