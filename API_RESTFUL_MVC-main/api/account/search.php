<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../model/Account.php';

$db = new db();
$connect = $db->connect();

$account = new Account($connect);

// Kiểm tra xem từ khóa tìm kiếm đã được gửi từ frontend chưa
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : die();

// Thực hiện tìm kiếm tài khoản theo từ khóa
$result = $account->search($keyword);

// Kiểm tra kết quả của tìm kiếm
if (isset($result['message'])) {
    // Nếu có thông báo lỗi, in ra và kết thúc
    echo json_encode($result);
} else {
    // Nếu có kết quả, trả về danh sách các tài khoản tìm thấy
    $accounts_array = array();
    foreach ($result as $account) {
        $account_item = array(
            'id_account' => $account['id_account'],
            'user_account' => $account['user_account'],
            'pass_account' => $account['pass_account'],
            'type_account' => $account['type_account']
        );
        array_push($accounts_array, $account_item);
    }
    echo json_encode($accounts_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
