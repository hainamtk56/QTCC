<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Bill.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Hoadon
$bill = new Bill($connect);

// Lấy MaHD từ tham số truy vấn hoặc dừng nếu không có MaHD được cung cấp
$bill->MaHD = isset($_GET['MaHD']) ? $_GET['MaHD'] : die();

$result = $bill->show();

// Kiểm tra kết quả trả về từ hàm show()
if (isset($result['message'])) {
    // Nếu có thông báo lỗi, in ra và kết thúc
    echo json_encode($result);
} else {
    // Nếu không có thông báo lỗi, in ra thông tin hóa đơn
    $bill_item = array(
        'MaHD' => $bill->MaHD,
        'MaPhong' => $bill->MaPhong,
        'Thang' => $bill->Thang,
        'TienDien' => $bill->TienDien,
        'TienNuoc' => $bill->TienNuoc,
        'TienMang' => $bill->TienMang,
        'TinhTrang' => $bill->TinhTrang,
    );
    echo json_encode($bill_item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
