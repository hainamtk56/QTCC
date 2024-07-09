<?php
require_once '../../config/db.php';
require_once '../../model/Login.php';

// Xử lý request POST khi submit form đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Tạo đối tượng LoginModel và kiểm tra đăng nhập
    $login = new Login();
    $result = $login->authenticate($username, $password);

    // Trả về kết quả
    echo json_encode($result);
}
