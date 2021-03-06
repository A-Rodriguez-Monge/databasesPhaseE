<?php  include 'open.php' ?>

<!DOCTYPE HTML>
<html>
<head>
        <title>Modify Database</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="icon" type="image/png" sizes="32x32" href="./favicon.png">

</head>

<body>
        <h1 class="title">Modify Country:</h1>

            <form class="insert"  method="post">
                <div class="tableName"><h3>Insert</h3></div>
		<div>
                        <label for="iso">Isocode</label>
                        <input type="text" id="iso" name="iso" maxlength="2" required/>

                </div>
		<div>
                        <label for="cName">Name</label>
                        <input type="text" id="cName" name="cName" maxlength="40" required/>
                </div>
		<div>
                        <label for="rName">Region Name</label>
                        <input type="text" id="rName" name="rName" maxlength="40" required/>

                </div>
                <div>
                        <label for="cPop">Population</label>
                        <input type="number" min="1" id="cPop" name="cPop" required/>

                </div>
		<div>
                        <label for="pDen">Population Density</label>
                        <input type="number" min="1" id="pDen" name="pDen" required/>

                </div>
		<div>
                        <label for="deaths">Annual Deaths</label>
                        <input type="number" min="0" id="deaths" name="deaths" required/>

                </div>
		<div>
                        <label for="income">Per Capita Income</label>
                        <input type="number" min="0" id="income" name="income" required/>

                </div>

                <div>
                        <input type="submit" Value="Submit"/>
                </div>
            </form>


        <form class="insert" method="post">
              <div class="tableName"><h3>Delete</h3></div>
              <div>
                <label for="deleteC">Isocode</label>
		<input type="text" id="deleteC" name="deleteC" maxlength="2" required/>
                <input type="submit" Value="Submit"/>
              </div>
	</form>

</body>
</html>

<?php

        if(isset($_POST["iso"]) && isset($_POST["cName"])) {

		$iso=$_POST['iso'];
		$cName=$_POST['cName'];
                $rName=$_POST['rName'];
                $cPop=(int)$_POST['cPop'];
		$pDen=(double)$_POST['pDen'];
		$deaths=$_POST['deaths'];
		$income=$POST['income'];

                //$res=$conn->query("CALL insertReg('".$rName."', ".$rPop.");");

		if($stmt=$conn->prepare("CALL insertCou(?,?,?,?,?,?,?);")) {
                        $stmt->bind_param("sssiidi", $iso, $cName, $rName, $cPop, $pDen, $deaths, $income);

                        if ($stmt->execute()) {
                           $res=$stmt->get_result();

                           if ($res->num_rows == 0) {
                              echo '<script>alert("Country Already Exists or Region Does Not Exist")</script>';
                           } else {
                              echo '<script>alert("Country Added!")</script>';
                           }

                           $res->free_result();
                        } else{
                          echo "Execute Failed: Ensure Region '".$rName."' Already Exists";
                        }
                } else {
                  echo "Prepare Failed<br>";
                  $error=$conn->errno.' '.$conn->error;
                  echo $error;
                }
		
        } else if (isset($_POST['deleteC'])) {
               //add case sensitivity + check if region exists make alert?
               $iso=$_POST['deleteC'];
               //$res=$conn->query("CALL deleteCou('".$iso."');");

	        if($stmt=$conn->prepare("CALL deleteCou(?);")) {
                        $stmt->bind_param("s", $iso);

                        if ($stmt->execute()) {
                           $res=$stmt->get_result();

                           if ($res->num_rows == 0) {
                              echo '<script>alert("Country Does Not Exist!")</script>';
                           } else {
                              echo '<script>alert("Country Deleted!")</script>';
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

