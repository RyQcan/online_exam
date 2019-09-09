<?php
include 'settings.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO a VALUES(?,?)";
$stmt = $conn->stmt_init();

if ($stmt->prepare($sql)) {
    $id='';
    $aa='';
    $stmt->bind_param("ii", $id,$aa);
    if ($stmt->execute()) {
        echo '</br><div class="alert alert-success" role="alert">
                    添加成功!
                    </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
    }
    $stmt->close();
}