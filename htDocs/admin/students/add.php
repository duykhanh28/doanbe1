<?php
require_once '../../config/database.php';
spl_autoload_register(function ($className) {
    require_once "../../app/models/$className.php";
});

$studentModel = new Student();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mssv = $_POST['mssv'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $majors = $_POST['majors'];

    if ($studentModel->add($mssv, $name, $class, $majors)) {
        $message = "Thêm sinh viên thành công!";
    } else {
        $message = "Thêm sinh viên thất bại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center text-success mb-4">Thêm sinh viên mới</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="add.php" method="post">
            <div class="mb-3">
                <label for="mssv" class="form-label">MSSV</label>
                <input type="text" id="mssv" name="mssv" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Lớp</label>
                <input type="text" id="class" name="class" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="majors" class="form-label">Chuyên ngành</label>
                <input type="text" id="majors" name="majors" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="index.php" class="btn btn-secondary">Quay Lại</a>
        </form>
    </div>
</body>
</html>
