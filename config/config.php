<?php
$servername = "yamanote.proxy.rlwy.net:26986";
$username = "root";
$password = "OtHLBnRAWENJDSaDAgISAqivqRlhGyZy";
$dbname= "railway";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $c = mysqli_connect( "yamanote.proxy.rlwy.net:26986", "root", "OtHLBnRAWENJDSaDAgISAqivqRlhGyZy", "railway" );
  mysqli_query( $c, "SET NAMES UTF8" );
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

echo '
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

date_default_timezone_set('Asia/Bangkok');
?>
