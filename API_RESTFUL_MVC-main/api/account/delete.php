<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../model/Account.php';

// Khởi tạo kết nối đến cở sở dữ liệu
$db = new db();
$connect = $db->connect();

// Khởi tạo đổi tượng Account
$account = new Account($connect);

// $data = json_decode(file_get_contents("php://input"));
// $account->id_account = $data->id_account;

$account->id_account = isset($_GET['id_account']) ? $_GET['id_account'] : die();

if ($account->delete()) {
    echo json_encode(array('message', 'Account deleted'));
} else {
    echo json_encode(array('message', 'Account not deleted'));
}