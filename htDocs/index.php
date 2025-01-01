<?php
require_once 'config/database.php';
spl_autoload_register(function ($className) {
    require_once "app/models/$className.php";
});

// Kiểm tra nếu người dùng đã đăng nhập
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    exit();
}

$studentModel = new Student();
$students = $studentModel->all(); // Lấy tất cả sinh viên

// Xử lý tìm kiếm sinh viên
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $students = $studentModel->search($search); // Hàm tìm kiếm trong model
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center text-primary mb-4">Danh sách Sinh viên</h1>

        <!-- Thanh tìm kiếm -->
        <form action="index.php" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sinh viên" value="<?php echo $search; ?>">
                <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
            </div>
        </form>

        <!-- Hiển thị danh sách sinh viên -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Danh Sách</th>
                    <th>MSSV</th>
                    <th>Tên</th>
                    <th>Lớp</th>
                    <th>Chuyên Ngành</th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 1; ?>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td><?php echo $student['mssv']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['class']; ?></td>
                    <td><?php echo $student['majors']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Đăng xuất -->
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
        </div>
    </div>
</body>
</html>
