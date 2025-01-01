<?php
require_once '../../config/database.php';
spl_autoload_register(function ($className) {
    require_once "../../app/models/$className.php";
});

$studentModel = new Student();

// Xử lý khôi phục nhiều sinh viên
if (isset($_POST['restore-ids']) && !empty($_POST['restore-ids'])) {
    foreach ($_POST['restore-ids'] as $restoreId) {
        $studentModel->restore($restoreId);
    }
}

// Xử lý xóa vĩnh viễn sinh viên
if (isset($_POST['delete-id'])) {
    $studentModel->delete($_POST['delete-id']); // Xóa vĩnh viễn
}

$students = $studentModel->allBin();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thùng rác</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center text-danger mb-4">Thùng rác</h1>
        <a href="index.php" class="btn btn-primary mb-3">Quay lại</a>

        <!-- Form khôi phục nhiều sinh viên -->
        <form action="bin.php" method="post">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th> <!-- Checkbox chọn tất cả -->
                        <th>#</th>
                        <th>MSSV</th>
                        <th>Tên</th>
                        <th>Lớp</th>
                        <th>Chuyên Ngành</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td><input type="checkbox" name="restore-ids[]" value="<?php echo $student['id']; ?>"></td>
                        <td><?php echo $index++; ?></td>
                        <td><?php echo $student['mssv']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['class']; ?></td>
                        <td><?php echo $student['majors']; ?></td>
                        <td>
                            <form action="bin.php" method="post">
                                <input type="hidden" name="restore-id" value="<?php echo $student['id'] ?>">
                                <button type="submit" class="btn btn-outline-success">Restore</button>
                            </form>
                            <form action="bin.php" method="post" onsubmit="return confirm('Xóa vĩnh viễn?')">
                                <input type="hidden" name="delete-id" value="<?php echo $student['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger">Delete Permanently</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Nút khôi phục tất cả -->
            <button type="submit" class="btn btn-outline-success">Khôi phục tất cả đã chọn</button>
        </form>
    </div>

    <script>
        // Chọn hoặc bỏ chọn tất cả checkbox
        document.getElementById('select-all').addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('input[name="restore-ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });
    </script>
</body>
</html>
