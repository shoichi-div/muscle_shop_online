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
if (is_valid_csrf_token($token) === FALSE) {
    set_error('不正なアクセスです');
    redirect_to(LOGOUT_URL);
} else {
    $token = get_csrf_token();
}

$user = get_login_user($dbh);

if (is_admin($user) === false) {
    redirect_to(LOGIN_URL);
}

$name = get_post_data('name');
$price = get_post_data('price');
$stock = get_post_data('stock');
$status = get_post_data('status');
$category = get_post_data('category');
$part = get_post_data('part');
$menu = get_post_data('menu');

insert_item($dbh, $name, $price, $stock, $status, $category, $part, $menu, $img_dir);

$items = get_all_items($dbh);

include_once VIEW_PATH . '/admin_view.php';
