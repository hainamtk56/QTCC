<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Bill.php';

$db = new db(); // db là tên class
$connect = $db->connect();

$bill = new Bill($connect);
$read = $bill->read();

$num = $read->rowCount();

if ($num > 0) {
    $bill_array = [];
    $bill_array['data'] = [];

    while ($row = $read->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $bill_item = array(
            'MaHD' => $MaHD,
            'MaPhong' => $MaPhong,
            'Thang' => $Thang,
            'TienDien' => $TienDien,
            'TienNuoc' => $TienNuoc,
            'TienMang' => $TienMang,
            'TinhTrang' => $TinhTrang,

        );

        array_push($bill_array['data'], $bill_item);
    }
    echo json_encode($bill_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // hiển thị đẹp ,và có dấu
} else {
    echo json_encode(array('message' => 'No records found'));
}
