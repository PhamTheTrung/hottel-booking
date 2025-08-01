<?php
$servername = "localhost"; //default
$username = "root"; //default
$password = ""; //default
$database = "usersystem"; //Database name

// Kết nối MySQL
//$conn
$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die(mysqli_connect_error());
}
// else{
//     echo ("Successful connect!");
// }
?>