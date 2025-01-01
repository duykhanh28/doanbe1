<?php
require_once 'config/database.php';
spl_autoload_register(function ($className) {
    require_once "app/models/$className.php";
});

$studentModel = new Student();
$students = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['keyword'])) {
    // Lấy từ khóa tìm kiếm và gọi phương thức tìm kiếm
    $keyword = $_GET['keyword'];
    $students = $studentModel->search($keyword);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Kiếm Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Tìm Kiếm Sinh Viên</h2>

        <!-- Form tìm kiếm -->
        <form method="get" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="keyword" placeholder="Nhập tên hoặc mã sinh viên" required>
                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
            </div>
        </form>

        <?php if (count($students) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Danh sách</th>
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
        <?php else: ?>
            <p class="text-center text-warning">Không tìm thấy sinh viên nào.</p>
        <?php endif; ?>
    </div>
</body>
</html>
