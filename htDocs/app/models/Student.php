<?php
class Student extends Database
{
    public function all()
    {
        // 2. Tạo câu query
        // $sql = parent::$connection->prepare('SELECT * from `products`');
        $sql = parent::$connection->prepare("SELECT * FROM `students` WHERE `status` = 1");
        // 3 & 4
        return parent::select($sql);
    }
    public function bin($studentsId)
    {
        // 2. Tạo câu query
        $sql = parent::$connection->prepare("UPDATE `students` SET `status`=0 WHERE `id`=?");
        $sql->bind_param('i', $studentsId);
        // 3 & 4
        return $sql->execute();
    }

    public function restore($id)
    {
        $sql = parent::$connection->prepare('UPDATE `students` SET `status` = 1 WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }

    public function delete($id)
    {
        $sql = parent::$connection->prepare('DELETE FROM `students` WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }

    public function allBin()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `students` WHERE `status` = 0');
        return parent::select($sql);
    }
    public function getStudentById($id)
{
    $sql = parent::$connection->prepare('SELECT * FROM `students` WHERE `id` = ?');
    $sql->bind_param('i', $id);
    $result = parent::select($sql);
    return !empty($result) ? $result[0] : null;
}
public function update($id, $mssv, $name, $class, $majors)
{
    $sql = parent::$connection->prepare(
        'UPDATE `students` 
         SET `mssv` = ?, `name` = ?, `class` = ?, `majors` = ? 
         WHERE `id` = ?'
    );
    $sql->bind_param('ssssi', $mssv, $name, $class, $majors, $id);
    return $sql->execute();
}
public function add($mssv, $name, $class, $majors)
{
    $sql = parent::$connection->prepare(
        'INSERT INTO `students` (`mssv`, `name`, `class`, `majors`, `status`) 
         VALUES (?, ?, ?, ?, 1)'
    );
    $sql->bind_param('ssss', $mssv, $name, $class, $majors);
    return $sql->execute();
}
public function reorderIds()
{
    try {
        // Bắt đầu transaction để đảm bảo tính toàn vẹn
        parent::$connection->begin_transaction();

        // Đặt lại biến @new_id
        $sql = parent::$connection->prepare("SET @new_id = 0;");
        $sql->execute();

        // Cập nhật lại ID theo thứ tự
        $sql = parent::$connection->prepare(
            "UPDATE `students` AS s 
             JOIN (SELECT `id` FROM `students` ORDER BY `id`) AS sorted 
             ON s.`id` = sorted.`id` 
             SET s.`id` = (@new_id := @new_id + 1);"
        );
        $sql->execute();

        // Đặt lại AUTO_INCREMENT
        $sql = parent::$connection->prepare("ALTER TABLE `students` AUTO_INCREMENT = 1;");
        $sql->execute();

        // Hoàn tất transaction
        parent::$connection->commit();
        return true;
    } catch (mysqli_sql_exception $e) {
        // Hủy transaction nếu có lỗi
        parent::$connection->rollback();
        throw $e;
    }
}
public function search($keyword) {
    // Tạo câu truy vấn tìm kiếm sinh viên theo mã sinh viên, tên hoặc lớp
    $sql = parent::$connection->prepare('
        SELECT * FROM `students` 
        WHERE `mssv` LIKE ? OR `name` LIKE ? OR `class` LIKE ? 
    ');

    // Chèn dấu % để tìm kiếm kiểu LIKE
    $searchTerm = '%' . $keyword . '%';
    $sql->bind_param('sss', $searchTerm, $searchTerm, $searchTerm); // Ba tham số cho ba cột (mssv, name, class)
    
    // Thực thi truy vấn và trả về kết quả
    return parent::select($sql);
}

}