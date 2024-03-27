<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "QL_NhanSu";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Xóa nhân viên từ cơ sở dữ liệu
    $sql = "DELETE FROM NHANVIEN WHERE Ma_NV='$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='padding: 20px; background-color: #f0f0f0; border: 1px solid #ccc;'>";
        echo "Xóa nhân viên thành công<br>";
        echo "<a href='index.php' style='text-decoration: none; color: blue;'>Quay về trang người dùng</a>";
        echo "</div>";
    } else {
        echo "<div style='padding: 20px; background-color: #f0f0f0; border: 1px solid #ccc;'>";
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
        echo "</div>";
    }
}

$conn->close();
?>
