<?php
// session_start();

// // Kiểm tra xem người dùng đã đăng nhập chưa và có phải là admin không
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== '1') {
//     header("Location: ../../login.php"); // Chuyển đến trang đăng nhập nếu không phải admin
//     exit();
// }

require_once '../../config/database.php';
spl_autoload_register(function ($className) {
    require_once "../../app/models/$className.php";
});

$studentModel = new Student();
if (isset($_POST['student-id'])) {
    $studentModel->bin($_POST['student-id']); // Xóa sinh viên
    $studentModel->reorderIds(); // Sắp xếp lại ID
    header("Location: index.php"); // Tải lại trang
    exit();
}

$students = $studentModel->all();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center text-success mb-4">Quản lý sinh viên</h1>
        <a href="add.php" class="btn btn-outline-primary">Add</a>
        <a href="bin.php" class="btn btn-outline-primary">Bin</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MSSV</th>
                    <th>Tên</th>
                    <th>Lớp</th>
                    <th>Chuyên Ngành</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['mssv']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['class']; ?></td>
                    <td><?php echo $student['majors']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $student['id'] ?>" class="btn btn-outline-primary">Edit</a>
                        <p></p>
                        <form action="index.php" method="post" onsubmit="return confirm('Xóa không?')">
                            <input type="hidden" name="student-id" value="<?php echo $student['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
