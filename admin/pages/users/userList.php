<?php 
include("../../../config/config.php");
session_start();

$sql = " SELECT * FROM users";
$query = mysqli_query( $c, $sql );

// ลบข้อมูล
if (isset($_REQUEST['delete'])) {
    $user_id = $_REQUEST['delete'];

    $delete_stmt = $conn->prepare('DELETE FROM users WHERE user_id = :user_id');
    $delete_stmt->bindParam(':user_id', $user_id);
    $delete_stmt->execute();

    echo '<script>
        setTimeout(function() {
        swal({
            title: "ลบข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "userList.php";
        });
        }, 1000);
        </script>';
}

include ("userList.html");
?>