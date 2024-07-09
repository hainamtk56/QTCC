<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Student.php';

$db = new db(); // db là tên class
$connect = $db->connect();

$student = new Student($connect);
$read = $student->read();

$num = $read->rowCount();

if ($num > 0) {
    $student_array = [];
    $student_array['data'] = [];

    while ($row = $read->fetch(PDO::FETCH_ASSOC)) {

        extract($row);
        $student_item = array(
            'MaSV' => $MaSV,
            'HoTen' => $HoTen,
            'NgaySinh' => $NgaySinh,
            'GioiTinh' => $GioiTinh,
            'DiaChi' => $DiaChi,
            'SDT' => $SDT,
            'Mail' => $Mail,
            'MaPhong' => $MaPhong,
            'TenKhu' => $TenKhu,
            'user_account' => $user_account,
        );

        array_push($student_array['data'], $student_item);
    }
    echo json_encode($student_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // hiển thị đẹp ,và có dấu
} else {
    echo json_encode(array('message' => 'No records found'));
}
