<?php
	include 'open.php';

	$LOWER=(int)$_POST['vacRate'];
	
	echo "<br><h1 style='text-align:center; font-size:5vh;'>Vaccination Rates: Per Capita Income Above ".$LOWER."</h1>";

	if ($stmt=$conn->prepare("CALL vacRate(?);")) {
	   $stmt->bind_param("i", $LOWER);
	   if ($stmt->execute()){
	      $res=$stmt->get_result();
	
	      if ($res->num_rows == 0) {
	      	 echo "No Countries Within This Bound...";
	      } else {
	      	 $dataPoints=array();
		 foreach($res as $row) {
		 	      array_push($dataPoints, array("y"=> round($row["vacRate"], 2), "label"=> $row["name"], "income"=> $row["perCapitaIncome"]));      	
		 }
	      }
	      $res->free_result();
	   } else {
	     echo "Execute Failed<br>";
	   }

	} else {
	  echo "Prepare Failed.<br>";
	  $error=$conn->error.' '.$conn->error;
	  echo $error;
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
	theme: "light2",
	axisX:{
		title: "Country"
	},
	axisY: {
	        suffix: "%",
		title: "Vaccination Rate"
	},
	data: [{
		type: "column",
		toolTipContent: "{label}<br><br>Vaccination Rate: {y}%<br>Income: {income} USD",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 50%; width: 80%; margin:auto;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>                              