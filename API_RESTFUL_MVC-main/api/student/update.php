<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Student.php';

// Lấy dữ liệu JSON gửi từ client
$data = json_decode(file_get_contents('php://input'), true); // để đọc dữ liệu JSON gửi từ client

// Kiểm tra xem có tồn tại tham số 'MaSV' trong dữ liệu gửi từ client không
if (isset($data['MaSV'])) {
    // Lấy thông tin sinh viên từ dữ liệu gửi từ client
    $MaSV = $data['MaSV'];
    $HoTen = $data['HoTen'];
    $NgaySinh = $data['NgaySinh'];
    $GioiTinh = $data['GioiTinh'];
    $DiaChi = $data['DiaChi'];
    $SDT = $data['SDT'];
    $Mail = $data['Mail'];
    $MaPhong = $data['MaPhong'];
    $TenKhu = $data['TenKhu'];
    $user_account  = $data['user_account'];

    // Khởi tạo kết nối đến cơ sở dữ liệu
    $db = new db();
    $connect = $db->connect();

    // Khởi tạo đối tượng Student
    $student = new Student($connect);

    // Cập nhật thông tin sinh viên
    $student->MaSV = $data['MaSV'];
    $student->HoTen = $data['HoTen'];
    $student->NgaySinh = $data['NgaySinh'];
    $student->GioiTinh = $data['GioiTinh'];
    $student->DiaChi = $data['DiaChi'];
    $student->SDT = $data['SDT'];
    $student->Mail = $data['Mail'];
    $student->MaPhong = $data['MaPhong'];
    $student->TenKhu = $data['TenKhu'];
    $student->user_account = $data['user_account'];

    // Thực hiện cập nhật thông tin
    if ($student->update()) {
        echo json_encode(array('success' => true, 'message' => 'Student updated successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Failed to update student'));
    }
} else {
    echo json_encode(array('message' => 'MaSV not provided'));
}
