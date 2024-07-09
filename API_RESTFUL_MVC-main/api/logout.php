<?php
session_start();

// Hủy tất cả các biến trong phiên làm việc
$_SESSION = array();

// Nếu bạn muốn hủy bỏ phiên làm việc, hãy xóa cả cookie của phiên
// Lưu ý rằng điều này sẽ xóa phiên làm việc, không chỉ hủy bỏ dữ liệu trong phiên.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hủy bỏ phiên làm việc
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập hoặc trang chính sau khi đăng xuất
header("Location: ../view/login/index.html");
exit;
?>
