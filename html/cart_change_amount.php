<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'cart_model.php';

$dbh = get_db_connect();
session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$token = get_post_data('token');
if (is_valid_csrf_token($token) === FALSE) {
    set_error('不正なアクセスです');
    redirect_to(LOGOUT_URL);
} else {
    $token = get_csrf_token();
}

$user = get_login_user($dbh);

$cart_id = get_post_data('id');
$amount = get_post_data('amount');



if (update_cart_amount($dbh, $cart_id, $amount)) {
    set_message('購入数を更新しました。');
} else {
    set_error('購入数の更新に失敗しました。');
}

redirect_to(CART_URL);
