<?php
session_start();

// Xóa tất cả các session đã lưu
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập sau khi đăng xuất
header("Location: login.php");
exit();
?>
