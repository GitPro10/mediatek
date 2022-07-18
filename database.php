<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "MediaTek";

$conn = mysqli_connect($hostname, $username, $password, $db);
if (!$conn) {
  die("Simplified Error --> ".mysqli_connect_error($conn));
}