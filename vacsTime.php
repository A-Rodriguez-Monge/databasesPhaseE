<?php
	include 'open.php';
	$COUNTRY=$_POST['cSelect'];
	echo "<br><h1 style='text-align:center; font-size:5vh;'>Total Vaccines Ordered vs Time<h1>";
        echo "<h2 style='text-align:center; margin-top:-2vh;'>Country IsoCode: ".$COUNTRY."</h2><br>";

	if ($stmt=$conn->prepare("CALL vacsTime(?);")) {
	   $stmt->bind_param("s", $COUNTRY);

	   if ($stmt->execute()) {
	      $res=$stmt->get_result();
	      $row=mysqli_fetch_array($res);
	     
	      if (strcmp($row["manuName"], "INVALID") == 0) {
	      	 echo "<br><h1 style='text-align:center;'>This Country Has Not Ordered Vaccines...</h1>";
	      } else {
	      	$dataPoints=array();
	      	foreach($res as $row) {
                       array_push($dataPoints, array("label"=> $row["dateOrdered"], "y"=> $row["amount"]));
          	}
	      }
	      $res->free_result();
	   } else {
	     echo "<h2 style='text-align:center;'>Execute Failed</h2>.<br>";
	   }
	   $stmt->close();
	} else {
	  $error=$conn->errno.' '.$conn->error;
	  echo $error;
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
<div id="chartContainer" style="height: 70%; width: 90%; margin:auto;"></div\
>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
