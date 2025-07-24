<?php
$username = $_GET['username'] ;
$password = $_GET['password'];
$email = $_GET['email'];
if ($username == '' || $password == '' || $email == '') {
echo "Please enter full information";
} elseif ($password == $confirm_password) {
echo "check your password";
} else {
    header("location: html/login.html");
    exit;
}
?>