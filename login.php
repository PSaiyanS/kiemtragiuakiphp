<?php
session_start();
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


// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header("location: index.php"); // Chuyển hướng người dùng đã đăng nhập đến trang chính
    exit;
}

// Xử lý dữ liệu đăng nhập khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Chuẩn bị câu truy vấn SQL
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            // Mật khẩu đúng, đăng nhập thành công
            $_SESSION["loggedin"] = true;
            // Kiểm tra vai trò của người dùng
            if ($user['role'] === 'user') {
                header("location: userindex.php"); // Chuyển hướng người dùng về trang indexuser.php nếu vai trò là "user"
                exit;
            } else {
                header("location: adminindex.php"); // Chuyển hướng người dùng về trang index.php nếu vai trò không phải "user"
                exit;
            }
        } else {
            // Mật khẩu không đúng
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    } else {
        // Tên đăng nhập không tồn tại
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
    <h2>Đăng nhập</h2>
    <form action="login.php" method="post">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username"> <!-- Trường nhập tên người dùng -->

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password"> <!-- Trường nhập mật khẩu -->
        <input type="submit" value="Đăng nhập">
    </form>
    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
</body>

</html>