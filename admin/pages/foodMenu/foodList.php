<?php 
include("../../../config/config.php");
session_start();

$sql = " SELECT * FROM foods";
$query = mysqli_query( $c, $sql );

// ลบข้อมูล
if (isset($_REQUEST['delete'])) {
    $food_id = $_REQUEST['delete'];

    $delete_stmt = $conn->prepare('DELETE FROM foods WHERE food_id = :food_id');
    $delete_stmt->bindParam(':food_id', $food_id);
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