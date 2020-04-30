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
    set_error('不正なアクセスです');
    redirect_to(LOGOUT_URL);
} else {
    $token = get_csrf_token();
}

$user = get_login_user($dbh);

if (is_admin($user) === false) {
    redirect_to(LOGIN_URL);
}

$category = get_post_data('category');
$id = get_post_data('id');

if (update_category($dbh, $category, $id) === true) {
    set_message('カテゴリーを更新しました。');
} else {
    set_error('カテゴリーの更新に失敗しました。');
}

$items = get_all_items($dbh);

include_once VIEW_PATH . '/admin_view.php';
