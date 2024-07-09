<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Room.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng phong
$room = new Room($connect);

// Lấy dữ liệu JSON từ phần thân của yêu cầu và chuyển đổi thành đối tượng
// $data = json_decode(file_get_contents("php://input"));
$room->MaPhong = isset($_GET['MaPhong']) ? $_GET['MaPhong'] : die(); //nhập id vào api luôn,xoá đoạn if(isset($data->id))

// Kiểm tra xem dữ liệu JSON có chứa trường MaPhong không
// if(isset($data->MaPhong)) {
// Gán giá trị của MaPhong từ dữ liệu JSON vào thuộc tính id của đối tượng phong
// $phong->MaPhong = $data->MaPhong;

// Gọi phương thức delete()
if ($room->delete()) {
    echo json_encode(array('message', 'phong deleted'));
} else {
    echo json_encode(array('message', 'phong not deleted'));
}
// } else {
//     // Trường MP không được cung cấp trong dữ liệu JSON, trả về thông báo lỗi
//     echo json_encode(array('message','MaPhong not provided'));
// }
