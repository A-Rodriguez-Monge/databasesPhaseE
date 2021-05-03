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
	<h3>WORLD MAP PLACE HOLDER</h3>
      </div>

      <div class="tempMap">
	<h3>STATE MAP PLACE HOLDER</h3>
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
	<h3>Vaccines Over Time: </h3>
	<form action="vacsTemp.php" method="post">
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
      
      
    </body>

</html>

<?php $conn->close(); ?>