<?php
// Set the database credentials
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rpms";
*/
$servername = "sql111.infinityfree.com";
$username = "if0_34946550";
$password = "ihkBaQaYxst";
$dbname = "if0_34946550_rpms";

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the database connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
