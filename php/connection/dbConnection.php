<?php
date_default_timezone_set("Asia/Colombo");
$connection = mysqli_connect("localhost","root","","yurekadb");
function runQuery($query){
    global $connection;
    if (mysqli_connect_errno()) {
        die("Data Base Connection Error : " . mysqli_connect_error());
    } else {
        return mysqli_query($connection,$query);
    }
}
?>