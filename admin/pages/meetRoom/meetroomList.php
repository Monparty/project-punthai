<?php 
include("../../../config/config.php");
session_start();

$sql = " SELECT * FROM meetrooms";
$query = mysqli_query( $c, $sql );

// ลบข้อมูล
if (isset($_REQUEST['delete'])) {
    $room_id = $_REQUEST['delete'];

    $delete_stmt = $conn->prepare('DELETE FROM rooms WHERE room_id = :room_id');
    $delete_stmt->bindParam(':room_id', $room_id);
    $delete_stmt->execute();

    echo '<script>
        setTimeout(function() {
        swal({
            title: "ลบข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "roomList.php";
        });
        }, 1000);
        </script>';
}

include ("meetRoomList.html");
?>