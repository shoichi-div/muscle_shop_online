<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'cart_model.php';
require_once MODEL_PATH . 'history_model.php';
require_once MODEL_PATH . 'detail_model.php';

$dbh = get_db_connect();
session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$user = get_login_user($dbh);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buy_id = get_post_data('buy_id');
    $total_price = get_post_data('total');
} else {
    print "不正なアクセスです\n5秒後に商品一覧に戻ります";
    sleep(5);
    redirect_to(HOME_URL);
}

//購入履歴・購入明細テーブルの更新
$purchase_detail = get_detail_data($dbh, $user['name'], $user['user_id'], $buy_id);

$subtotal = calculation_subtotal($purchase_detail);


include_once VIEW_PATH . 'detail_view.php';
