<?php
	include 'open.php';

	$LOWER=(int)$_POST['lower'];
	$UPPER=(int)$_POST['upper'];
	 echo "<br><h1 style='text-align:center; font-size:5vh;'>COVID Infection Rates By Income:<h1>";
	 if (empty($LOWER) || empty($UPPER)) {
                echo "empty<br><br>";
	 } else if((int)$LOWER > (int)$UPPER) {
	 	echo "Please Select Upper Bound Greater Than Lower Bound";
	 } else {
	  
	   if ($stmt=$conn->prepare("CALL incomeStat(?,?);")) {
	      $stmt->bind_param("ii",$LOWER, $UPPER);

	      if ($stmt->execute()) {
	      	 $res=$stmt->get_result();

		 if($res->num_rows == 0) {
		 	echo "No Countries Within This Range...";
		 } else {
		   	$dataPoints=array();
			foreach($res as $row) {
				     array_push($dataPoints, array("label"=> round($row["avgRate"], 2), "y"=> [$LOWER, $UPPER]));
			}
		 }
	      	 $res->free_result();
	      } else {
	      	echo "Execute Failed.<br>";
	      }
	      $stmt->close();
	   } else {
	     echo "Prepare Failed.<br>";
	     $error=$conn->errno.' '.$conn->error;
	     echo $error;
	   }
	 }
	 
	 $conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Infection Rate By Income</title>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light1",
	animationEnabled: true,
	axisY: {
		prefix: "$",
		includeZero: false,
		title : "per Capita Income (USD)",
	},
	axisX: {
	       suffix: "%",
	       title: "Average Infection Rate",

	},
	dataPointWidth: 100,
	data: [
		{
			type: "rangeColumn",
			toolTipContent: "{label}<br>Minimum: {y[0]}<br>Maximum: {y[1]}",
			dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
		}
	]
});
 
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 50%; margin: auto;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>                              