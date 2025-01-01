<?php
require_once 'config/database.php';
spl_autoload_register(function ($className) {
    require_once "app/models/$className.php";
});

$userModel = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register-username'], $_POST['register-password'], $_POST['register-role'])) {
    $registerUsername = $_POST['register-username'];
    $registerPassword = $_POST['register-password'];
    $registerRole = $_POST['register-role'];  // '1' for admin, '0' for user

    // Đăng ký người dùng mới
    $registerResult = $userModel->register($registerUsername, $registerPassword, $registerRole);

    if ($registerResult) {
        // Thông báo đăng ký thành công và chuyển hướng đến trang đăng nhập
        $registerSuccess = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
        header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
        exit(); // Đảm bảo không có mã nào khác được thực thi sau khi chuyển hướng
    } else {
        $registerError = "Đăng ký không thành công. Vui lòng thử lại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Đăng Ký</h2>
        <?php if (isset($registerError)): ?>
            <div class="alert alert-danger"><?php echo $registerError; ?></div>
        <?php endif; ?>
        <?php if (isset($registerSuccess)): ?>
            <div class="alert alert-success"><?php echo $registerSuccess; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="register-username" class="form-label">Tên Đăng Nhập</label>
                <input type="text" class="form-control" id="register-username" name="register-username" required>
            </div>
            <div class="mb-3">
                <label for="register-password" class="form-label">Mật Khẩu</label>
                <input type="password" class="form-control" id="register-password" name="register-password" required>
            </div>
            <div class="mb-3">
                <label for="register-role" class="form-label">Vai trò</label>
                <select class="form-control" id="register-role" name="register-role" required>
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <button type="submit" name="register" class="btn btn-success">Đăng Ký</button>
        </form>

        <p class="text-center mt-3">
            <a href="login.php">Đã có tài khoản? Đăng nhập ngay!</a>
        </p>
    </div>
</body>
</html>
