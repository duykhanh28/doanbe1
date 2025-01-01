<?php
class User extends Database
{
    // Hàm đăng ký người dùng
    public function register($username, $password) {
        // Mã hóa mật khẩu
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Tạo câu truy vấn để thêm người dùng vào cơ sở dữ liệu
        $sql = parent::$connection->prepare('INSERT INTO `users`(`username`, `password`) VALUES (?, ?)');
        $sql->bind_param('ss', $username, $passwordHash);

        // Thực thi câu truy vấn và trả về kết quả
        return $sql->execute();
    }

    // Hàm đăng nhập
    public function login($username, $password) {
        // Tạo câu truy vấn để lấy người dùng theo tên đăng nhập
        $sql = parent::$connection->prepare('SELECT * FROM `users` WHERE `username` = ?');
        $sql->bind_param('s', $username);
        
        // Thực thi truy vấn và lấy kết quả
        $result = parent::select($sql);
        
        // Kiểm tra xem có người dùng nào với tên đăng nhập này không
        if (count($result) > 0) {
            // Kiểm tra mật khẩu
            if (password_verify($password, $result[0]['password'])) {
                // Đăng nhập thành công, lưu thông tin vào session
                $_SESSION['user_id'] = $result[0]['id'];
                $_SESSION['username'] = $result[0]['username'];
                $_SESSION['role'] = $result[0]['role']; // Lưu vai trò của người dùng vào session

                return $result[0]; // Trả về thông tin người dùng nếu mật khẩu chính xác
            }
        }
        
        return false; // Trả về false nếu đăng nhập thất bại
    }

    // Hàm kiểm tra xem tên người dùng có tồn tại không
    public function checkUsernameExists($username) {
        $sql = parent::$connection->prepare('SELECT * FROM `users` WHERE `username` = ?');
        $sql->bind_param('s', $username);
        $result = parent::select($sql);

        return count($result) > 0; // Trả về true nếu tên người dùng đã tồn tại
    }

    // Hàm lấy ID người dùng
    public function getUserId($username) {
        $sql = parent::$connection->prepare('SELECT id FROM `users` WHERE `username` = ?');
        $sql->bind_param('s', $username);
        $result = parent::select($sql);

        return $result[0]['id']; // Trả về ID người dùng
    }
}
