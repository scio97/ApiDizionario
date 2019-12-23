<?php
$server ="eu-cdbr-west-02.cleardb.net";
$username = "b2f1387a4d8c19";
$password = "08eb3522";
$db= "heroku_cc602ece3a9cc08";

$conn = new mysqli($server, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>