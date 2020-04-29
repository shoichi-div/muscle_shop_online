<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';

session_start();

if (is_logined() === true) {
    redirect_to(HOME_URL);
}

$token = get_post_data('token');
if (is_valid_csrf_token($token) === FALSE) {
    redirect_to(LOGIN_URL);
} else {
    $token = get_csrf_token();
}

$name = get_post_data('user_name');
$password = get_post_data('password');

$dbh = get_db_connect();


$user = login_as($dbh, $name, $password);
if ($user === false) {
    set_error('ログインに失敗しました。');
    redirect_to(LOGIN_URL);
}

set_message('ログインしました。');
if ($user['name'] === 'admin') {
    redirect_to(ADMIN_URL);
}
redirect_to(HOME_URL);
