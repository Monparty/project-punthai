<?php 
include ("../../config/config.php");
session_start();

// แสดงชื่อผู้ใช้ที่ login เข้ามา
$name = isset($_SESSION["username"]) ? $_SESSION["username"] : " ";



include ("meetRoomList.html");
?>
