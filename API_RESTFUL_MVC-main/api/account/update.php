<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Account.php';

// Khởi tạo kết nối đến cở sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đổi tượng Account
$account = new Account($connect);
$data = json_decode(file_get_contents("php://input"));

$account->id_account = $data->id_account;
$account->user_account = $data->user_account;
$account->pass_account = $data->pass_account;
$account->type_account = $data->type_account;

if ($account->update()) {
    echo json_encode(array('message', 'Update Successful'));
} else {
    echo json_encode(array('message', 'Account Not Updated'));
}