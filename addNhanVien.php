<!-- addNhanVien.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Màu nền xanh dương nhạt */
        }
        h2 {
            color: #000080; /* Màu xanh dương đậm */
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff; /* Màu nền trắng */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1); /* Đổ bóng */
        }
        label {
            display: block;
            margin-bottom: 10px;
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
    <h2>Thêm Nhân Viên Mới</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="maNV">Mã NV:</label>
        <input type="text" name="maNV" id="maNV" required><br><br>
        <label for="tenNV">Tên NV:</label>
        <input type="text" name="tenNV" id="tenNV" required><br><br>
        <label for="phai">Phái:</label>
        <select name="phai" id="phai" required>
            <option value="NU">Nữ</option>
            <option value="NAM">Nam</option>
        </select><br><br>
        <label for="noiSinh">Nơi Sinh:</label>
        <input type="text" name="noiSinh" id="noiSinh"><br><br>
        <label for="maPhong">Mã Phòng:</label>
        <input type="text" name="maPhong" id="maPhong" required><br><br>
        <label for="luong">Lương:</label>
        <input type="text" name="luong" id="luong" required><br><br>
        <input type="submit" value="Thêm Nhân Viên">
    </form>

    <?php
    // Thiết lập thông tin kết nối đến cơ sở dữ liệu MySQL
    $servername = "localhost"; // Tên máy chủ MySQL
    $username = "root"; // Tên người dùng MySQL
    $password = ""; // Mật khẩu MySQL
    $database = "QL_NhanSu"; // Tên cơ sở dữ liệu MySQL

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

     // Xử lý thêm nhân viên
    // Xử lý thêm nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['maNV']) && isset($_POST['tenNV']) && isset($_POST['phai']) && isset($_POST['maPhong']) && isset($_POST['luong'])) {
        $maNV = $_POST['maNV'];
        $tenNV = $_POST['tenNV'];
        $phai = $_POST['phai'];
        $noiSinh = isset($_POST['noiSinh']) ? $_POST['noiSinh'] : '';
        $maPhong = $_POST['maPhong'];
        $luong = $_POST['luong'];

        $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
                VALUES ('$maNV', '$tenNV', '$phai', '$noiSinh', '$maPhong', '$luong')";

if ($conn->query($sql) === TRUE) {
    echo "<p>Thêm nhân viên thành công</p>";
    // Chuyển hướng người dùng về trang index.php sau khi thêm thành công
    header("Location: index.php");
    exit();
} else {
    echo "<p>Lỗi: " . $sql . "<br>" . $conn->error . "</p>";
}
} else {
echo "<p>Vui lòng điền đầy đủ thông tin nhân viên</p>";
}   
}


    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>
