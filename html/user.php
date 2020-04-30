<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';

//DB接続
$dbh = get_db_connect();

session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$user = get_login_user($dbh);

if (is_admin($user) === false) {
    redirect_to(HOME_URL);
}

$user_data = get_all_users($dbh);

//viewファイル読み込み
include_once VIEW_PATH . 'user_view.php';
