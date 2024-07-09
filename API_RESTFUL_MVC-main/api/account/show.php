<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Account.php';

$db = new db();
$connect = $db->connect();

$account = new Account($connect);

$account->id_account = isset($_GET['id_account']) ? $_GET['id_account'] : die();

$result = $account->show();

if (isset($result['message'])) {
    // Nếu có thông báo lỗi, in ra và kết thúc
    echo json_encode($result);
} else {
    $account_item = array(
        'id_account'=> $account->
        id_account,
        'user_account' => $account->user_account,
        'pass_account' => $account->pass_account,
        'type_account' => $account->type_account,
    );
    echo json_encode($account_item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>