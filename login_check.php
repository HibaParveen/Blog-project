<?php 
session_start(); 

include("conn.php");

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM user WHERE user_name = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    $_SESSION["user_id"] = $user["user_id"];  
    $_SESSION["username"] = $user["user_name"];  
    
    header("Location: tables.php");
    exit(); 
} else {
    header("Location: login.php");
    exit();  
}
?>
