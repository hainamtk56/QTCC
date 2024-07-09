<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Bill.php';

// Lấy MaHD và TinhTrang từ tham số truy vấn
$MaHD = isset($_GET['MaHD']) ? $_GET['MaHD'] : die();
$TinhTrang = isset($_GET['TinhTrang']) ? $_GET['TinhTrang'] : die();

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Hoadon
$bill = new Bill($connect);

// Gán giá trị cho các thuộc tính
$bill->MaHD = $MaHD;
$bill->TinhTrang = $TinhTrang;

// Thực hiện cập nhật trạng thái của hóa đơn
if ($bill->updateStatus()) {
    echo json_encode(array('message' => 'Hóa đơn đã được cập nhật thành công.'));
} else {
    echo json_encode(array('message' => 'Không thể cập nhật trạng thái của hóa đơn.'));
}
