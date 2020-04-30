<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';

$dbh = get_db_connect();
session_start();

if (is_logined() === true) {
    redirect_to(HOME_URL);
}

$token = get_post_data('token');
if (is_valid_csrf_token($token) === false) {
    set_error('不正なアクセスです');
    redirect_to(LOGIN_URL);
} else {
    $token = get_csrf_token();
}

$name = get_post_data('name');
$password = get_post_data('password');
$password_confirmation = get_post_data('password_confirmation');
$name_data = get_user_by_name($dbh, $name);


if (regist_user($dbh, $name, $password, $password_confirmation, $name_data) === true) {
    set_message('ユーザー登録が完了しました。');
    login_as($dbh, $name, $password);
    redirect_to(HOME_URL);
} else {
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
}
