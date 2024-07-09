<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Bill2.php';

// Kiểm tra xem có tham số ID được truyền từ phía client không
if (isset($_GET['MaPhong'])) {
    // Lấy ID từ tham số truy vấn
    $MaPhong = $_GET['MaPhong'];

    // Khởi tạo kết nối đến cơ sở dữ liệu
    $db = new db();
    $connect = $db->connect();

    // Khởi tạo đối tượng Student
    $bill2 = new Bill2($connect);

    // Thực hiện tìm kiếm theo ID
    $result = $bill2->searchByMaPhong($MaPhong);

    // Kiểm tra kết quả tìm kiếm
    if ($result) {
        // Nếu tìm thấy sinh viên, trả về thông tin của sinh viên dưới dạng JSON
        echo json_encode($result);
    } else {
        // Nếu không tìm thấy sinh viên, trả về thông báo lỗi
        echo json_encode(array('message' => 'No record found for ID: ' . $MaPhong));
    }
} else {
    // Nếu không có ID được truyền từ phía client, trả về thông báo lỗi
    echo json_encode(array('message' => 'ID not provided'));
}
