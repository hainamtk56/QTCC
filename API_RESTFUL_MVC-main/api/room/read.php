<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Room.php';

$db = new db(); // Khởi tạo đối tượng kết nối PDO từ class db
$connect = $db->connect(); // Lấy kết nối từ đối tượng db

$room = new Room($connect); // Truyền kết nối vào hàm khởi tạo của class phong
$read = $room->read(); // Gọi phương thức read() từ class phong

$num = $read->rowCount();

if ($num > 0) {
    $room_array = [];
    $room_array['data'] = [];

    while ($row = $read->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $room_item = array(
            'MaPhong' => $MaPhong,
            'MaKhu' => $MaKhu,
            'SoNguoiToiDa' => $SoNguoiToiDa,
            'SoNguoiHienTai' => $SoNguoiHienTai,
            'Gia' => $Gia,
        );

        array_push($room_array['data'], $room_item);
    }
    echo json_encode($room_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // hiển thị đẹp ,và có dấu
} else {
    echo json_encode(array('message' => 'No records found'));
}
