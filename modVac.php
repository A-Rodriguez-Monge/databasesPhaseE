<?php  include 'open.php' ?>

<!DOCTYPE HTML>
<html>
<head>
        <title>Modify Database</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="icon" type="image/png" sizes="32x32" href="./favicon.png">

</head>

<body>
        <h1 class="title">Modify Vaccine Orders:</h1>

            <form class="insert"  method="post">
                <div class="tableName"><h3>Insert</h3></div>
		
		<div>
                        <label for="mName">Manufacturer Name</label>
                        <input type="text" id="mName" name="mName" maxlength="40" required/>
                </div>
		<div>
                        <label for="iso">Isocode</label>
                        <input type="text" id="iso" name="iso" maxlength="2" required/>

                </div>
		<div>
                        <label for="oDate">Order Date</label>
                        <input type="date" id="oDate" name="oDate" value="2021-05-11" required/>

                </div>
                <div>
                        <label for="amount">Amount</label>
                        <input type="number" min="1" id="amount" name="amount" required/>

                </div>

                <div>
                        <input type="submit" Value="Submit"/>
                </div>
            </form>


        <form class="insert" method="post">
              <div class="tableName"><h3>Delete</h3></div>
              <div>
                <label for="deleteC">Order Number</label>
		<input type="number" id="deleteC" name="deleteC" min="1" required/>
                <input type="submit" Value="Submit"/>
              </div>
	</form>

</body>
</html>

<?php

        if(isset($_POST["iso"]) && isset($_POST["mName"])) {

		$iso=$_POST['iso'];
		$mName=$_POST['mName'];
                $amount=(int)$_POST['amount'];
                $date=$_POST['oDate'];

		if($stmt=$conn->prepare("CALL insertOrder(?,?,?,?);")) {
                        $stmt->bind_param("sssi", $mName, $iso, $date, $amount);

                        if ($stmt->execute()) {
                           $res=$stmt->get_result();

                           if ($res->num_rows == 0) {
                              echo '<script>alert("Insertion Failed: Ensure Country and Manufacturer Exist!")</script>';
                           } else {
                              echo '<script>alert("Order Added!")</script>';
                           }

                           $res->free_result();
                        } else{
                          echo "Execute Failed: Ensure Manufacturer: '".$mName."' and Country: '".$iso."' Already Exist";
                        }
                } else {
                  echo "Prepare Failed<br>";
                  $error=$conn->errno.' '.$conn->error;
                  echo $error;
                }
		
        } else if (isset($_POST['deleteC'])) {
               //add case sensitivity + check if region exists make alert?
               $oNum=(int)$_POST['deleteC'];
               
	        if($stmt=$conn->prepare("CALL deleteOrder(?);")) {
                        $stmt->bind_param("s", $oNum);

                        if ($stmt->execute()) {
                           $res=$stmt->get_result();

                           if ($res->num_rows == 0) {
                              echo '<script>alert("Order Does Not Exist!")</script>';
                           } else {
                              echo '<script>alert("Order Deleted!")</script>';
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

