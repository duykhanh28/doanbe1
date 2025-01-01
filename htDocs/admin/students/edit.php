<?php
require_once '../../config/database.php';
spl_autoload_register(function ($className) {
    require_once "../../app/models/$className.php";
});

$studentModel = new Student();
$student = null;
$message = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $student = $studentModel->getStudentById($id);

    if (!$student) {
        die("Sinh viên không tồn tại!");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $mssv = $_POST['mssv'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $majors = $_POST['majors'];

    if ($studentModel->update($id, $mssv, $name, $class, $majors)) {
        $message = "Cập nhật thành công!";
        $student = $studentModel->getStudentById($id); // Lấy lại dữ liệu mới
    } else {
        $message = "Cập nhật thất bại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center text-primary mb-4">Chỉnh sửa sinh viên</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($student): ?>
        <form action="edit.php?id=<?php echo $student['id']; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <div class="mb-3">
                <label for="mssv" class="form-label">MSSV</label>
                <input type="text" id="mssv" name="mssv" class="form-control" value="<?php echo $student['mssv']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Lớp</label>
                <input type="text" id="class" name="class" class="form-control" value="<?php echo $student['class']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="majors" class="form-label">Chuyên ngành</label>
                <input type="text" id="majors" name="majors" class="form-control" value="<?php echo $student['majors']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="index.php" class="btn btn-secondary">Quay Lại</a>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
