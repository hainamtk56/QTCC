<?php
// Kết nối đến cơ sở dữ liệu
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';


// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Lấy dữ liệu từ yêu cầu PUT
$data = json_decode(file_get_contents("php://input"));

if(isset($data->MaPhong) && isset($data->SoNguoiHienTai)) {
    // Chuyển đổi dữ liệu thành dạng integer
    $MaPhong = intval($data->MaPhong);
    $SoNguoiHienTai = intval($data->SoNguoiHienTai);

    // Cập nhật số người hiện tại trong cơ sở dữ liệu
    $sql = "UPDATE Phong SET SoNguoiHienTai = :SoNguoiHienTai WHERE MaPhong = :MaPhong";

    // Chuẩn bị câu lệnh SQL
    $stmt = $pdo->prepare($sql);

    // Bind các tham số
    $stmt->bindParam(':SoNguoiHienTai', $SoNguoiHienTai, PDO::PARAM_INT);
    $stmt->bindParam(':MaPhong', $MaPhong, PDO::PARAM_STR);

    // Thực thi câu lệnh
    if($stmt->execute()) {
        // Trả về thông báo thành công
        http_response_code(200);
        echo json_encode(array("message" => "Số người hiện tại đã được cập nhật."));
    } else {
        // Trả về thông báo lỗi nếu không thể cập nhật
        http_response_code(500);
        echo json_encode(array("message" => "Không thể cập nhật số người hiện tại."));
    }
} else {
    // Trả về thông báo lỗi nếu dữ liệu không hợp lệ
    http_response_code(400);
    echo json_encode(array("message" => "Dữ liệu không hợp lệ."));
}
?>
