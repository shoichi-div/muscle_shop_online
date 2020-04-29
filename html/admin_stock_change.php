<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'admin_model.php';

$dbh = get_db_connect();
session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$token = get_post_data('token');
if (is_valid_csrf_token($token) === false) {
    redirect_to(LOGOUT_URL);
} else {
    $token = get_csrf_token();
}

$user = get_login_user($dbh);

if (is_admin($user) === false) {
    redirect_to(LOGIN_URL);
}

$stock_id = get_post_data('stock_id');
$stock = get_post_data('stock');

if (update_item_stock($dbh, $stock_id, $stock) === true) {
    set_message('在庫数を更新しました。');
} else {
    set_error('在庫数の更新に失敗しました。');
}

$items = get_all_items($dbh);

include_once VIEW_PATH . '/admin_view.php';
