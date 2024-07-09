<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Room.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng phòng
$room = new Room($connect);
$data = json_decode(file_get_contents("php://input"));
$room->MaPhong = $data->MaPhong;
$room->MaKhu = $data->MaKhu;
$room->SoNguoiToiDa = $data->SoNguoiToiDa;
$room->SoNguoiHienTai = $data->SoNguoiHienTai;
$room->Gia = $data->Gia;

if ($room->create()) {
    echo json_encode(array('message', 'phong created'));
} else {
    echo json_encode(array('message', 'phong not created'));
}
