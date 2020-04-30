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
if (is_valid_csrf_token($token) === false) {
    set_error('不正なアクセスです');
    redirect_to(LOGOUT_URL);
} else {
    $token = get_csrf_token();
}

$mi_status = get_post_data('mi_status');
$user = get_login_user($dbh);

if (update_mi_status($dbh, $mi_status, $user['user_id']) === true) {
    set_message('miステータスを更新しました。');
} else if (update_mi_status($dbh, $mi_status, $user['user_name']) === 'else') {
    set_error('miステータスの更新に失敗しました。');
    set_error('miステータスの値は0か1を入力してください');
} else {
    set_error('miステータスの更新に失敗しました。');
}

redirect_to(HOME_URL);
