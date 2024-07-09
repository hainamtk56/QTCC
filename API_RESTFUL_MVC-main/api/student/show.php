<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Student.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Student
$student = new Student($connect);

// Lấy MaSV từ tham số truy vấn hoặc dừng nếu không có MaSV được cung cấp
$student->MaSV = isset($_GET['MaSV']) ? $_GET['MaSV'] : die();

$result = $student->show();

// Kiểm tra kết quả trả về từ hàm show()
if (isset($result['message'])) {
    // Nếu có thông báo lỗi, in ra và kết thúc
    echo json_encode($result);
} else {
    // Nếu không có thông báo lỗi, in ra thông tin sinh viên
    $student_item = array(
        'MaSV' => $student->MaSV,
        'HoTen' => $student->HoTen,
        'NgaySinh' => $student->NgaySinh,
        'GioiTinh' => $student->GioiTinh,
        'DiaChi' => $student->DiaChi,
        'SDT' => $student->SDT,
        'Mail' => $student->Mail,
        'MaPhong' => $student->MaPhong,
        'TenKhu' => $student->TenKhu,
        'user_account' => $student->user_account,
    );
    echo json_encode($student_item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}?>
