<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'history_model.php';
require_once MODEL_PATH . 'user_model.php';

$dbh = get_db_connect();
session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$user = get_login_user($dbh);

//購入履歴データの取得
$purchase_data = get_purchase_data($dbh, $user['user_name'], $user['user_id']);


include_once VIEW_PATH . 'history_view.php';