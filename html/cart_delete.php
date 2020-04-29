<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'cart_model.php';

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

$dbh = get_db_connect();
$user = get_login_user($dbh);

$cart_id = get_post_data('id');

if (delete_cart($dbh, $cart_id)) {
    set_message('カートの商品を削除しました。');
} else {
    set_error('カートの商品削除に失敗しました。');
}

redirect_to(CART_URL);
