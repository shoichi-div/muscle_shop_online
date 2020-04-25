<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . '/history_model.php';
require_once MODEL_PATH . '/user_model.php';

session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

//購入履歴データの取得
$purchase_data = get_purchase_data($db, $user['name'], $user['user_id']);



include_once VIEW_PATH. '/history_view.php';