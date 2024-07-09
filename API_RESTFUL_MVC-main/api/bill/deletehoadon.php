<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Lấy ID từ tham số truy vấn hoặc dừng nếu không có ID được cung cấp
$bill->MaHD = isset($_GET['MaHD']) ? $_GET['MaHD'] : die();

// Gọi phương thức delete()
if ($bill->delete()) {
    echo json_encode(array('message' => 'Hoa don deleted'));
} else {
    echo json_encode(array('message' => 'Hoa don not deleted'));
}
