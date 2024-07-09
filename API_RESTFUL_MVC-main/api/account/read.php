<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Account.php';

$db = new db();
$connect = $db->connect();

$account = new Account($connect);
$read = $account->read();

$num = $read->rowCount();

if ($num > 0) {
    $account_array = [];
    $account_array['data'] = [];

    while ($row = $read->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $account_item = array(
            'id_account' => $id_account,
            'user_account' => $user_account,
            'pass_account' => $pass_account,
            'type_account' => $type_account,
        );

        array_push($account_array['data'], $account_item);
    }
    echo json_encode($account_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // hiển thị đẹp ,và có dấu
} else {
    echo json_encode(array('message' => 'No records found'));
}
?>