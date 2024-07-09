<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Student.php';

$db = new db();
$connect = $db->connect();

$student = new Student($connect);

// Kiểm tra xem từ khóa tìm kiếm đã được gửi từ frontend chưa
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : die();

// Thực hiện tìm kiếm tài khoản theo từ khóa
$result = $student->search($keyword);

// Kiểm tra kết quả của tìm kiếm
if (isset($result['message'])) {
    // Nếu có thông báo lỗi, in ra và kết thúc
    echo json_encode($result);
} else {
    // Nếu có kết quả, trả về danh sách các tài khoản tìm thấy
    $students_array = array();
    foreach ($result as $student) {
        $student_item = array(
            'MaSV' => $student['MaSV'],
            'HoTen' => $student['HoTen'],
            'NgaySinh' => $student['NgaySinh'],
            'GioiTinh' => $student['GioiTinh'],
            'DiaChi' => $student['DiaChi'],
            'SDT' => $student['SDT'],
            'Mail' => $student['Mail'],
            'MaPhong' => $student['MaPhong'],
            'TenKhu' => $student['TenKhu'],
            'user_account' => $student['user_account']
        );
        array_push($students_array, $student_item);
    }
    echo json_encode($students_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
