<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'admin_model.php';

session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$dbh = get_db_connect();

$user = get_login_user($dbh);

if (is_admin($user) === false) {
    redirect_to(LOGIN_URL);
}

$token = get_csrf_token();

$items = get_all_items($dbh);
// var_dump($items);

include_once VIEW_PATH . '/admin_view.php';
