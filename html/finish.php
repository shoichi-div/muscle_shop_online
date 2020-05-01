<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'admin_model.php';
require_once MODEL_PATH . 'cart_model.php';
require_once MODEL_PATH . 'finish_model.php';

$dbh = get_db_connect();
session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$token = get_post_data('token');
if (is_valid_csrf_token($token) === FALSE) {
    redirect_to(LOGOUT_URL);
} else {
    $token = get_csrf_token();
}

$user = get_login_user($dbh);

$carts = get_user_carts($dbh, $user['user_id']);
$total_price = sum_carts($carts);

//トランザクション開始
$dbh->beginTransaction();
try {
    if (purchase_carts($dbh, $carts) === true) {
        set_message('商品を購入しました');
    } else {
        set_error('商品が購入できませんでした。');
        redirect_to(CART_URL);
    }

    //購入履歴・購入明細テーブル及びmiの更新
    add_history($dbh, $user['user_id']);
    add_detail($dbh, $carts);
    update_mi($dbh, $user['mi'], $user['user_id'], $total_price);

    //カート内商品の削除
    delete_user_carts($dbh, $user['user_id']);

    //コミット
    $dbh->commit();
} catch (PDOException $e) {
    //ロールバック
    $dbh->rollBack();
    set_error($e);
}

include_once VIEW_PATH . 'finish_view.php';
