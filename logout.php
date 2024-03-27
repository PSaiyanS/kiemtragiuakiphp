<?php
// Bắt đầu phiên làm việc
session_start();

// Xóa tất cả các biến phiên
$_SESSION = array();

// Hủy phiên làm việc
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chính
header("Location: login.php"); // Thay đổi đường dẫn này nếu cần
exit;
?>
