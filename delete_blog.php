<?php

session_start(); 

               if (!isset($_SESSION["user_id"]))
               {
                   header("Location: login.php");
                   exit();  
               }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['title'])) {
    $title = $conn->real_escape_string($_GET['title']); 

    $sql = "DELETE FROM blog WHERE blog_title = '$title'";

    if ($conn->query($sql) === TRUE) {
        echo "Blog deleted successfully.";
        header("Location: tables.php"); 

    } else {
        echo "Error deleting blog: " . $conn->error;
    }
} else {
    echo "No blog title provided for deletion.";
}

$conn->close();
?>