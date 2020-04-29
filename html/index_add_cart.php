<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'cart_model.php';

$err = array();
$err[] = 'aa';

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
$item_id = get_post_data('item_id');
$amount = get_post_data('amount');

if (add_cart($dbh, $user['user_id'], $item_id, $amount)) {
    set_message('カートに商品を追加しました。');
} else {
    set_error('カートの更新に失敗しました。');
}

redirect_to(HOME_URL);
