<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Bill2.php';

$db = new db(); // db là tên class
$connect = $db->connect();

$bill2 = new Bill2($connect);
$read = $bill2->read();

$num = $read->rowCount();

if ($num > 0) {
    $bill2_array = [];
    $bill2_array['data'] = [];

    while ($row = $read->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $bill2_item = array(
            'MaPhong' => $MaPhong,
            'MaKhu' => $MaKhu,
            'SoNguoiToiDa' => $SoNguoiToiDa,
            'SoNguoiHienTai' => $SoNguoiHienTai,
            'Gia' => $Gia,

        );

        array_push($bill2_array['data'], $bill2_item);
    }
    echo json_encode($bill2_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // hiển thị đẹp ,và có dấu
} else {
    echo json_encode(array('message' => 'No records found'));
}
