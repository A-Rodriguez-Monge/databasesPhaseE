<?php  include 'open.php' ?>

<!DOCTYPE HTML>
<html>
<head>
        <title>Modify Database</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="icon" type="image/png" sizes="32x32" href="./favicon.png">

</head>

<body>
        <h1 class="title">Modify COVID Stats:</h1>

            <form class="insert"  method="post">
                <div class="tableName"><h3>Insert</h3></div>
		<div>
                        <label for="iso">Isocode</label>
                        <input type="text" id="iso" name="iso" maxlength="2" required/>

                </div>
		<div>
                        <label for="deaths">Total Deaths</label>
                        <input type="number" min="0" id="deaths" name="deaths" required/>
                </div>
		<div>
                        <label for="tests">Tests Administered</label>
                        <input type="number" id="tests" name="tests" min="0" required/>

                </div>
                <div>
                        <label for="vacs">Total Vaccinations</label>
                        <input type="number" min="0" id="vacs" name="vacs" required/>

                </div>
		<div>
                        <label for="hosp">Hospitalizations</label>
                        <input type="number" min="0" id="hosp" name="hosp" required/>

                </div>
		<div>
                        <label for="cases">Total Cases</label>
                        <input type="number" min="0" id="cases" name="cases" required/>

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

        if(isset($_POST["iso"]) && isset($_POST["deaths"])) {

		$iso=$_POST['iso'];
		$deaths=(int)$_POST['deaths'];
                $tests=(int)$_POST['tests'];
                $vacs=(int)$_POST['vacs'];
		$hosp=(int)$_POST['hosp'];
		$cases=(int)$_POST['cases'];

                //$res=$conn->query("CALL insertReg('".$rName."', ".$rPop.");");

		if($stmt=$conn->prepare("CALL insertStat(?,?,?,?,?,?);")) {
                        $stmt->bind_param("siiiii", $iso, $deaths, $tests, $vacs, $hosp, $cases);

                        if ($stmt->execute()) {
                           $res=$stmt->get_result();

                           if ($res->num_rows == 0) {
                              echo '<script>alert("Please Ensure That Country Exists and Statistic Does Not Exist")</script>';
                           } else {
                              echo '<script>alert("Statistics Added!")</script>';
                           }

                           $res->free_result();
                        } else{
                          echo "Execute Failed";
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

	        if($stmt=$conn->prepare("CALL deleteStat(?);")) {
                        $stmt->bind_param("s", $iso);

                        if ($stmt->execute()) {
                           $res=$stmt->get_result();

                           if ($res->num_rows == 0) {
                              echo '<script>alert("Statistic Does Not Exist!")</script>';
                           } else {
                              echo '<script>alert("Statistic Deleted!")</script>';
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

