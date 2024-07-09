<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Student.php';

// Khởi tạo kết nối đến cơ sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Student
$student = new Student($connect);

// Lấy dữ liệu JSON từ phần thân của yêu cầu và chuyển đổi thành đối tượng
//$data = json_decode(file_get_contents("php://input"));
$student->MaSV = isset($_GET['MaSV']) ? $_GET['MaSV'] : die(); //nhập MaSV vào api luôn,xoá đoạn if(isset($data->MaSV))

// Kiểm tra xem dữ liệu JSON có chứa trường MaSV không
// if(isset($data->MaSV)) {
//     // Gán giá trị của MaSV từ dữ liệu JSON vào thuộc tính MaSV của đối tượng Student
//     $student->MaSV = $data->MaSV;

// Gọi phương thức delete()
if ($student->delete()) {
    echo json_encode(array('message', 'student deleted'));
} else {
    echo json_encode(array('message', 'student not deleted'));
}
// } else {
//     // Trường MaSV không được cung cấp trong dữ liệu JSON, trả về thông báo lỗi
//     echo json_encode(array('message','MaSV not provMaSVed'));
//}
