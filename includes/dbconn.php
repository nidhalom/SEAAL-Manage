<?php
$dbuser = "root";
$dbpass = "";
$host = "localhost";
$db = "hostelmsphp";
$mysqli = new mysqli($host, $dbuser, $dbpass, $db);
?>

<!--<?php
    if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
        echo "Nous n'avons pas mysqli !!!";
    } else {
        echo 'Ouf nous l\'avons !';
    }
    ?> -->