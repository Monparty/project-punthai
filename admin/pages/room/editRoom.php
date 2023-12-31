<?php 
include("../../../config/config.php");
session_start();

$id = mysqli_real_escape_string($c,$_GET['id']);
$sql = "SELECT * FROM rooms WHERE id='$id' ";
$result = mysqli_query($c, $sql) or die(mysqli_error($c));
$row = mysqli_fetch_array($result);
extract($row);

include ("editRoom.html");
?>