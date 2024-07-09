<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Student.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Student
$student = new Student($connect);
$data = json_decode(file_get_contents("php://input"));
$student->MaSV = $data->MaSV;
$student->HoTen = $data->HoTen;
$student->NgaySinh = $data->NgaySinh;
$student->GioiTinh = $data->GioiTinh;
$student->DiaChi = $data->DiaChi;
$student->SDT = $data->SDT;
$student->Mail = $data->Mail;
$student->MaPhong = $data->MaPhong;
$student->TenKhu = $data->TenKhu;
$student->user_account = $data->user_account;


if ($student->create()) {
    echo json_encode(array('message', 'student created'));
} else {
    echo json_encode(array('message', 'student not created'));
}
?>