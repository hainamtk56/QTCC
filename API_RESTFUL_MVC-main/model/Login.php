<?php
require_once '../../config/db.php';

class Login {
    private $conn;

    public function __construct() {
        $database = new db();
        $db = $database->connect();
        $this->conn = $db;
    }

    public function authenticate($username, $password) {
        try {
            // Chuẩn bị câu truy vấn
            $query = "SELECT * FROM accounts WHERE user_account = :username AND pass_account = :password";

            // Chuẩn bị và thực thi câu truy vấn
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Đăng nhập thành công
                return array('success' => true, 'message' => 'Login successful');
            } else {
                // Sai tên đăng nhập hoặc mật khẩu
                return array('success' => false, 'message' => 'Incorrect username or password');
            }
        } catch(PDOException $e) {
            // Lỗi khi thực thi câu truy vấn
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
}
