<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'user_model.php';

//DB接続
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

list($category, $part, $keyword, $word) = serch_value();

$user = get_login_user($dbh);

//mi値取得
$mi_data = mi_check($dbh, $user['user_name']);

$item_data = get_data_serched($dbh, $category, $part, $keyword);

//viewファイル読み込み
include_once VIEW_PATH . 'index_view.php';
