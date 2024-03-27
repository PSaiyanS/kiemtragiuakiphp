<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Phòng Ban</title>
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
    <h2>Thêm Phòng Ban Mới</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="Ma_Phong">Mã Phòng:</label>
        <input type="text" name="Ma_Phong" id="Ma_Phong" required><br><br>
        <label for="Ten_Phong">Tên Phòng:</label>
        <input type="text" name="Ten_Phong" id="Ten_Phong" required><br><br>
        <input type="submit" value="Thêm Phòng Ban">
    </form>

    <h2>Danh sách Phòng Ban</h2>
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

    // Xử lý khi form được gửi đi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kiểm tra xem các trường đã được gửi từ form chưa
        if(isset($_POST['Ma_Phong']) && isset($_POST['Ten_Phong'])) {
            $maPhong = $_POST['Ma_Phong'];
            $tenPhong = $_POST['Ten_Phong'];

            // Kiểm tra xem mã phòng đã tồn tại trong cơ sở dữ liệu chưa
            $sql_check = "SELECT * FROM PHONGBAN WHERE Ma_Phong = '$maPhong'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                echo "Mã phòng đã tồn tại trong cơ sở dữ liệu.";
            } else {
                // Thực hiện truy vấn SQL để thêm phòng ban vào cơ sở dữ liệu
                $sql = "INSERT INTO PHONGBAN (Ma_Phong, Ten_Phong) VALUES ('$maPhong', '$tenPhong')";

                if ($conn->query($sql) === TRUE) {
                    echo "Thêm phòng ban thành công";
                } else {
                    echo "Lỗi: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }

    // Hiển thị danh sách phòng ban
    $sql_select = "SELECT * FROM PHONGBAN";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows > 0) {
        echo "<ul>";
        while ($row = $result_select->fetch_assoc()) {
            echo "<li>Mã phòng: " . $row["Ma_Phong"] . " Tên phòng: " . $row["Ten_Phong"] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Không có phòng ban nào trong cơ sở dữ liệu.";
    }

    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>
