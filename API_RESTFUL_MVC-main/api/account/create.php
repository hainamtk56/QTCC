<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Account.php';

// Khởi tạo kết nối đến cở sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đối tượng Account
$account = new Account($connect);
$data = json_decode(file_get_contents("php://input"));

$account->user_account = $data->user_account;
$account->pass_account = $data->pass_account;
$account->type_account = $data->type_account;

$response = array();

// Kiểm tra xem tài khoản đã tồn tại hay chưa
if ($account->isDuplicate()) {
    $response['success'] = false; // Account not created
    $response['message'] = 'Duplicate data'; // Assigning the message "Duplicate data" when a duplicate account is found
} else {
    if ($account->create()) {
        $response['success'] = true; // Account created successfully
        $response['message'] = 'Account Created';
    } else {
        $response['success'] = false; // Account not created
        $response['message'] = 'Account Not Created';
    }
}

echo json_encode($response);
?>
