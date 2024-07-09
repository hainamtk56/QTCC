<?php
include_once "../../config/db.php";
include_once "../../model/Register.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem dữ liệu có được gửi từ form đăng ký không
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
        // Lấy dữ liệu từ form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        // Kiểm tra xem mật khẩu và xác nhận mật khẩu có khớp không
        if ($password !== $confirmPassword) {
            echo json_encode(array("success" => false, "message" => "Password and confirm password do not match."));
            exit;
        }

        // Tạo một đối tượng đăng ký mới
        $register = new Register();

        // Thực hiện đăng ký
        $result = $register->registerUser($username, $password);

        // Trả về kết quả dưới dạng JSON
        echo json_encode($result);
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid request parameters."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
}
