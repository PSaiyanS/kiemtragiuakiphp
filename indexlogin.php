<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php"); // Chuyển hướng người dùng đã đăng nhập đến trang chính
    exit;
}

// Xử lý dữ liệu đăng nhập khi người dùng gửi form
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Kiểm tra username và password có hợp lệ không, ví dụ:
    if($_POST['username'] === 'admin' && $_POST['password'] === 'password'){
        // Đăng nhập thành công, lưu session và chuyển hướng đến trang chính
        $_SESSION["loggedin"] = true;
        header("location: index.php");
    } else{
        // Đăng nhập không thành công, hiển thị thông báo lỗi
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>