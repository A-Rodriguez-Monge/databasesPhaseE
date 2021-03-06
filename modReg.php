<?php
	include 'open.php'
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Modify Database</title>
	<link rel="stylesheet" href="./style.css">
	<link rel="icon" type="image/png" sizes="32x32" href="./favicon.png"
>

</head>

<body>
	<h1 class="title">Modify Region:</h1>

	    <form class="insert"  method="post">
	    	<div class="tableName"><h3>Insert</h3></div>
	    	<div>
			<label for="regName">Name</label>
			<input type="text" id="regName" name="regName" required/>
		</div>

		<div>
			<label for="regPop">Population</label>
                        <input type="number" min="1" id="regPop" name="regPop" required/>

		</div>
		<div>
			<input type="submit" Value="Submit"/>
		</div>
	    </form>


	<form class="insert" method="post">
	      <div class="tableName"><h3>Delete</h3></div>
	      <div>
		<label for="dRegName">Name</label>

<input type="text" id="dRegName" name="dRegName" required/>
		<input type="submit" Value="Submit"/>
	      </div>
	</form>

</body>
</html>

<?php

	if(isset($_POST["regName"]) && isset($_POST["regPop"])) {
		
		$rName=$_POST['regName'];
		$rPop=(int)$_POST['regPop'];

		//$res=$conn->query("CALL insertReg('".$rName."', ".$rPop.");");

		if($stmt=$conn->prepare("CALL insertReg(?,?);")) {
			$stmt->bind_param("si", $rName, $rPop);

			if ($stmt->execute()) {
			   $res=$stmt->get_result();

			   if ($res->num_rows == 0) {
			      echo '<script>alert("Region Already Exists!")</script>';
			   } else {
			      echo '<script>alert("Region Added!")</script>';
			   }

			   $res->free_result();
			} else{
			  echo "Execute Failed<br>";
			}
		} else {
		  echo "Prepare Failed<br>";
		  $error=$conn->errno.' '.$conn->error;
		  echo $error;
		}

	} else if (isset($_POST['dRegName'])) {
	       //add case sensitivity + check if region exists make alert?
	       $dRegName=$_POST['dRegName'];

	       	if($stmt=$conn->prepare("CALL deleteReg(?);")) {
			$stmt->bind_param("s", $dRegName);

			if ($stmt->execute()) {
			   $res=$stmt->get_result();

			   if ($res->num_rows == 0) {
			      echo '<script>alert("Region Does Not Exist!")</script>';
			   } else {
			      echo '<script>alert("Region Deleted!")</script>';
			   }

			   $res->free_result();
			} else{
			  echo "Execute Failed<br>";
			}
		} else {
		  echo "Prepare Failed<br>";
		  $error=$conn->errno.' '.$conn->error;
		  echo $error;
		}
	}

$conn->close();
?>