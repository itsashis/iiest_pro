<?php
 $host = "localhost";
 $db_name = "iiest_db";
 $username = "root";
 $password = "";

 $con = mysqli_connect($host,$db_name,$username,$password);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>