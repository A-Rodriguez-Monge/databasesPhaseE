<?php

	include 'open.php';

	$START=$_POST['start'];
	$END=$_POST['end'];

	echo "<br><h1 style='text-align:center; font-size:5vh;'>Vaccines By Top Manufacturer</h1><br>";

	if ($stmt=$conn->prepare("CALL manuVacs(?,?);")) {

	   $stmt->bind_param("ss", $START, $END);

	   if ($stmt->execute()) {

	      $res=$stmt->get_result();

	      if ($res->num_rows == 0) {
	      	 echo "No Data Found Between ".$START." and ".$END;
	      } else {

	      	$data1=array();
		$data2=array();
		$data3=array();
		$data4=array();
	
	      	foreach($res as $row) {
			     //echo $row['manuName']." ".$row['dateOrdered']." ".$row['orders']."<br>";

			     $MANU=$row['manuName'];
			     
			     if (strcmp($MANU, "Oxford-AstraZeneca") == 0) {
			       array_push($data1, array("x" => (strtotime($row['dateOrdered'])*1000), "y" => $row['orders']));
			     } else if (strcmp($MANU, "Pfizer-BioNTech") == 0) {
			       array_push($data2, array("x" => (strtotime($row['dateOrdered'])*1000), "y" => $row['orders']));
			     } else if (strcmp($MANU, "Moderna") == 0) {
			       array_push($data3, array("x" => (strtotime($row['dateOrdered'])*1000), "y" => $row['orders']));
			     } else {
			       array_push($data4, array("x" => (strtotime($row['dateOrdered'])*1000), "y" => $row['orders']));
			     }
		}
	      }

	   } else {
	     echo "Execute Failed<br>";
	   }

	} else {
	  echo "Prepare Failed<br>";
	  $error=$conn->errno.' '.$conn->error;
	  echo $error;
	}	

	$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Manufacturer Vaccines</title>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
	axisX: {
		title: "Date",
		valueFormatString: "DD MMM YY"
	},
	axisY: {
		title: "Vaccines Ordered"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		name: "Oxford-AstraZeneca",
		type: "line",
		xValueType: "dateTime",
		showInLegend: true,
		dataPoints: <?php echo json_encode($data1, JSON_NUMERIC_CHECK); ?>
	},{
		name: "Pfizer-BioNTech",
		type: "line",
		xValueType: "dateTime",
		showInLegend: true,
		dataPoints: <?php echo json_encode($data2, JSON_NUMERIC_CHECK); ?>
	},{
		name: "Moderna",
		type: "line",
		xValueType: "dateTime",
		showInLegend: true,
		dataPoints: <?php echo json_encode($data3, JSON_NUMERIC_CHECK); ?>
	},{
		name: "Janssen (J&J)",
		type: "line",
		xValueType: "dateTime",
		showInLegend: true,
		dataPoints: <?php echo json_encode($data4, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 70%; width: 80%; margin:auto;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<h3 style='text-align:center;'>^Click To Toggle Data^</h3>
</body>
</html>