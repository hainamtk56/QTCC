<?php
// Kết nối đến cơ sở dữ liệu
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';

$db = new db(); // Khởi tạo đối tượng kết nối PDO từ class db
$conn = $db->connect(); // Lấy kết nối từ đối tượng db

// Truy vấn để lấy số lượng sinh viên hiện tại trong mỗi phòng
$sql = "SELECT phong.MaPhong, COUNT(sinhvien.MaPhong) AS SoSinhVien
        FROM phong
        LEFT JOIN sinhvien ON phong.MaPhong = sinhvien.MaPhong
        GROUP BY phong.MaPhong";

$stmt = $conn->prepare($sql);
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows) {
    echo json_encode($rows);
} else {
    echo json_encode(array()); // Trả về mảng JSON trống nếu không có dữ liệu
}
