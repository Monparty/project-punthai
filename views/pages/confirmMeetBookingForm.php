<?php 
include ("../../config/config.php");
session_start();

$meetroom_id = $_GET['meetroom_id'];
$meetbooking_id = $_GET['meetbooking_id'];
$sql = "SELECT * FROM meetrooms, meetroom_bookings WHERE meetbooking_id = $meetbooking_id AND meetrooms.meetroom_id = $meetroom_id;";
$query = mysqli_query( $c, $sql );
// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

// คำนวณค่าอาหาร
$snack1 = 45;
$snack2 = 55;
$snack3 = 65;
$lunch1 = 55;
$lunch2 = 65;
$lunch3 = 235;
$buffet = 340;

$snack1_price = $fetch['snack1_amount'] * $snack1;
$snack2_price = $fetch['snack2_amount'] * $snack2;
$snack3_price = $fetch['snack3_amount'] * $snack3;

$lunch1_price = $fetch['lunch1_amount'] * $lunch1;
$lunch2_price = $fetch['lunch2_amount'] * $lunch2;
$lunch3_price = $fetch['lunch3_amount'] * $lunch3;

$buffet1_price = $fetch['buffet1_amount'] * $buffet;
$buffet2_price = $fetch['buffet2_amount'] * $buffet;
$buffet3_price = $fetch['buffet3_amount'] * $buffet;

if ($fetch['buffetset1']!='T'){
    $buffetset1 = 0;
} else {
    $buffetset1 = 6500;
}

if ($fetch['buffetset2']!='T'){
    $buffetset2 = 0;
} else {
    $buffetset2 = 12000;
}

if ($fetch['buffetset3']!='T'){
    $buffetset3 = 0;
} else {
    $buffetset3 = 22000;
}

include ("confirmMeetBookingForm.html");
?>
