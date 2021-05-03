<?php
	include 'open.php';
	echo "<h2>Vaccinations vs Time: by country<h2>";

	$countries="SELECT name, isocode FROM Country ORDER BY name;";
	echo "<form method='post'>";
	echo "<select id=country name=country >Country</option>";
	
	foreach ($conn->query($countries) as $cRow){
		echo "<option value=$cRow[isocode]>$cRow[name]</option>";
	}
	echo "</select>";

	echo "<input type='submit' value='Select Country'> </form>";

	$COUNTRY = $_POST['country'];
	echo "Selected: ".$COUNTRY;

	$res=$conn->query("CALL vacsTime('".$COUNTRY."');");
	$row=mysqli_fetch_array($res);

	$data = array();

	if ($row["manuName"] == 'INVALID') {
	   echo "This Country has no orders...";
	} else {
	  foreach() {
	  	    array_push($data, array("date"=> $row["dateOrdered"], "amount"=> $row["amount"]));
	  }
	}

	$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
	      var chart = new CanvasJS.chart("chartContainer", {
	      	  animationEnabled: true,
		  exportEnabled: true,
		  theme: "light1", // "light1", "light2", "dark1", "dark2"
		  title: {
		  	 text: "PHP Line Chart From Database"
		  },
		  data: [{
		  	type: "line", //change type to column, bar, line, area, pie, etc
			datapoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
		  }]
	      });
	      chart.render();
	      }
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
