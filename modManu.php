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
	<h1 class="title">Modify Manufacturer:</h1>

	    <form class="insert"  method="post">
	    	<div class="tableName"><h3>Insert</h3></div>
	    	<div>
			<label for="mName">Name</label>
			<input type="text" id="mName" name="mName" maxLength="40" required/>
		</div>

		<div>
			<label for="amount">Vaccine Orders Placed</label>
                        <input type="number" min="0" id="amount" name="amount" required/>

		</div>
		<div>
			<input type="submit" Value="Submit"/>
		</div>
	    </form>


	<form class="insert" method="post">
	      <div class="tableName"><h3>Delete</h3></div>
	      <div>
		<label for="mName2">Name</label>

<input type="text" id="mName2" name="mName2" required/>
		<input type="submit" Value="Submit"/>
	      </div>
	</form>

</body>
</html>

<?php

	if(isset($_POST["mName"]) && isset($_POST["amount"])) {
		
		$mName=$_POST['mName'];
		$amount=(int)$_POST['amount'];


		//$res=$conn->query("CALL insertReg('".$rName."', ".$rPop.");");

		if($stmt=$conn->prepare("CALL insertManu(?,?);")) {
			$stmt->bind_param("si", $mName, $amount);

			if ($stmt->execute()) {
			   $res=$stmt->get_result();

			   if ($res->num_rows == 0) {
			      echo '<script>alert("Manufacturer Already Exists!")</script>';
			   } else {
			      echo '<script>alert("Manufacturer Added!")</script>';
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

	} else if (isset($_POST['mName2'])) {
	       //add case sensitivity + check if region exists make alert?
	       $dName=$_POST['mName2'];

	       	if($stmt=$conn->prepare("CALL deleteManu(?);")) {
			$stmt->bind_param("s", $dName);

			if ($stmt->execute()) {
			   $res=$stmt->get_result();

			   if ($res->num_rows == 0) {
			      echo '<script>alert("Manufacturer Does Not Exist!")</script>';
			   } else {
			      echo '<script>alert("Manufacturer Deleted!")</script>';
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