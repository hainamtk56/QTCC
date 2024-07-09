<?php
// Kết nối đến cơ sở dữ liệu
include_once '../../config/db.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$pdo = $db->connect();

// Truy vấn để lấy tất cả các mã phòng
$sql = "SELECT MaPhong FROM Phong";

// Chuẩn bị câu lệnh SQL
$stmt = $pdo->prepare($sql);

// Thực thi câu lệnh
if ($stmt->execute()) {
    // Lấy tất cả các mã phòng và đưa chúng vào một mảng
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($rooms);
} else {
    // Trả về thông báo lỗi nếu không thể thực thi câu lệnh SQL
    http_response_code(500);
    echo json_encode(array("message" => "Không thể lấy danh sách mã phòng từ cơ sở dữ liệu."));
}

// Đóng kết nối
$pdo = null;
?>
