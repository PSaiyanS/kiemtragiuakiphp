<?php
// Thiết lập thông tin kết nối đến cơ sở dữ liệu MySQL
$servername = "localhost"; // Tên máy chủ MySQL
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$database = "QL_NhanSu"; // Tên cơ sở dữ liệu MySQL

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);
if (isset($_POST["logout"])) {
    session_destroy(); // Hủy bỏ phiên đăng nhập
    header("location: login.php"); // Chuyển hướng người dùng về trang đăng nhập sau khi đăng xuất
    exit;
}
// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Xác định trang hiện tại
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$start_from = ($current_page - 1) * $records_per_page;

// Truy vấn dữ liệu từ bảng NHANVIEN với phân trang
$sql = "SELECT NHANVIEN.*, PHONGBAN.Ten_Phong FROM NHANVIEN INNER JOIN PHONGBAN ON NHANVIEN.Ma_Phong = PHONGBAN.Ma_Phong LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng thông tin nhân viên</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            background-color: #fff; /* Màu nền trắng */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Màu nền xanh dương nhạt */
        }
        h2 {
            color: #000080; /* Màu xanh dương đậm */
            text-align: center; /* Căn giữa tiêu đề */
        }
        form {
            max-width: 400px;
            background-color: #fff; /* Màu nền trắng */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1); /* Đổ bóng */
        }
        label {
            display: block;
            margin-bottom: 10px;
            margin: 0;
            color: #000080; /* Màu xanh dương đậm */
        }
        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #000080; /* Màu nền xanh dương đậm */
            color: #fff; /* Màu chữ trắng */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #4169e1; /* Màu nền xanh dương nhạt khi hover */
        }
        p {
            color: #ff0000; /* Màu đỏ */
        }
    </style>
</head>
<body>
    <h2>Bảng thông tin nhân viên</h2>
    <form action="login.php" method="post">
  
    <input type="submit" value="Đăng nhập">
</form>
    
<table>
    <tr>
        <th>Mã NV</th>
        <th>Tên NV</th>
        <th>Phái</th>
        <th>Nơi Sinh</th>
        <th>Mã Phòng</th>
        <th>Lương</th>
    </tr>   
    <?php
    // Hiển thị dữ liệu từ bảng NHANVIEN
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Ma_NV"] . "</td>";
            echo "<td>" . $row["Ten_NV"] . "</td>";
            echo "<td>";
            // Kiểm tra giới tính và chèn hình ảnh tương ứng
            if ($row["Phai"] === "NU") {
                echo '<img src="image/woman.png" alt="Nữ" width="50" height="50">';
            } else {
                echo '<img src="image/man.png" alt="Nam" width="50" height="50">';
            }
            echo "</td>";
            echo "<td>" . $row["Noi_Sinh"] . "</td>";
            echo "<td>" . $row["Ten_Phong"] . "</td>";
            echo "<td>" . $row["Luong"] . "</td>";
            echo "<td>";

        }
    } else {
        echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
    }
    ?>
</table>
    <br>
    <!-- Hiển thị phân trang -->
    <?php
    $sql = "SELECT COUNT(*) AS total_records FROM NHANVIEN";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_records = $row['total_records'];
    $total_pages = ceil($total_records / $records_per_page);

    echo "<div style='text-align: center;'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=".$i."'>".$i."</a> ";
    }
    echo "</div>";
    ?>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
