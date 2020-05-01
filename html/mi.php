<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';

$dbh = get_db_connect();

session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

//viewファイル読み込み
include_once VIEW_PATH . 'mi_view.php';
