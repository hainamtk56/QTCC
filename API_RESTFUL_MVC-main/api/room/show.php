<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Room.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Student
$room = new Room($connect);

// Lấy MP từ tham số truy vấn hoặc dừng nếu không có MP được cung cấp
$room->MaPhong = isset($_GET['MaPhong']) ? $_GET['MaPhong'] : die();

$result = $room->show();

// Kiểm tra kết quả trả về từ hàm show()
if (isset($result['message'])) {
    // Nếu có thông báo lỗi, in ra và kết thúc
    echo json_encode($result);
} else {
    // Nếu không có thông báo lỗi, in ra thông tin phong
    $room_item = array(
        'MaPhong' => $room->MaPhong,
        'MaKhu' => $room->MaKhu,
        'SoNguoiToiDa' => $room->SoNguoiToiDa,
        'SoNguoiHienTai' => $room->SoNguoiHienTai,
        'Gia' => $room->Gia,
    );
    echo json_encode($room_item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
