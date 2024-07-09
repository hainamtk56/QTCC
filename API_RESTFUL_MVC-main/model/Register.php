<?php
include_once "../../config/db.php";

class Register
{
    private $db;

    public function __construct()
    {
        $this->db = new db();
    }

    public function registerUser($username, $password)
    {
        try {
            $conn = $this->db->connect();

            // Kiểm tra xem người dùng đã tồn tại chưa
            $stmt = $conn->prepare("SELECT * FROM accounts WHERE user_account = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return array("success" => false, "message" => "Username already exists.");
            }

            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Thêm người dùng mới vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO accounts (user_account, pass_account, type_account) VALUES (?, ?, '')");
            $stmt->execute([$username, $password]);

            return array("success" => true, "message" => "User registered successfully.");
        } catch (PDOException $e) {
            return array("success" => false, "message" => "Registration failed: " . $e->getMessage());
        }
    }
}
?>
