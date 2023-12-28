<?php
    require_once '../../config/config.php';
    session_start(); //ประกาศใช้ session
    session_destroy(); //เคลียร์ค่า session

    echo '<script>
            setTimeout(function() {
            swal({
            title: "ออกจากระบบเรียบร้อย",  
            type: "success"
            }, function() {
            window.location = "../";
            });
            }, 1000);
        </script>';
?>