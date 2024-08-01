<?php 
include("../../../config/config.php");
session_start();

$sql = " SELECT * FROM meetroom_food";
$query = mysqli_query( $c, $sql );

// ลบข้อมูล
if (isset($_REQUEST['delete'])) {
    $id = $_REQUEST['delete'];

    $delete_stmt = $conn->prepare('DELETE FROM meetroom_food WHERE id = :id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();

    echo '<script>
        setTimeout(function() {
        swal({
            title: "ลบข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "foodList.php";
        });
        }, 1000);
        </script>';
}

include ("foodList.html");
?>