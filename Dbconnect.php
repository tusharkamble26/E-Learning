<?php

 // this will avoid mysql_connect() deprecation error.
 error_reporting( ~E_DEPRECATED & ~E_NOTICE );
 
 
 $servername = "localhost";
$username = "root";
$password = "root";
$dbname = "coaching";
 $conn = mysqli_connect($servername, $username, $password, $dbname);
// $conn = mysql_connect(DBHOST,DBUSER,DBPASS);
 //$dbcon = mysql_select_db($dbname);
 
 if ( !$conn ) {
     //echo 'No Connection';
  die("Connection failed : " . mysqli_connect_error());
 }
 
 /*if ( !$dbcon ) {
  die("Database Connection failed : " . mysql_error());
 }*/