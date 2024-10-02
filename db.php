<?php


$servername = "localhost"; 
$username = "your_username"; 
$password = "your_password"; 
$dbname = "family_feud"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


function closeConnection($conn) {
    $conn->close();
}
?>
