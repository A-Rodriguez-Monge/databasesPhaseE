<?php include 'open.php'; ?>

<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="COVID Data">
	<meta name="author" content="Alejandro R, Mirza K">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./style.css">

	<title> Databases: Phase E </title>
	<link rel="icon" type="image/png" sizes="32x32" href="./favicon.png">

</head>

    <body>
      <h2 class="title">Phase E: COVID Data</h2> <br/>
      <h3 class="title" style="font-size: 2vh;">Collection of Critical COVID-19 Statistics:</h3>

      <div class="tempMap">
	<iframe src="worldMap.html"></iframe>
      </div>

      <div class="query">
        <h3>Country Rate Statistics</h3>
        <form action="countryRate.php" method="post">
          <select name="countryRateSelect">
            <option value="testingDeathRate">Testing-Death Rate</option>
            <option value="nrdRate">Normal-Covid-Death Rate</option>
          </select>
          <input type="submit" Value="Submit"/>
        </form>
      </div>

      <div class="query">
        <h3>Infection Rate By Party</h3>
        <form action="statePol.php" method="post">
          <select name="statePolSelect">
            <option value="Dem">Democratic</option>
            <option value="Rep">Republican</option>
          </select>
          <input type="submit" Value="Submit"/>
        </form>
      </div>

      <div class="query">
        <h3>State Education Statistics</h3>
        <form action="stateEdu.php" method="post">
          <select name="stateEduSelect">
            <option value="someHS">Some Highschool</option>
            <option value="HS">Highschool</option>
            <option value="someCollege">Some College</option>
	    <option value="college">College</option>
          </select>
          <input type="submit" Value="Submit"/>
        </form>
      </div>

      <div class="query">
	<h3>Vaccination Rates by Income</h3>
	<form action="vacRate.php" method="post">
	  <label for="vacRate">Lower Bound:</label>
	  <input type="number" min="0" max="190000" name="vacRate" id="vacRate" required/>
	  <input type="submit" Value="Submit"/>
	</form>
      </div>

      <div class="query">
	<h3>Race/Ethnicity Statistics</h3>
	<form action="patPie.php" method="post">
	  <select name="patSelect">
	    <option value="Hospitalizations">Hospitalizations</option>
	    <option value="Deaths">Deaths</option>
	    <option value="Infections">Infections</option>
	  </select>
	  <input type="submit" Value="Submit"/>
	</form>
      </div>

      <div class="query">
	<h3>Vaccines Over Time</h3>
	<form action="vacsTime.php" method="post">
	  <select name="cSelect">
	    <?php
	     $countries="SELECT name, isocode FROM Country ORDER BY name;";
	     $res=$conn->query($countries);
	     while($cRow=mysqli_fetch_array($res)){
	      echo "<option value=$cRow[isocode]>".$cRow['name']."</option>";
	    }
	    ?>
	  </select>
	  <input type="submit" Value="Submit"/>
	</form>
      </div>

      <div class="query">
        <h3>Vaccines By Manufacturer</h3>
        <form action="manuVacs.php" method="post">
          <label for="start">Start Date:</label>
          <input type="date" id="start" name="start" min="2020-05-01" max="2021-03-30" value="2020-05-01" required/>
          <br><br>
          <label for="end">End Date:</label>
          <input type="date" id="end" name="end" min="2020-05-20" max="2021-04-21" value="2021-04-21" required/>
          <br><br>
          <input type="submit" Value="Submit"/>
        </form>
      </div>

      <div class="query">
      	   <h3>Average Infection Rates By Income</h3>
      	   <form action="incomeStat.php" method="post">
		<label for="lower">Lower Bound:</label>
		<input type="number" min="1" max="190000"id="lower" name="lower" required/><br><br>
		<label for="upper">Upper Bound:</label>
		<input type="number" min="0" max="200000" id="upper" name="upper" required/><br><br>
		<input type="submit" value="Submit"/>
	   </form>
      </div>

      <div class="query">
      	<br>
	<h2>Modify Database</h2>
	<form action="./modify.php">
	      <input type="submit" value="Go"/>
	</form>
      </div>

      <br>
    </body>

</html>

<?php $conn->close(); ?>
