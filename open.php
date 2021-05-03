<?php
	//include login variable names
	include 'conf.php';

	//attempt to make connection to database
	$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

	//report if failure or success
	if ($conn->connect_errno) {
	   echo("Connect failed: \n".$conn->connect_error);
	   exit();
	} else {
	  //remove once connected successfully
	 // echo "Connected Successfully <br/>";
	}
?>