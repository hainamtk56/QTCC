<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Bill.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Hoadon
$bill = new Bill($connect);

// Nhận dữ liệu từ request
$data = json_decode(file_get_contents("php://input"));

// Gán dữ liệu vào các thuộc tính của đối tượng Hoadon
$bill->MaPhong = $data->MaPhong;
$bill->Thang = $data->Thang;
$bill->TienDien = $data->TienDien;  
$bill->TienNuoc = $data->TienNuoc;
$bill->TienMang = $data->TienMang;
$bill->TinhTrang = $data->TinhTrang;

// Tạo hóa đơn mới
if ($bill->create()) {
    echo json_encode(array('message' => 'Hoa don created'));
} else {
    echo json_encode(array('message' => 'Hoa don not created'));
}
