<?php
require_once '../conf/const.php';
require_once '../model/common.php';

//DB接続
$dbh = get_db_connect();

session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

//viewファイル読み込み
include_once VIEW_PATH . 'purpose_view.php';