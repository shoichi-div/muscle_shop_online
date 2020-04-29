<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'admin_model.php';
require_once MODEL_PATH . 'cart_model.php';
require_once MODEL_PATH . 'finish_model.php';

session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$token = get_post_data('token');
if (is_valid_csrf_token($token) === FALSE) {
    // redirect_to(LOGOUT_URL);
} else {
    $token = get_csrf_token();
}

$dbh = get_db_connect();
$user = get_login_user($dbh);

$carts = get_user_carts($dbh, $user['user_id']);

if (purchase_carts($dbh, $carts) === false) {
    set_error('商品が購入できませんでした。');
    redirect_to(CART_URL);
}

//トランザクション開始
$dbh->beginTransaction();
try {
    //購入履歴・購入明細テーブルの更新
    add_history($dbh, $user['user_id']);
    add_detail($dbh, $carts);

    delete_user_carts($dbh, $user['user_id']);


    $total_price = sum_carts($carts);

    //コミット
    $dbh->commit();
} catch (PDOException $e) {
    //ロールバック
    $db->rollBack();
    set_error($e);
}



include_once VIEW_PATH . 'finish_view.php';
