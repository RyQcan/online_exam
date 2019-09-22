<?php
include '../include/settings.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    header("refresh:0;url=../install.php");
    die("Connection failed: " . $conn->connect_error);
}
?>